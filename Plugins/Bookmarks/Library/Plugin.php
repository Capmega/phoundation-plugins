<?php

declare(strict_types=1);

namespace Plugins\Bookmarks\Library;

use Phoundation\Web\Page;


/**
 * Class Plugin
 *
 *
 *
 * @author Sven Olaf Oostenbrink <sven@medinet.ca>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Bookmarks
 */
class Plugin extends \Phoundation\Core\Plugins\Plugin
{
    /**
     * Returns the plugin description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return tr('This plugin contains all functionalities specific to Bookmarks');
    }


    /**
     * @return void
     */
    public static function start(): void
    {
        Page::getMenus()->getPrimaryMenu()?->appendMenu(Menu::new());
    }
}
