<?php

declare(strict_types=1);


namespace Templates\None\Html\Layouts;

use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\TemplateRenderer;


/**
 * None Plugin GridColumn class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\None
 */
class GridColumn extends TemplateRenderer
{
    /**
     * GridColumn class constructor
     */
    public function __construct(\Phoundation\Web\Html\Layouts\GridColumn $element)
    {
        parent::__construct($element);
    }


    /**
     * Render this grid column
     *
     * @return string|null
     */
    public function render(): ?string
    {
        $this->render = '   <div class="col' . ($this->render_object->getTier()->value ? '-' . Html::safe($this->render_object->getTier()->value) : '') . '-' . Html::safe($this->render_object->getSize()->value) . '">';

        if ($this->render_object->getForm()) {
            // Return column content rendered in a form
            $this->render .= $this->render_object->getForm()->setContent($this->render_object->getContent())->render();
            $this->render_object->setForm(null);
        } else {
            $this->render .= $this->render_object->getContent();
        }

        $this->render .= '</div>';
        return parent::render();
    }
}