<?php

declare(strict_types=1);

namespace Plugins\Hardware\Devices;

use Phoundation\Data\DataEntry\DataList;
use Phoundation\Exception\OutOfBoundsException;
use Plugins\Hardware\Devices\Interfaces\OptionsInterface;


/**
 * Class Options
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Hardware
 */
class Options extends DataList implements OptionsInterface
{
    /**
     * Options class constructor
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
        return 'hardware_options';
    }


    /**
     * @inheritDoc
     */
    public static function getEntryClass(): string
    {
        return Option::class;
    }


    /**
     * @inheritDoc
     */
    public static function getUniqueColumn(): ?string
    {
        return 'key';
    }


//    /**
//     * Load the id list from the database
//     *
//     * @param bool $clear
//     * @return static
//     */
//    public function load(bool $clear = true): static
//    {
//        if (empty($this->parent)) {
//            throw new OutOfBoundsException(tr('Cannot load options, no parent profile specified'));
//        }
//
//        $this->source = sql()->list('SELECT   `hardware_options`.`key` AS `identifier`,
//                                                    `hardware_options`.*
//                                           FROM     `hardware_options`
//                                           WHERE    `hardware_options`.`profiles_id`  = :profiles_id
//                                           ORDER BY `hardware_options`.`key` ASC', [
//            ':profiles_id' => $this->parent->getId()
//        ]);
//
//        return $this;
//    }
}