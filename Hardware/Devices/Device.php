<?php

declare(strict_types=1);

namespace Plugins\Hardware\Devices;

use Phoundation\Data\DataEntry\Definitions\Interfaces\DefinitionsInterface;

class Device extends \Phoundation\Data\DataEntry\DataEntry
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
    public static function getUniqueField(): ?string
    {
        // TODO: Implement getUniqueField() method.
    }

    /**
     * @inheritDoc
     */
    protected function setDefinitions(DefinitionsInterface $definitions): void
    {
        // TODO: Implement setDefinitions() method.
    }
}
