<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Forms;

use Phoundation\Data\DataEntry\Definitions\Interfaces\DefinitionInterface;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Utils\Config;
use Phoundation\Web\Html\Components\Forms\Interfaces\DataEntryFormColumnInterface;
use Phoundation\Web\Html\Components\Widgets\Tooltips\Tooltip;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Class DataEntryForm
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateDataEntryFormColumn extends TemplateRenderer
{
    /**
     * FilterForm class constructor
     */
    public function __construct(DataEntryFormColumnInterface $element)
    {
        parent::__construct($element);
    }


    public function render(): ?string
    {
        $definition = $this->component->getDefinition();
        $component  = $this->component->getColumnComponent();

        if (!$definition) {
            throw new OutOfBoundsException(tr('Cannot render form component, no definition specified'));
        }

        if (!$component) {
            throw new OutOfBoundsException(tr('Cannot render form component, no component specified'));
        }

        if (is_object($component)) {
            $component = $component->render();
        }

        if ($definition->getHidden()) {
            // Hidden elements don't display anything beyond the hidden <input>
            return $component;
        }

        switch ($definition->getElement()) {
            case 'input':
                $label    = null;
                $mdb_init = ' data-mdb-input-init=""';
                break;

            case 'select':
                $this->render .= '<div class="' . static::getBottomMarginString() . Html::safe($definition->getSize() ? 'col-sm-' . $definition->getSize() : 'col') . ($definition->getVisible() ? '' : ' invisible') . ($definition->getDisplay() ? '' : ' nodisplay') . '">'.
                                    $component .
                                   ($definition->getLabel() ? ' <label class="form-label select-label" for="' . Html::safe($definition->getColumn()) . '">
                                                                  ' . Html::safe($definition->getLabel()) . '
                                                                </label>' : '') . '
                                </div>';
                return parent::render();

            default:
                $label    = null;
                $mdb_init = '';
        }

        $this->render .= match ($definition->getInputType()?->value) {
            default    => '  <div class="' . static::getBottomMarginString() . Html::safe($definition->getSize() ? 'col-sm-' . $definition->getSize() : 'col') . ($definition->getVisible() ? '' : ' invisible') . ($definition->getDisplay() ? '' : ' nodisplay') . '">
                                 <div' . $mdb_init . ' class="form-outline">
                                     ' . $component . '
                                     <label class="form-label' . $label . '" for="' . Html::safe($definition->getColumn()) . '">
                                       ' . Html::safe($definition->getLabel()) . '
                                     </label>
                                 </div>
                             </div>',
//            ' . $this->renderTooltip($definition) . '
        };

        return parent::render();
    }


    /**
     * Renders and returns the tooltip for the specified definition
     *
     * @param DefinitionInterface $definition
     * @return string|null
     */
    protected function renderTooltip(DefinitionInterface $definition): ?string
    {
        if ($definition->getTooltip()) {
            // Render and return the tooltip
            return Tooltip::new()
                ->setTitle($definition->getTooltip())
                ->setUseIcon(true)
                ->render();
        }

        return null;
    }


    /**
     * Returns the string required for the bottom margin
     *
     * @return string|null
     */
    protected static function getBottomMarginString(): ?string
    {
        static $return = null;

        if ($return === null) {
            $margin = Config::getInteger('templates.mdb.forms.margins.bottom', 4);

            if ($margin) {
                $return = ' mb-' . $margin . ' ';

            } else {
                $return = '';
            }
        }

        return $return;
    }
}