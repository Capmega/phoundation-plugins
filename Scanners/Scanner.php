<?php

namespace Plugins\Scanners;

use Phoundation\Core\Core;
use Phoundation\Core\Sessions\Session;
use Phoundation\Data\DataEntry\Exception\DataEntryDeletedException;
use Phoundation\Data\DataEntry\Exception\DataEntryNotExistsException;
use Phoundation\Data\DataEntry\Interfaces\DataEntryInterface;
use Phoundation\Databases\Sql\Exception\SqlTableDoesNotExistException;
use Phoundation\Exception\OutOfBoundsException;
use Phoundation\Os\Processes\Commands\ScanImage;
use Phoundation\Utils\Arrays;
use Phoundation\Utils\Config;
use Phoundation\Utils\Strings;
use Plugins\Hardware\Devices\Device;
use Plugins\Hardware\Devices\Interfaces\ProfileInterface;
use Plugins\Hardware\Devices\Profile;
use Plugins\Hardware\Exception\InvalidDeviceClassException;


/**
 * Class Scanner
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Hardware
 */
class Scanner extends Device
{
    /**
     * DataEntry class constructor
     *
     * @param DataEntryInterface|string|int|null $identifier
     * @param string|null $column
     * @param bool|null $meta_enabled
     */
    public function __construct(DataEntryInterface|string|int|null $identifier = null, ?string $column = null, ?bool $meta_enabled = null)
    {
        parent::__construct();

        if ($this->getClass() !== 'scanner') {
            throw new InvalidDeviceClassException(tr('The specified device ":column=:identifier" is not a "scanner" class device', [
                ':column' => $column,
                ':identifier' => $identifier
            ]));
        }
    }


    /**
     * Returns a DataEntry object matching the specified identifier that MUST exist in the database
     *
     * This method also accepts DataEntry objects of the same class, in which case it will simply return the specified
     * object, as long as it exists in the database.
     *
     * If the DataEntry does not exist in the database, then this method will check if perhaps it exists as a
     * configuration entry. This requires DataEntry::$config_path to be set. DataEntries from configuration will be in
     * readonly mode automatically as they cannot be stored in the database.
     *
     * DataEntries from the database will also have their status checked. If the status is "deleted", then a
     * DataEntryDeletedException will be thrown
     *
     * @note The test to see if a DataEntry object exists in the database can be either DataEntry::isNew() or
     *       DataEntry::getId(), which should return a valid database id
     *
     * @param DataEntryInterface|string|int|null $identifier
     * @param string|null $column
     * @param bool $meta_enabled
     * @param bool $force
     * @return static
     */
    public static function get(DataEntryInterface|string|int|null $identifier, ?string $column = null, bool $meta_enabled = false, bool $force = false): static
    {
        $entry = parent::get($identifier, $column, $meta_enabled, $force);

        if ($entry->getClass() !== 'scanner') {
            throw new InvalidDeviceClassException(tr('The specified device ":column=:identifier" is not a "scanner" class device', [
                ':column' => $column,
                ':identifier' => $identifier
            ]));
        }

        return $entry;
    }


    /**
     * Returns a DataEntry object matching the specified identifier that MUST exist in the database
     *
     * This method also accepts DataEntry objects of the same class, in which case it will simply return the specified
     * object, as long as it exists in the database.
     *
     * If the DataEntry does not exist in the database, then this method will check if perhaps it exists as a
     * configuration entry. This requires DataEntry::$config_path to be set. DataEntries from configuration will be in
     * readonly mode automatically as they cannot be stored in the database.
     *
     * DataEntries from the database will also have their status checked. If the status is "deleted", then a
     * DataEntryDeletedException will be thrown
     *
     * @note The test to see if a DataEntry object exists in the database can be either DataEntry::isNew() or
     *       DataEntry::getId(), which should return a valid database id
     *
     * @param array $identifiers
     * @param bool $meta_enabled
     * @param bool $force
     * @return static|null
     */
    public static function find(array $identifiers, bool $meta_enabled = false, bool $force = false): ?static
    {
        $entry = parent::find($identifiers, $meta_enabled, $force);

        if ($entry->getClass() !== 'scanner') {
            throw new InvalidDeviceClassException(tr('The specified device "identifiers" is not a "scanner" class device', [
                ':identifiers' => Arrays::implodeWithKeys($identifiers, ',', '=')
            ]));
        }

        return $entry;
    }


    /**
     * Scan using the specified profile
     *
     * @param ProfileInterface|string|int $profile
     * @return $this
     */
    public function scan(ProfileInterface|string|int $profile): static
    {
        ScanImage::new()
            ->applyProfile(Profile::get($profile))
            ->scan();

        return $this;
    }
}
