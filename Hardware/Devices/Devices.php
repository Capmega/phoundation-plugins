<?php

declare(strict_types=1);

namespace Plugins\Hardware\Devices;

use Phoundation\Data\DataEntry\DataList;
use Phoundation\Os\Processes\Commands\ScanImage;


/**
 * Class Devices
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Hardware
 */
class Devices extends DataList
{

    /**
     * @inheritDoc
     */
    public static function getTable(): string
    {
        return 'hardware_devices';
    }

    /**
     * @inheritDoc
     */
    public static function getEntryClass(): string
    {
        return Device::class;
    }

    /**
     * @inheritDoc
     */
    public static function getUniqueColumn(): ?string
    {
        return null;
    }


    /**
     * Scans for known hardware devices and registers them in the database
     *
     * @return $this
     */
    public function search(): static
    {
        $devices = ScanImage::new()->listDevices();

        foreach ($devices as $device) {
            if (Device::notExists($device['device'], 'device')) {
                $this->add(Device::fromSource($device)
                    ->save()
                    ->searchOptions());
            }
        }

        return $this;
    }
}
