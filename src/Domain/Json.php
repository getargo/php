<?php
declare(strict_types=1);

namespace Argo\Domain;

use Argo\Domain\Exception;
use Seld\JsonLint\JsonParser;
use JsonException;

class Json
{
    public static function encode(/* array|object */ $data) : string
    {
        return json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    }

    public static function decode(
        string $text,
        bool $assoc = false,
        int $depth = 512
    ) /* : array|object */
    {
        try {
            return json_decode($text, $assoc, $depth, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $lint = (new JsonParser())->lint($text);
            throw new Exception\InvalidJson($lint->getMessage());
        }
    }

    public static function recode(
        /* array|object */ $data,
        bool $assoc = false,
        int $depth = 512
    ) /* : array|object */
    {
        $recode = self::decode(self::encode($data), $assoc, $depth);
        return is_array($recode) && empty($recode) && ! $assoc
            ? (object) $recode
            : $recode;
    }
}
