<?php

declare(strict_types=1);


namespace Templates\None\Html\Layouts;

use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * None Plugin GridRow class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\None
 */
class GridRow extends TemplateRenderer
{
    /**
     * GridRow class constructor
     */
    public function __construct(\Phoundation\Web\Html\Layouts\GridRow $element)
    {
        parent::__construct($element);
    }


    /**
     * Render this grid row
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = '<div class="row">';

        if ($this->render_object->getForm()) {
            // Return content rendered in a form
            $render = '';

            foreach ($this->render_object->getSource() as $column) {
                $render .= $column->render();
            }

            $this->render .= $this->render_object->getForm()->setContent($render)->render();
            $this->render_object->setForm(null);
        } else {
            foreach ($this->render_object->getSource() as $column) {
                $this->render .= $column->render();
            }
        }

        $this->render .= '</div>';
        return parent::render();
    }
}