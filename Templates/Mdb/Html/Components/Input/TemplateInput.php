<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Input;

use Phoundation\Utils\Arrays;
use Phoundation\Web\Html\Components\Input\InputHidden;
use Phoundation\Web\Html\Components\Input\Interfaces\InputInterface;
use Phoundation\Web\Html\Components\Input\Interfaces\InputSelectInterface;
use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Class TemplateInput
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateInput extends TemplateRenderer
{
    /**
     * Input class constructor
     */
    public function __construct(InputInterface $element)
    {
        $element->addClass('form-control');
        parent::__construct($element);
    }


    /**
     * Renders this input element
     *
     * @return string|null
     */
    public function render(): ?string
    {
        // TODO Can non input elements render as hidden?
        // Hidden elements render as an <input hidden>
        if ($this->component->getHidden()) {
            // Select input have multiple values support
            if ($this->component instanceof InputSelectInterface) {
                $return = null;

                foreach (Arrays::force($this->component->getSelected()) as $key => $value) {
                    $return .= InputHidden::new()
                        ->setName($this->component->getName())
                        ->setValue($key)
                        ->render();
                }

                return $return;
            }

            return InputHidden::new()
                ->setName($this->component->getName())
                ->setValue($this->component->getValue())
                ->render();
        }

        $return = parent::render();
        $icon   = $this->component->getIcon();

        if ($icon) {
            // Add an icon
            $return = $icon->render() . ' ' . $return;
        }

        if ($this->component->getClearButton()) {
            // Add a clear button
            $return .= '<span class="trailing pe-auto clear d-none" tabindex="0">✕</span>';
        }


        return $return;
    }
}