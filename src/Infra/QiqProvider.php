<?php
namespace Argo\Infra;

use Capsule\Di\Provider;
use Capsule\Di\Definitions;

use Qiq\Compiler\QiqCompiler;
use Qiq\Escape;
use Qiq\Helper;
use Qiq\HelperLocator;
use Qiq\TemplateLocator;

class QiqProvider implements Provider
{
    public const ESCAPE_ENCODING = 'Qiq\\Escape:encoding';

    public const HELPER_FACTORIES = 'Qiq\\HelperLocator:factories';

    public const TEMPLATE_PATHS = 'Qiq\\TemplateLocator:paths';

    public const TEMPLATE_EXTENSION = 'Qiq\\TemplateLocator:extension';

    public const TEMPLATE_COMPILER = 'Qiq\\TemplateLocator:compiler';

    public function provide(Definitions $def) : void
    {
        $this->setDefaults($def);

        $def->{Escape::CLASS}
            ->arguments([
                'encoding' => $def->get(self::ESCAPE_ENCODING)
            ]
        );

        $def->{HelperLocator::CLASS}
            ->arguments([
                'factories' => $def->get(self::HELPER_FACTORIES),
            ]);

        $def->{TemplateLocator::CLASS}
            ->arguments([
                'paths' => $def->get(self::TEMPLATE_PATHS),
                'compiler' => $def->get(
                    $def->get(self::TEMPLATE_COMPILER)
                ),
                'extension' => $def->get(self::TEMPLATE_EXTENSION),
            ]);
    }

    protected function setDefaults(Definitions $def) : void
    {
        $def->{self::ESCAPE_ENCODING} = 'utf-8';

        $def->{self::TEMPLATE_PATHS} = $def->array();

        $def->{self::TEMPLATE_EXTENSION} = '.php';

        $def->{self::TEMPLATE_COMPILER} = QiqCompiler::CLASS;

        $def->{self::HELPER_FACTORIES} = $def->array([
            'a'                     => $def->callableGet(Helper\EscapeAttr::CLASS),
            'anchor'                => $def->callableGet(Helper\Anchor::CLASS),
            'base'                  => $def->callableGet(Helper\Base::CLASS),
            'button'                => $def->callableGet(Helper\Button::CLASS),
            'c'                     => $def->callableGet(Helper\EscapeCss::CLASS),
            'checkboxField'         => $def->callableGet(Helper\CheckboxField::CLASS),
            'colorField'            => $def->callableGet(Helper\ColorField::CLASS),
            'dateField'             => $def->callableGet(Helper\DateField::CLASS),
            'datetimeField'         => $def->callableGet(Helper\DatetimeField::CLASS),
            'datetimeLocalField'    => $def->callableGet(Helper\DatetimeLocalField::CLASS),
            'dl'                    => $def->callableGet(Helper\Dl::CLASS),
            'emailField'            => $def->callableGet(Helper\EmailField::CLASS),
            'fileField'             => $def->callableGet(Helper\FileField::CLASS),
            'form'                  => $def->callableGet(Helper\Form::CLASS),
            'h'                     => $def->callableGet(Helper\EscapeHtml::CLASS),
            'hiddenField'           => $def->callableGet(Helper\HiddenField::CLASS),
            'image'                 => $def->callableGet(Helper\Image::CLASS),
            'imageButton'           => $def->callableGet(Helper\ImageButton::CLASS),
            'inputField'            => $def->callableGet(Helper\InputField::CLASS),
            'items'                 => $def->callableGet(Helper\Items::CLASS),
            'j'                     => $def->callableGet(Helper\EscapeJs::CLASS),
            'label'                 => $def->callableGet(Helper\Label::CLASS),
            'link'                  => $def->callableGet(Helper\Link::CLASS),
            'linkStylesheet'        => $def->callableGet(Helper\LinkStylesheet::CLASS),
            'meta'                  => $def->callableGet(Helper\Meta::CLASS),
            'metaHttp'              => $def->callableGet(Helper\MetaHttp::CLASS),
            'metaName'              => $def->callableGet(Helper\MetaName::CLASS),
            'monthField'            => $def->callableGet(Helper\MonthField::CLASS),
            'numberField'           => $def->callableGet(Helper\NumberField::CLASS),
            'ol'                    => $def->callableGet(Helper\Ol::CLASS),
            'passwordField'         => $def->callableGet(Helper\PasswordField::CLASS),
            'radioField'            => $def->callableGet(Helper\RadioField::CLASS),
            'rangeField'            => $def->callableGet(Helper\RangeField::CLASS),
            'resetButton'           => $def->callableGet(Helper\ResetButton::CLASS),
            'script'                => $def->callableGet(Helper\Script::CLASS),
            'searchField'           => $def->callableGet(Helper\SearchField::CLASS),
            'select'                => $def->callableGet(Helper\Select::CLASS),
            'submitButton'          => $def->callableGet(Helper\SubmitButton::CLASS),
            'telField'              => $def->callableGet(Helper\TelField::CLASS),
            'textarea'              => $def->callableGet(Helper\Textarea::CLASS),
            'textField'             => $def->callableGet(Helper\TextField::CLASS),
            'timeField'             => $def->callableGet(Helper\TimeField::CLASS),
            'u'                     => $def->callableGet(Helper\EscapeUrl::CLASS),
            'ul'                    => $def->callableGet(Helper\Ul::CLASS),
            'urlField'              => $def->callableGet(Helper\UrlField::CLASS),
            'weekField'             => $def->callableGet(Helper\WeekField::CLASS),
        ]);
    }
}
