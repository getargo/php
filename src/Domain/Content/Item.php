<?php
declare(strict_types=1);

namespace Argo\Domain\Content;

use Argo\Domain\Exception;
use Argo\Domain\Json;
use Argo\Domain\Storage;
use JsonSerializable;

abstract class Item implements JsonSerializable
{
    abstract public static function absId(string $relId) : string;

    public static function assertId(string $id) : void
    {
        $type = trim(strrchr(static::CLASS, '\\'), '\\');

        if (trim($id) === '') {
            throw new Exception\InvalidData("{$type} ID cannot be blank");
        }

        if (! preg_match('/^[\/a-z0-9-]+$/', $id)) {
            throw new Exception\InvalidData("{$type} ID has invalid characters; use only a-z, 0-9, and dashes.");
        }

        if (trim($id, '/') !== $id) {
            throw new Exception\InvalidData("{$type} ID cannot begin or end with slashes: {$id}");
        }

        if (strpos($id, '//') !== false) {
            throw new Exception\InvalidData("{$type} ID cannot have contiguous slashes: {$id}");
        }
    }

    public static function normalize(string $string) : string
    {
        return preg_replace(
            '/[^a-z0-9-]/',
            '',
            strtolower(preg_replace(
                '/[\s-]+/',
                '-',
                $string
            ))
        );
    }

    public static function titleize(string $str) : string
    {
        return ucwords(str_replace(['-', '/'], ' ', $str));
    }

    protected $id;

    protected $relId;

    protected $type;

    protected $href;

    protected $data;

    public function __construct(string $id, array $data = [])
    {
        static::assertId($id);
        $this->id = $id;
        $this->relId = $this->getRelId();
        $this->type = strtolower(substr(strrchr(static::CLASS, '\\'), 1));
        $this->href = "/{$id}/";

        $data += [
            'title' => null,
            'author' => null,
            'created' => null,
            'updated' => [],
            'markup' => 'markdown',
        ];

        $this->data = (object) $data;
        $this->fill($data);
    }

    public function __get(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }

        if (property_exists($this->data, $key)) {
            return $this->data->$key;
        }

        throw new Exception("Cannot get \$$key on content object.");
    }

    public function __isset(string $key)
    {
        return isset($this->$key) || isset($this->data->$key);
    }

    public function __set(string $key, /* mixed */ $val)
    {
        throw new Exception("Cannot set \$$key on content object.");
    }

    public function __unset(string $key)
    {
        throw new Exception("Cannot unset \$$key on content object.");
    }

    public function fill(array $data) : void
    {
        if (isset($data['title'])) {
            $this->data->title = $data['title'];
        }

        if (isset($data['author'])) {
            if (! preg_match('/^[a-z0-9-]+$/', $data['author'])) {
                throw new Exception\InvalidData("Author has invalid characters; use only a-z, 0-9, and dashes.");
            }
            $this->data->author = $data['author'];
        }

        if (isset($data['markup'])) {
            $data['markup'] = strtolower($data['markup']);

            if (! preg_match('/^[a-z]+$/', $data['markup'])) {
                throw new Exception\InvalidData("Markup type has invalid characters; use only a-z.");
            }

            if ($data['markup'] === 'json') {
                throw new Exception\InvalidData("Markup type may not be JSON.");
            }

            $this->data->markup = $data['markup'];
        }

        if (isset($data['tags'])) {
            if (! is_array($data['tags'])) {
                $tags = explode(',', $data['tags']);
            } else {
                $tags = $data['tags'];
            }

            foreach ($tags as &$tag) {
                $tag = trim($tag);
                if (! preg_match('/^[a-z0-9-]+$/', $tag)) {
                    throw new Exception\InvalidData("Tag '{$tag}' has invalid characters; use only a-z, 0-9, and dashes.");
                }
            }

            $this->data->tags = $tags;
        }
    }

    public function getText() : string
    {
        return Json::encode($this->data);
    }

    public function getBodyFile() : string
    {
        return "{$this->id}/argo.{$this->data->markup}";
    }

    public function jsonSerialize() /* : mixed */
    {
        $base = ['href' => $this->href, 'relId' => $this->relId];
        return $base + (array) $this->data;
    }

    public function getArrayCopy() : array
    {
        return get_object_vars($this);
    }

    public function toJson(array $extra = []) : string
    {
        $encoded = Json::encode($this);
        $decoded = Json::decode($encoded, true);
        return Json::encode($decoded + $extra);
    }

    protected function getRelId() : string
    {
        // type/foo/bar/baz => foo/bar/baz
        return substr(strchr($this->id, '/'), 1);
    }
}
