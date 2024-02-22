<?php

declare(strict_types=1);


namespace Templates\Mdb\Html\Layouts;

use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\TemplateRenderer;


/**
 * MDB Plugin GridColumn class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
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
        if ($this->render_object->getForm()) {
            // Return content rendered in a form
            $this->render = '<div class="col' . ($this->render_object->getTier()->value ? '-' . Html::safe($this->render_object->getTier()->value) : '') . '-' . Html::safe($this->render_object->getSize()->value) . '">' . $this->render_object->getForm()->setContent($this->render_object->getContent())->render() . '</div>';
            $this->render_object->setForm(null);

            return parent::render();
        }

        $this->render = '<div class="col' . ($this->render_object->getTier()->value ? '-' . Html::safe($this->render_object->getTier()->value) : '') . '-' . Html::safe($this->render_object->getSize()->value) . '">' . $this->render_object->getContent() . '</div>';
        return parent::render();
    }
}