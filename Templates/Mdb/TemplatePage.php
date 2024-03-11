<?php

declare(strict_types=1);

namespace Templates\Mdb;

use Phoundation\Core\Log\Log;
use Phoundation\Core\Plugins\Plugins;
use Phoundation\Utils\Config;
use Phoundation\Web\Html\Components\Forms\DataEntryFormRows;
use Phoundation\Web\Html\Components\Widgets\Panels\BottomPanel;
use Phoundation\Web\Html\Components\Widgets\Panels\HeaderPanel;
use Phoundation\Web\Html\Components\Widgets\Panels\Interfaces\PanelsInterface;
use Phoundation\Web\Html\Components\Widgets\Panels\Panels;
use Phoundation\Web\Html\Components\Widgets\Panels\SidePanel;
use Phoundation\Web\Html\Components\Widgets\Panels\TopPanel;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Interfaces\WebRequestInterface;
use Phoundation\Web\Interfaces\WebResponseInterface;
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
     * @param WebRequestInterface $request
     * @param WebResponseInterface $response
     * @return string|null
     */
    public function execute(WebRequestInterface $request, WebResponseInterface $response): ?string
    {
        if (Page::isExecutedDirectly()) {
            // Generate panels used by the plugins, then start all plugins
            Page::setPanelsObject($this->getAvailablePanelsObject());
            Plugins::start();
        }

        $body = $this->renderBody($request, $response);

        if ($request->getMainContentsOnly()) {
            return $body;
        }

        // Build HTML and minify the output
        $output = $this->renderHtmlHeadTag();
        Page::htmlHeadersSent(true);

        if (Page::getBuildBodyWrapper()) {
            $output .=  '<body class="mdb-skin-custom" data-mdb-spy="scroll" data-mdb-target="#scrollspy" data-mdb-offset="250">' .
                            Page::getFlashMessages()->render() .
                            Page::getPanelsObject()->get('top', false)?->render() .
                            Page::getPanelsObject()->get('left')?->render() .
                            $body .
                            Page::getPanelsObject()->get('bottom', false)?->render();
        } else {
            // Page requested that no body parts be built
            $output .= $body;
        }

        $output .= $this->renderHtmlFooters();
        $output  = Html::minify($output);

        // Build Template specific HTTP headers
        $this->renderHttpHeaders($output);
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
    public function renderHttpHeaders(string $output): void
    {
        Page::setContentType('text/html');
        Page::setDoctype('html');
    }


    /**
     * Build the HTML header for the page
     *
     * @return string|null
     */
    public function renderHtmlHeadTag(): ?string
    {
        // Set head meta data
        Page::setFavIcon();
        Page::setViewport('width=device-width, initial-scale=1');

        // Load basic MDB and fonts CSS
        Page::loadCss([
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
            'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap',
            'mdb/css/mdb',
            'mdb/css/mdb-fix',
            'mdb/css/phoundation',
        ], true);

        // Load configured CSS files
        Page::loadCss(Config::getArray('templates.mdb.css', []));

        // Load basic MDB amd jQuery javascript libraries
        Page::loadJavascript('mdb/js/jquery,mdb/js/mdb.umd', prefix: true);

        // Set basic page details
        Page::setPageTitle(tr('Phoundation platform'));
        Page::setFavIcon('img/favicons/project.png');

        // Set basic page details
        Page::setPageTitle(Config::get('project.name', tr('Phoundation project')) . ' (' . Page::getHeaderTitle() . ')');

        return Page::renderHtmlHeadTag();
    }


    /**
     * Build the HTML body
     *
     * @param WebRequestInterface $request
     * @param WebResponseInterface $response
     * @return string|null
     */
    public function renderBody(WebRequestInterface $request, WebResponseInterface $response): ?string
    {
        DataEntryFormRows::setForceRows(true);

        $body = parent::renderBody($request, $response);

        if ($request->getMainContentsOnly() or !Page::getBuildBodyWrapper()) {
            return $body;
        }

        $horizontal_padding = 1;
        $vertical_padding   = 1;
        $horizontal_margin  = 1;
        $vertical_margin    = 1;

        return '    ' . Page::getPanelsObject()->get('header', false)?->render() . '
                    <main class="pt-' . $horizontal_padding . ' mdb-docs-layout">
                        <div class="container mt-' . $vertical_padding . ' mt-' . $horizontal_padding . ' px-lg-' . $horizontal_margin . '">
                            <div class="tab-content">
                                ' . $body . '
                            </div>
                        </div>
                    </main>';
    }
}
