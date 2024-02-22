<?php

declare(strict_types=1);


namespace Templates\None\Html\Components\Input;

use Phoundation\Web\Html\TemplateRenderer;


/**
 * Class InputMultiButtonText
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\None
 */
class InputMultiButtonText extends TemplateRenderer
{
    /**
     * InputMultiButtonText class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Input\InputMultiButtonText $element)
    {
        parent::__construct($element);
    }


    /**
     * Renders and returns the HTML for this object
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $options = '';

        // Build the options list
        foreach ($this->render_object->getSource() as $url => $label) {
            if (str_starts_with($label, '#')) {
                // Any label starting with # is a divider
                $options .= '<li class="dropdown-divider"></li>';
            } else {
                $options .= '<li class="dropdown-item"><a href="' . $url . '">' . $label . '</a></li>';
            }
        }

        // Render the entire object
        $this->render = '   <div class="input-group input-group-lg mb-3">
                                <div class="input-group-prepend">
                                ' . $this->render_object->getButton()->render() . '                                
                                <ul class="dropdown-menu" style="">
                                    ' . $options . '
                                </ul>
                                </div>
                                
                                ' . $this->render_object->getInput()->render() . '
                            </div>';

        return parent::render();
    }
}
