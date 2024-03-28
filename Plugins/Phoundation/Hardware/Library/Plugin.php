<?php

declare(strict_types=1);

namespace Plugins\Phoundation\Hardware\Library;


/**
 * Class Plugin
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Phoundation\Phoundation
 */
class Plugin extends \Phoundation\Core\Plugins\Phoundation\Plugin
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
