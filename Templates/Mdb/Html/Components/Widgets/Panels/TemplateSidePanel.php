<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Widgets\Panels;

use Phoundation\Core\Core;
use Phoundation\Core\Sessions\Session;
use Phoundation\Utils\Config;
use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Script;
use Phoundation\Web\Html\Components\Widgets\Panels\SidePanel;
use Phoundation\Web\Html\Enums\EnumJavascriptWrappers;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\UrlBuilder;


/**
 * Class TemplateSidePanel
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateSidePanel extends TemplateRenderer
{
    /**
     * SidePanel class constructor
     */
    public function __construct(SidePanel $element)
    {
        parent::__construct($element);
    }


    /**
     * Renders and returns the sidebar
     *
     * @return string|null
     */
    public function render(): ?string
    {
//        return '<nav data-mdb-sidenav-init
//  id="sidenav-9"
//  class="sidenav sidenav-sm"
//  data-mdb-hidden="true"
//  data-mdb-accordion="true"
//>
//  <a
//    data-mdb-ripple-init
//    class="d-flex justify-content-center py-4 mb-3"
//    style="border-bottom: 2px solid #f5f5f5"
//    href="#!"
//    data-mdb-ripple-color="primary"
//  >
//    <img
//      id="MDB-logo"
//      src="https://mdbcdn.b-cdn.net/wp-content/uploads/2018/06/logo-mdb-jquery-small.webp"
//      alt="MDB Logo"
//      draggable="false"
//    />
//  </a>
//
//  <ul class="sidenav-menu px-2 pb-5">
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Overview</span></a
//      >
//    </li>
//
//    <li class="sidenav-item pt-3">
//      <span class="sidenav-subheading text-muted">Create</span>
//      <a class="sidenav-link" href="">
//        <i class="fas fa-plus fa-fw me-3"></i><span>Project</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-plus fa-fw me-3"></i><span>Database</span></a
//      >
//    </li>
//
//    <li class="sidenav-item pt-3">
//      <span class="sidenav-subheading text-muted">Manage</span>
//      <a class="sidenav-link" href="">
//        <i class="fas fa-cubes fa-fw me-3"></i><span>Projects</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-database fa-fw me-3"></i><span>Databases</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-stream fa-fw me-3"></i><span>Custom domains</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-code-branch fa-fw me-3"></i><span>Repositories</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-users fa-fw me-3"></i><span>Team</span></a
//      >
//    </li>
//
//    <li class="sidenav-item pt-3">
//      <span class="sidenav-subheading text-muted">Maintain</span>
//      <a class="sidenav-link" href="">
//        <i class="fas fa-chart-pie fa-fw me-3"></i><span>Analytics</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-sync fa-fw me-3"></i><span>Backups</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-shield-alt fa-fw me-3"></i><span>Security</span></a
//      >
//    </li>
//
//    <li class="sidenav-item pt-3">
//      <span class="sidenav-subheading text-muted">Admin</span>
//      <a class="sidenav-link" href="">
//        <i class="fas fa-money-bill fa-fw me-3"></i><span>Billing</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-file-contract fa-fw me-3"></i><span>License</span></a
//      >
//    </li>
//
//    <li class="sidenav-item pt-3">
//      <span class="sidenav-subheading text-muted">Tools</span>
//      <a class="sidenav-link" href="">
//        <i class="fas fa-hand-pointer fa-fw me-3"></i><span>Drag & drop builder</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-code fa-fw me-3"></i><span>Online code editor</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fas fa-copy fa-fw me-3"></i><span>SFTP</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fab fa-jenkins fa-fw me-3"></i><span>Jenkins</span></a
//      >
//    </li>
//    <li class="sidenav-item">
//      <a class="sidenav-link" href="">
//        <i class="fab fa-gitlab fa-fw me-3"></i><span>GitLab</span></a
//      >
//    </li>
//  </ul>
//</nav>';





//            . Script::new('
//      const sidenav = document.getElementById("full-screen-example");
//      const instance = mdb.Sidenav.getInstance(sidenav);
//
//      let innerWidth = null;
//
//      const setMode = (e) => {
//        // Check necessary for Android devices
//        if (window.innerWidth === innerWidth) {
//          return;
//        }
//
//        innerWidth = window.innerWidth;
//
//        if (window.innerWidth < 660) {
//          instance.changeMode("over");
//          instance.hide();
//        } else {
//          instance.changeMode("side");
//          instance.show();
//        }
//      };
//
//      setMode();
//
//      // Event listeners
//
//      window.addEventListener("resize", setMode);
//    ')
//    ->setJavascriptWrapper(null)
//    ->render();

























        $this->render = '   <nav data-mdb-sidenav-init id="sidenav-9" data-mdb-scroll-container="#scroll-container" class="sidenav sidenav-sm" data-mdb-hidden="true" data-mdb-accordion="true">
                              <a data-mdb-ripple-init class="d-flex justify-content-center py-4 mb-3" style="border-bottom: 2px solid #f5f5f5" href="#!" data-mdb-ripple-color="primary">
                                <img src="' . UrlBuilder::getImg('img/logos/' . Core::getProjectSeoName() . '/large.webp') . '" alt="' . tr(':project logo', [':project' => Strings::capitalize(Config::get('project.name'))]) . '" draggable="false">
                              </a>

                              <a data-mdb-ripple-init class="d-flex py-4 mb-3" style="border-bottom: 2px solid #f5f5f5" href="#!" data-mdb-ripple-color="primary">
                                ' . Session::getUser()->getPicture()
                                        ->getHtmlElement()
                                        ->setSrc(UrlBuilder::getImg('img/profiles/default.png'))
                                        ->setClass('img-circle elevation-2')
                                        ->setAlt(tr('Profile picture for :user', [':user' => Session::getUser()->getDisplayName()]))
                                        ->setWidth(32)
                                        ->setHeight(32)
                                        ->render() . Session::getUser()->getDisplayName() . '
                              </a>
                              ' . $this->component->getMenu()?->render() . '
                            </nav>';

        $this->render .= $this->component->getModals()?->render() . PHP_EOL;

        return parent::render();

        $this->render = ' <aside class="main-sidebar sidebar-dark-primary elevation-4">
                            <a href="' . UrlBuilder::getCurrent() . '" class="brand-link">
                              <img src="' . UrlBuilder::getImg('img/logos/' . Core::getProjectSeoName() . '/large.webp') . '" alt="' . tr(':project logo', [':project' => Strings::capitalize(Config::get('project.name'))]) . '" class="brand-image elevation-3" style="opacity: .8">
                            </a>
                            <div class="sidebar">
                              <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="image">
                                  ' . Session::getUser()->getPicture()
                                        ->getHtmlElement()
                                            ->setSrc(UrlBuilder::getImg('img/profiles/default.png'))
                                            ->setClass('img-circle elevation-2')
                                            ->setAlt(tr('Profile picture for :user', [':user' => Session::getUser()->getDisplayName()]))
                                            ->render() . '
                                </div>
                                <div class="info">
                                  <a href="' . (Session::getUser()->isGuest() ? '#' : UrlBuilder::getWww('/my/profile.html')) . '" class="d-block">' . Session::getUser()->getDisplayName() . '</a>
                                </div>
                              </div>
                              <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                  <input class="form-control form-control-sidebar" type="search" placeholder="' . tr('Search menu') . '" aria-label="' . tr('Search menu') . '">
                                  <div class="input-group-append">
                                    <button class="btn btn-sidebar">
                                      <i class="fas fa-search fa-fw"></i>
                                    </button>
                                  </div>
                                </div>
                                <div class="sidebar-search-results">
                                  <div class="list-group">
                                    <a href="#" class="list-group-item">
                                      <div class="search-title">
                                        <strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong>
                                      </div>
                                      <div class="search-path">
                                      </div>
                                    </a>
                                  </div>
                                </div>
                              </div>
                        
                              <!-- Sidebar Menu -->
                              <nav>
                                ' . $this->component->getMenu()?->render() . '                                
                              </nav>
                              <!-- /.sidebar-menu -->
                            </div>
                            <!-- /.sidebar -->
                          </aside>';

        $this->render .= $this->component->getModals()?->render() . PHP_EOL;

        return parent::render();
    }
}
