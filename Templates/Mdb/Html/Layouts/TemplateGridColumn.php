<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Layouts;

use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Layouts\GridColumn;
use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Class TemplateGridColumn
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateGridColumn extends TemplateRenderer
{
    /**
     * GridColumn class constructor
     */
    public function __construct(GridColumn $element)
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
        $class        = $this->render_object->getClass();
        $this->render = '   <div class="col' . (Html::safe($this->render_object->getTier()->value) ? '-' . Html::safe($this->render_object->getTier()->value) : '') . '-' . Html::safe($this->render_object->getSize()->value) . ($class ? ' ' . $class : '') . '">';

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