<?php

namespace Plugins\Hardware\Devices\Interfaces;


/**
 * Interface ProfileInterface
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Hardware
 */
interface ProfileInterface
{
    /**
     * Returns the device driver options list for this profile
     *
     * @return OptionsInterface
     */
    public function getOptions(): OptionsInterface;
}