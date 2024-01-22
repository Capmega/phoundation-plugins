<?php

namespace Plugins\Scanners;

use Phoundation\Data\DataEntry\Definitions\Interfaces\DefinitionsInterface;
use Plugins\Hardware\Devices\Device;


class Scanner extends Device
{

    /**
     * @inheritDoc
     */
    public static function getTable(): string
    {
        // TODO: Implement getTable() method.
    }

    /**
     * @inheritDoc
     */
    public static function getDataEntryName(): string
    {
        // TODO: Implement getDataEntryName() method.
    }

    /**
     * @inheritDoc
     */
    public static function getUniqueColumn(): ?string
    {
        // TODO: Implement getUniqueColumn() method.
    }

    /**
     * @inheritDoc
     */
    protected function setDefinitions(DefinitionsInterface $definitions): void
    {
        // TODO: Implement setDefinitions() method.
    }
}
