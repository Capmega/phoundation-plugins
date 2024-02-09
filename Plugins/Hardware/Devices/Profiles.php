<?php

declare(strict_types=1);

namespace Plugins\Hardware\Devices;

use Phoundation\Data\DataEntry\DataList;
use Plugins\Hardware\Devices\Interfaces\ProfilesInterface;


/**
 * Class Profiles
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Hardware
 */
class Profiles extends DataList implements ProfilesInterface
{
    /**
     * Devices class constructor
     */
    public function __construct()
    {
        $this->id_is_unique_column = true;
        parent::__construct();
    }


    /**
     * @inheritDoc
     */
    public static function getTable(): string
    {
        return 'hardware_profiles';
    }


    /**
     * @inheritDoc
     */
    public static function getEntryClass(): string
    {
        return Profile::class;
    }


    /**
     * @inheritDoc
     */
    public static function getUniqueColumn(): ?string
    {
        return 'name';
    }
}