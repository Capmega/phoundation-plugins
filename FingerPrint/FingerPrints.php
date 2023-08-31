<?php

namespace Plugins\FingerPrint;

use Phoundation\Data\DataEntry\DataList;
use Plugins\FingerPrint\Interfaces\FingerPrintsInterface;


/**
 * Class FingerPrint
 *
 * This class manages finger print access using the Fprint class
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2023 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Phoundation\Processes
 */
class FingerPrints extends DataList implements FingerPrintsInterface
{

    /**
     * @inheritDoc
     */
    public static function getTable(): string
    {
        return 'fingerprints';
    }

    /**
     * @inheritDoc
     */
    public static function getEntryClass(): string
    {
        return FingerPrint::class;
    }

    /**
     * @inheritDoc
     */
    public static function getUniqueField(): ?string
    {
        return 'users_id';
    }
}
