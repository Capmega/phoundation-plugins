<?php

declare(strict_types=1);

namespace Plugins\Bookmarks\Library;


/**
 * Menu class
 *
 *
 *
 * @author Sven Olaf Oostenbrink <sven@medinet.ca>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Bookmarks
 */
class Menu extends \Phoundation\Web\Html\Components\Menu
{
    /**
     * Menu class constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->setSource([
            tr('Bookmarks') => [
                'icon' => '',
            ],
        ]);
    }
}
