<?php

declare(strict_types=1);

namespace Templates\Mdb;

use Phoundation\Core\Plugins\Plugins;
use Phoundation\Utils\Config;
use Phoundation\Web\Html\Components\Widgets\Panels\BottomPanel;
use Phoundation\Web\Html\Components\Widgets\Panels\HeaderPanel;
use Phoundation\Web\Html\Components\Widgets\Panels\Interfaces\PanelsInterface;
use Phoundation\Web\Html\Components\Widgets\Panels\Panels;
use Phoundation\Web\Html\Components\Widgets\Panels\SidePanel;
use Phoundation\Web\Html\Components\Widgets\Panels\TopPanel;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Page;


/**
 * Class TemplateMdb template
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplatePage extends \Phoundation\Web\Html\Template\TemplatePage
{
    /**
     * Execute, builds and returns the page output, according to the template.
     *
     * Either use the default execution steps from parent::execute($target), or write your own execution steps here.
     * Once the output has been generated, it should be returned.
     *
     * @param string $target
     * @param bool $main_content_only
     * @return string|null
     */
    public function execute(string $target, bool $main_content_only = false): ?string
    {
        if (!Page::getLevels()) {
            Page::setPanelsObject($this->getAvailablePanelsObject());
            Plugins::start();
        }

        $body = $this->buildBody($target, $main_content_only);

        if ($main_content_only) {
            return $body;
        }

        // Build HTML and minify the output
        $output = $this->buildHtmlHeader();
        Page::htmlHeadersSent(true);

        if (Page::getBuildBodyWrapper()) {
            $output .=  '<body class="mdb-skin-custom" data-mdb-spy="scroll" data-mdb-target="#scrollspy" data-mdb-offset="250">' .
                            Page::getFlashMessages()->render() .
                            Page::getPanelsObject()->get('top', false)?->render() .
                            Page::getPanelsObject()->get('left')->render() .
                            $body .
                            Page::getPanelsObject()->get('bottom', false)?->render();
        } else {
            // Page requested that no body parts be built
            $output .= $body;
        }

        $output .= $this->buildHtmlFooters();
        $output  = Html::minify($output);

        // Build Template specific HTTP headers
        $this->buildHttpHeaders($output);
        return $output;
    }


    /**
     * Returns a Panels object with the available panels for this Template
     *
     * @return PanelsInterface
     */
    public function getAvailablePanelsObject(): PanelsInterface
    {
        return Panels::new()
            ->add(Config::getBoolean('web.panels.top.enabled'   , true) ? TopPanel::new()    : null, 'top')
            ->add(Config::getBoolean('web.panels.left.enabled'  , true) ? SidePanel::new()   : null, 'left')
            ->add(Config::getBoolean('web.panels.header.enabled', true) ? HeaderPanel::new() : null, 'header')
            ->add(Config::getBoolean('web.panels.bottom.enabled', true) ? BottomPanel::new() : null, 'bottom');
    }


    /**
     * Build the HTTP headers for the page
     *
     * @param string $output
     * @return void
     */
    public function buildHttpHeaders(string $output): void
    {
        Page::setContentType('text/html');
        Page::setDoctype('html');
    }


    /**
     * Build the HTML header for the page
     *
     * @return string|null
     */
    public function buildHtmlHeader(): ?string
    {
        // Set head meta data
        Page::setFavIcon();
        Page::setViewport('width=device-width, initial-scale=1');

        // Load basic MDB and fonts CSS
        Page::loadCss([
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
            'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap',
            'css/mdb',
            'css/mdb-fix',
            'css/phoundation',
        ], true);

        // Load configured CSS files
        Page::loadCss(Config::getArray('web.page.css', []));

        // Load basic MDB amd jQuery javascript libraries
        Page::loadJavascript('js/mdb,js/jquery/jquery');

        // Set basic page details
        Page::setPageTitle(tr('Phoundation platform'));
        Page::setFavIcon('img/favicons/project.png');

        // Set basic page details
        Page::setPageTitle(Config::get('project.name', tr('Phoundation project')) . ' (' . Page::getHeaderTitle() . ')');

        return Page::buildHtmlHeadTag();
    }


    /**
     * Build the HTML body
     *
     * @param string $target
     * @param bool $main_content_only
     * @return string|null
     */
    public function buildBody(string $target, bool $main_content_only = false): ?string
    {
        $body = parent::buildBody($target, $main_content_only);

        if ($main_content_only or !Page::getBuildBodyWrapper()) {
            return $body;
        }

        return '    <header>
                       ' . Page::getPanelsObject()->get('header', false)?->render() . '
                    </header>
                    <main class="pt-5 mdb-docs-layout">
                        <div class="container mt-5  mt-5  px-lg-5">
                            <div class="tab-content">
                                ' . $body . '
                            </div>
                        </div>
                    </main>';
    }
}
