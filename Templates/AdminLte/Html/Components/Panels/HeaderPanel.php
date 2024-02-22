<?php

declare(strict_types=1);

namespace Templates\AdminLte\Html\Components\Panels;

use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\TemplateRenderer;
use Phoundation\Web\Page;


/**
 * Class HeaderPanel
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
class HeaderPanel extends TemplateRenderer
{
    /**
     * HeaderPanel class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Panels\HeaderPanel $element)
    {
        parent::__construct($element);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        if ($this->render_object->getMini()) {
            return '<section class="content-header"></section>';
        }

        $title       = Page::getHeaderTitle();
        $sub_title   = Page::getHeaderSubTitle();
        $breadcrumbs = Page::getBreadCrumbs()?->render();

        if (!$title) {
            throw new OutOfBoundsException(tr('Cannot render HeaderPanel, no title specified'));
        }

        return '    <section class="content-header">
                      <div class="container-fluid">
                        <div class="row mb-2">
                          <div class="col-sm-6">
                            <h1>
                              ' . Html::safe($title) . '
                              ' . ($sub_title ? '<small>' . Html::safe($sub_title) . '</small>' : '') . '
                            </h1>
                          </div>
                          <div class="col-sm-6">
                            ' . $breadcrumbs .  '
                          </div>
                        </div>
                      </div>
                    </section>';
    }
}