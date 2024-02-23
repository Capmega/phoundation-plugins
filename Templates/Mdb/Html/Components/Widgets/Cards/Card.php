<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Widgets\Cards;

use Phoundation\Enums\EnumOrientation;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;


/**
 * Mdb Plugin Card class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class Card extends TemplateRenderer
{
    /**
     * Card class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Widgets\Cards\Card $element)
    {
        parent::__construct($element);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $tabs = $this->render_object->getTabsObject(false);

        if ($tabs and ($tabs->getOrientation() === EnumOrientation::top)) {
            $this->render = '   <div' . ($this->render_object->getId() ? ' id="' . $this->render_object->getId() . '"' : '') . ' class="card ' . ($this->render_object->getClass() ? $this->render_object->getClass() . ' ' : null) . ($this->render_object->getGradient() ? 'gradient-' . Html::safe($this->render_object->getGradient()) : '') . ($this->render_object->getMode()->value ? 'card-' . Html::safe($this->render_object->getMode()->value) : '') . ($this->render_object->getOutline() ? ' card-outline' : '') . ($this->render_object->getBackground() ? 'bg-' . Html::safe($this->render_object->getBackground()) : '') . ' card-tabs">
                                    <div class="card-header p-0 p-1 border-bottom-0">
                                        <ul class="nav nav-tabs" id="" role="tablist">';

            if ($this->render_object->getTitle()) {
                $this->render .= '          <li class="pt-2 px-3"><h3 class="card-title">' . $this->render_object->getTitle() . '</h3></li>';
            }

            // Render tabs
            $active = true;

            foreach ($tabs as $tab) {
                $this->render .= '          <li class="nav-item">
                                                <a class="nav-link' . ($active ? ' active' : '') . '" id="' . $tab->getId() . '-tab" data-toggle="pill" href="#' . $tab->getId() . '" role="tab" aria-controls="' . $tab->getId() . '" aria-selected="' . ($active ? 'true' : 'false') . '">' . $tab->getLabel() . '</a>
                                            </li>';
                $active = false;
            }

            // Render transition tabs to tab contents
            $this->render .= '          </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">';

            // Render tab contents
            $active = true;

            foreach ($tabs as $tab) {
                $this->render .= '          <div class="tab-pane fade' . ($active ? ' active show' : '') . '" id="' . $tab->getId() . '" role="tabpanel" aria-labelledby="' . $tab->getId() . '-tab">
                                                ' . $tab->getContent() . '
                                            </div>';
                $active = false;
            }

            // Finish tab contents
            $this->render .= '          </div>
                                    </div>
                                </div>';

        } else {
            $this->render = '   <div' . ($this->render_object->getId() ? ' id="' . $this->render_object->getId() . '"' : '') . ' class="card ' . ($this->render_object->getClass() ? $this->render_object->getClass() . ' ' : null) . ($this->render_object->getGradient() ? 'gradient-' . Html::safe($this->render_object->getGradient()) : '') . ($this->render_object->getMode()->value ? 'card-' . Html::safe($this->render_object->getMode()->value) : '') . ($this->render_object->getOutline() ? ' card-outline' : '') . ($this->render_object->getBackground() ? 'bg-' . Html::safe($this->render_object->getBackground()) : '') . '">';

            if ($this->render_object->getReloadSwitch() or $this->render_object->getMaximizeSwitch() or $this->render_object->getCollapseSwitch() or $this->render_object->getCloseSwitch() or $this->render_object->getTitle() or $this->render_object->getHeaderContent()) {
                $this->render .= '  <div class="card-header">
                                        <h3 class="card-title">' . $this->render_object->getTitle() . '</h3>
                                        <div class="card-tools">
                                            ' . $this->render_object->getHeaderContent() . '
                                            ' . ($this->render_object->getReloadSwitch() ? '   <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                                                                                 <i class="fas fa-sync-alt"></i>
                                                                                               </button>' : '') . '
                                            ' . ($this->render_object->getMaximizeSwitch() ? ' <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                                                                 <i class="fas fa-expand"></i>
                                                                                               </button>' : '') . '
                                            ' . ($this->render_object->getCollapseSwitch() ? ' <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                                                 <i class="fas fa-' . ($this->render_object->getCollapsed() ? 'plus' : 'minus') . '"></i>
                                                                                               </button>' : '') . '
                                            ' . ($this->render_object->getCloseSwitch() ? '    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                                                                 <i class="fas fa-times"></i>
                                                                                               </button>' : '') . '                              
                                        </div>
                                    </div>';
            }

            $description   = $this->render_object->getDescription();
            $this->render .= '      <!-- /.card-header -->
                                    <div class="card-body">
                                        ' . ($description ? '<p class="card-description">' . $description . '</p>' : null) . '                                    
                                        ' . $this->render_object->getContent(). '
                                    </div>';

            if ($this->render_object->getButtons()) {
                $this->render .= '  <div class="card-footer">
                                        ' . $this->render_object->getButtons()->render() . '           
                                    </div>';
            }

            $this->render .= '  </div>';
        }

        return parent::render();
    }
}