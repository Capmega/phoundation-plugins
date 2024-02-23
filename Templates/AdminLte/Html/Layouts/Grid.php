<?php

declare(strict_types=1);


namespace Templates\AdminLte\Html\Layouts;

use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * AdminLte Plugin Grid class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
class Grid extends TemplateRenderer
{
    /**
     * Grid class constructor
     */
    public function __construct(\Phoundation\Web\Html\Layouts\Grid $element)
    {
        parent::__construct($element);
    }


    /**
     * Render the HTML for this grid
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $class        = $this->render_object->getClass();
        $this->render = '<div class="container-fluid' . ($class ? ' ' . $class : '') . '">';

        if ($this->render_object->getForm()) {
            // Return content rendered in a form
            $render = '';

            foreach ($this->render_object->getSource() as $row) {
                $render .= $row->render();
            }

            $this->render .= $this->render_object->getForm()->setContent($render)->render();
            $this->render_object->setForm(null);
        } else {
            foreach ($this->render_object->getSource() as $row) {
                $this->render .= $row->render();
            }
        }

        $this->render .= '</div>';
        return parent::render();
    }
}