<?php

declare(strict_types=1);


namespace Templates\AdminLte\Html\Components\Widgets\Boxes;

use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\TemplateRenderer;


/**
 * AdminLte Plugin InfoBoxBg class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
class InfoBoxBg extends TemplateRenderer
{
    /**
     * InfoBoxBg class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Widgets\Boxes\InfoBoxBg $element)
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
        $this->render = '   <div class="info-box bg-' . Html::safe($this->render_object->getMode()->value) . '">
                              <span class="info-box-icon"><i class="far ' . Html::safe($this->render_object->getIcon()) . '"></i></span>
                
                              <div class="info-box-content">
                                <span class="info-box-text">' . Html::safe($this->render_object->getTitle()) . '</span>
                                <span class="info-box-number">' . Html::safe($this->render_object->getValue()) . '</span>
                
                                ' . (($this->render_object->getProgress() !== null) ? ' <div class="progress">
                                                                                    <div class="progress-bar" style="width: ' . Html::safe($this->render_object->getProgress()) . '%"></div>
                                                                                  </div>' : '') . '
                                <span class="progress-description">
                                  ' . Html::safe($this->render_object->getDescription()) . '
                                </span>
                              </div>
                              <!-- /.info-box-content -->
                            </div>';

        return parent::render();
    }
}