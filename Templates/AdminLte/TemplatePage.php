<?php

declare(strict_types=1);


namespace Templates\AdminLte;

use Phoundation\Utils\Config;
use Phoundation\Web\Html\Components\Footer;
use Phoundation\Web\Html\Components\Modals\SignInModal;
use Phoundation\Web\Html\Components\SidePanel;
use Phoundation\Web\Html\Components\TopPanel;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Http\UrlBuilder;
use Phoundation\Web\Page;


/**
 * AdminLte template class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\AdminLte
 */
class TemplatePage extends \Phoundation\Web\Html\Template\TemplatePage
{
    /**
     * Execute, builds and returns the page output according to the template.
     *
     * Either use the default execution steps from parent::execute($target), or write your own execution steps here.
     * Once the output has been generated it should be returned.
     *
     * @param string $target
     * @param bool $main_content_only
     * @return string|null
     */
    public function execute(string $target, bool $main_content_only = false): ?string
    {
        return parent::execute($target, $main_content_only);
    }


    /**
     * Build the HTTP headers for the page
     *
     * @param string $output
     * @return void
     *
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
            'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
            'adminlte/plugins/fontawesome-free-6.4.0-web/css/all',
            'adminlte/plugins/fontawesome-free-6.4.0-web/css/regular',
//            'adminlte/plugins/fontawesome-free-6.4.0-web/css/v4-shim',
            'adminlte/css/adminlte',
            'adminlte/css/phoundation',
            'adminlte/plugins/overlayScrollbars/css/OverlayScrollbars',
            'adminlte/css/phoundation'
        ], true);

        // Load configured CSS files
        Page::loadCss(Config::getArray('web.page.css', []));

        // Load basic MDB amd jQuery javascript libraries
        Page::loadJavascript([
            'adminlte/plugins/jquery/jquery',
            'adminlte/plugins/jquery-ui/jquery-ui',
            'adminlte/plugins/bootstrap/js/bootstrap.bundle',
            'adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars',
            'adminlte/js/adminlte'
        ], null, true);

        // Set basic page details
        Page::setPageTitle(Config::get('project.name', tr('Phoundation platform')) . ' (' . Page::getHeaderTitle() . ')');

        return Page::buildHeaders();
    }


    /**
     * Build the page header
     *
     * @return string|null
     */
    public function buildPageHeader(): ?string
    {
        return '<body class="sidebar-mini' . (Config::get('web.panels.sidebar.collapsed', false) ? ' sidebar-collapse' : '') . '" style="height: auto;">
                    <div class="wrapper">
                        ' . Page::getFlashMessages()->render() . '
                        ' . $this->buildTopPanel() . '
                        ' . $this->buildSidePanel();
    }


    /**
     * Build the page footer
     *
     * @return string|null
     */
    public function buildPageFooter(): ?string
    {
        return      Footer::new()->render() . '
                </div>';
    }


    /**
     * Build the HTML footer
     *
     * @return string|null
     */
    public function buildHtmlFooter(): ?string
    {
        if (Page::getBuildBody()) {
            return        Page::buildFooters() . '
                      </body>
                  </html>';
        }

        return     Page::buildFooters() . '
               </html>';
    }


    /**
     * Build the HTML menu
     *
     * @return string|null
     */
    public function buildMenu(): ?string
    {
        return null;
    }


    /**
     * Build the HTML body
     *
     * @param string $target
     * @return string|null
     */
    public function buildBody(string $target): ?string
    {
        $body = parent::buildBody($target);

        if (Page::getBuildBody()) {
            $body = '   <div class="' . Page::getClass('content-wrapper', 'content-wrapper') .  '" style="min-height: 1518.06px;">
                           ' . $this->buildBodyHeader() . '
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            ' . $body . '
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>';
        }

        return $body;
    }


    /**
     * @return string|null
     */
    public function buildProfileImage(): ?string
    {
        // TODO: Implement buildProfileImage() method.
    }


    /**
     * Builds and returns the top panel HTML
     *
     * @return string|null
     */
    protected function buildTopPanel(): ?string
    {
        $panel = TopPanel::new();

        $panel->getNotificationsDropDown()
            ->setStatus('UNREAD')
            ->setNotifications(null)
            ->setNotificationsUrl('/notifications/notification-:ID.html')
            ->setAllNotificationsUrl('/notifications/unread.html');

        $panel->getMessagesDropDown()
            ->setMessages(null)
            ->setMessagesUrl('/messages/unread.html');

        $panel->getLanguagesDropDown()
            ->setLanguages(null)
            ->setSettingsUrl('/settings.html');

        return $panel->render();
    }


    /**
     * Builds and returns the sidebar HTML
     *
     * @return string|null
     */
    protected function buildSidePanel(): ?string
    {
        $sign_in = new SignInModal();
        $sign_in
            ->useForm(true)
            ->getForm()
                ->setId('form-sign-in')
                ->setMethod('post')
                ->setAction(UrlBuilder::getAjax('sign-in'));

        $panel = SidePanel::new();
        $panel->setMenu(Page::getMenus()->getPrimaryMenu());
        $panel->getModals()
            ->addModal('sign-in', $sign_in);

        return $panel->render();
    }


    /**
     * Builds the body header
     *
     * @return string
     */
    protected function buildBodyHeader(): string
    {
        $sub_title = Page::getHeaderSubTitle();

        $html = '   <section class="content-header">
                      <div class="container-fluid">
                        <div class="row mb-2">
                          <div class="col-sm-6">
                            <h1>
                              ' . Page::getHeaderTitle() . '
                              ' . ($sub_title ? '<small>' . Html::safe($sub_title) . '</small>' : '') . '
                            </h1>
                          </div>
                          <div class="col-sm-6">
                            ' . Page::getBreadCrumbs()?->render() .  '
                          </div>
                        </div>
                      </div>
                    </section>';

        return $html;
    }
}
