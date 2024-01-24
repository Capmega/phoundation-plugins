<?php

declare(strict_types=1);

namespace Plugins\Hardware\Devices;

use Phoundation\Core\Log\Log;
use Phoundation\Data\DataEntry\DataList;
use Phoundation\Os\Processes\Commands\ScanImage;
use Plugins\Hardware\Devices\Interfaces\DevicesInterface;


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
class Devices extends DataList implements DevicesInterface
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
     * @param bool $update_options
     * @return $this
     */
    public function search(bool $update_options): static
    {
        $devices = ScanImage::new()->listDevices();

        foreach ($devices as $device) {
            if (Device::notExists($device['device'], 'device')) {
                $device['class'] = 'scanner';
                $device['name']  = $device['device'];
                $device['url']   = $device['device'];

                Log::action(tr('Adding ":class" class device ":device"', [
                    ':class'  => $device['class'],
                    ':device' => $device['device']
                ]));

                $device = Device::fromSource($device)->save();

                if ($update_options) {
                    $device->updateOptions();
                }

                $this->add($device);
            }
        }

        return $this;
    }


    /**
     * Will truncate the table associated with this list
     *
     * @return $this
     */
    public function truncate(): static
    {
        Options::new()->truncate();
        return parent::truncate();
    }
}
