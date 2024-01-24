<?php

declare(strict_types=1);

namespace Plugins\Hardware\Library;

use Phoundation\Web\Html\Components\Menu;
use Phoundation\Web\Page;
use Plugins\Phoundation\Components\ProfileImageMenu;


/**
 * Class Plugin
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Phoundation
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
        return tr('This is the hardware plugin, it manages hardware devices');
    }
}