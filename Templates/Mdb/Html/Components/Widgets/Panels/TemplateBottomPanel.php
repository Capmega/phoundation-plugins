<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Widgets\Panels;

use Phoundation\Core\Core;
use Phoundation\Utils\Config;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\UrlBuilder;
use Phoundation\Web\Page;


/**
 * Class TemplateBottomPanel
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateBottomPanel extends TemplateRenderer
{
    /**
     * BottomPanel class constructor
     */
    public function __construct(\Phoundation\Web\Html\Components\Widgets\Panels\BottomPanel $element)
    {
        parent::__construct($element);
    }


    /**
     * @inheritDoc
     */
    public function render(): ?string
    {
        $phoudation = '<a href="https://phoundation.org/">Phoundation</a>';
        $adminlte   = tr('template :name', [':name' => '<a href="https://adminlte.io/">' . tr('Mdb') . '</a>']);
        $project    = '<a href="' . UrlBuilder::getCurrentDomainRootUrl() . '">' . Config::getString('project.name', 'Phoundation') . '</a>';

        return '  <footer class="bg-body-tertiary">
                    <div class="p-3" style="background-color: rgba(0, 0, 0, 0.05);">
                      <b>' . tr(':project using :phoundation (:adminlte)', [':project' => $project, ':phoundation' => $phoudation, ':adminlte' => $adminlte]) . '</b> ' . Core::FRAMEWORKCODEVERSION . '
                      <span class="float-end"><strong>Copyright © ' . Config::getString('project.copyright', '2024') . ' <a href="' . Config::getString('project.owner.url', 'https://phoundation.org') . '" target="_blank">' . Config::getString('project.owner.name', 'Phoundation') . '</a>.</strong> All rights reserved. <br></span>
                    </div>
                  </footer>';
    }
}