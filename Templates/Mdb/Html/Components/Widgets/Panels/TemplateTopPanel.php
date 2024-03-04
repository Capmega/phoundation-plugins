<?php

declare(strict_types=1);

namespace Templates\Mdb\Html\Components\Widgets\Panels;

use Phoundation\Core\Sessions\Session;
use Phoundation\Utils\Strings;
use Phoundation\Web\Html\Components\Icons\Icon;
use Phoundation\Web\Html\Components\Input\Interfaces\RenderInterface;
use Phoundation\Web\Html\Enums\EnumDisplayMode;
use Phoundation\Web\Html\Html;
use Phoundation\Web\Html\Template\TemplateRenderer;
use Phoundation\Web\Http\UrlBuilder;
use Templates\Mdb\Exception\MdbException;


/**
 * Class TemplateTopPanel
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Templates\Mdb
 */
class TemplateTopPanel extends TemplateRenderer
{
    /**
     * Renders and returns the top panel
     *
     * @return string|null
     */
    public function render(): ?string
    {
        // TODO Change this hard coded menu below for a flexible one
//        $left_menu = $this->element->getMenu()?->render();

        // If impersonated, change top panel color and add an impersonation message
        if (Session::isImpersonated()) {
            $this->component->setMode(EnumDisplayMode::danger);
            $message = tr('(Impersonated by ":user")', [':user' => Session::getRealUser()->getDisplayName()]);

        } else {
            $this->component->setMode(EnumDisplayMode::white);
        }

        // Top level message?
        if (isset($message)) {
            $message = '    <li class="nav-item d-none d-sm-inline-block">
                              <a href="#" class="nav-link">' . Html::safe($message) . '</a>
                            </li>';
        }

        // Build the left menu
        $left_menu = '    <ul class="navbar-nav">
                            <li class="nav-item">
                              <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                            </li>';

        if ($this->component->keyExists('menu')) {
            foreach ($this->component->get('menu') as $label => $url) {
                $left_menu .= ' <li class="nav-item d-none d-sm-inline-block">
                                  <a href="' . Html::safe($url) . '" class="nav-link">' . Html::safe($label) . '</a>
                                </li>';
            }
        }

        // Add the optional extra message and finish the left menu
        $left_menu .=       isset_get($message) . '
                          </ul>';

        // Build the top panel with the left menu in it
        $this->render = ' <nav class="navbar navbar-expand-lg navbar-' . Html::safe($this->component->getBootstrapBackgroundColor()->value) . ' bg-body-tertiary">
                            <!-- Left navbar links -->
                            ' . $left_menu . '                    
                            <!-- Right navbar links -->
                            <ul class="navbar-nav ml-auto">';

        foreach ($this->component->getElementsObject() as $element) {
            $element_type = Strings::until($element, '-');

            switch ($element) {
                case 'search':
                    $content = '  <form class="d-flex input-group w-auto">
                                    <input type="search" class="form-control rounded" placeholder="' . tr('Search') . '" aria-label="' . tr('Search') . '" aria-describedby="search-addon" />
                                    <span class="input-group-text border-0" id="search-addon">
                                      <i class="fas fa-search"></i>
                                    </span>
                                  </form>';
                    break;

                case 'logo':
                    $content = $this->component->getLogos()->get($element_type)->render();
                    break;

                case 'messages':
                    $content = $this->component->getMessagesDropDown()->render();
                    break;

                case 'notifications':
                    $content = $this->component->getNotificationsDropDown()->render();
                    break;

                case 'languages':
                    $content = $this->component->getLanguagesDropDown()->render();
                    break;

                case 'menu':
                    $content = $this->component->getMenus()->get($element_type)->render();
                    break;

                case 'breadcrumbs':
                    $content = $this->component->getBreadcrumbs()->get($element_type)->render();
                    break;

                case 'text':
                    $content = $this->component->getTexts()->get($element_type)->render();
                    break;

                case 'button':
                    $content = $this->component->getButtons()->get($element_type)->render();
                    break;

                case 'avatar':
                    $content = $this->component->getAvatars()->get($element_type)->render();
                    break;

                case 'icon':
                    $content = $this->component->getIcons()->get($element_type)->render();
                    break;

                case 'full-screen':
                    $content = Icon::new()->setContent('expand-arrows-alt')->render();
                    break;

                case 'control-sidebar':
                    $content = '<li class="nav-item">
                                  <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                                    <i class="fas fa-th-large"></i>
                                  </a>
                                </li>';
                    break;

                case 'sign-out':
                    $content = Icon::new()
                        ->setContent('fa-sign-out-alt')
                        ->setAnchor(UrlBuilder::getWww('sign-out.html'))
                        ->render();
                    break;

                default:
                    // This is a custom element. Must be either a render-able object, or a callback that returns HTML
                    if ($element instanceof RenderInterface) {
                        $content = $element->render();

                    } elseif (is_callable($element)) {
                        $content = $element();

                    } else {
                        throw new MdbException(tr('Unknown top panel element ":element" specified', [
                            ':element' => $element
                        ]));
                    }
            }

            $this->render .= ' <div class="container-fluid">' . $content . '</div>';
        }

        $this->render .= '  </ul>
                          </nav>';

        return parent::render();
    }
}
