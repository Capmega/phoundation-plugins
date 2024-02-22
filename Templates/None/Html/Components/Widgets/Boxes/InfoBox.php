<?php

declare(strict_types=1);


namespace Templates\None\Html\Components\Widgets\Boxes;

use Phoundation\Web\Html\TemplateRenderer;


/**
 * None Plugin InfoBox class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\None
 */
class InfoBox extends TemplateRenderer
{
    /**
     * InfoBox class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Widgets\Boxes\InfoBox $element)
    {
        parent::__construct($element);
    }


    /**
     * Renders and returns the HTML for this SmallBox object
     *
     * @inheritDoc
     */
    public function render(): ?string
    {
        $this->render = '   <div class="info-box shadow-none">
                              <span class="info-box-icon bg-' . $this->render_object->getMode()->value . '"><i class="far ' . $this->render_object->getIcon() . '"></i></span>
                
                              <div class="info-box-content">
                                <span class="info-box-text">' . $this->render_object->getTitle() . '</span>
                                <span class="info-box-number">' . $this->render_object->getValue() . '</span>
                              </div>
                              ' . $this->render_object->getDescription() . '
                            </div>';

        return parent::render();
    }
}