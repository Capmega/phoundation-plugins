<?php

namespace Plugins\Hardware\Devices;

use Phoundation\Data\DataEntry\DataEntry;
use Phoundation\Data\DataEntry\Definitions\Definition;
use Phoundation\Data\DataEntry\Definitions\DefinitionFactory;
use Phoundation\Data\DataEntry\Definitions\Interfaces\DefinitionsInterface;
use Phoundation\Data\DataEntry\Traits\DataEntryComments;
use Phoundation\Data\DataEntry\Traits\DataEntryDescription;
use Phoundation\Data\DataEntry\Traits\DataEntryDeviceObject;
use Phoundation\Data\DataEntry\Traits\DataEntryName;
use Phoundation\Data\Validator\Interfaces\ValidatorInterface;
use Phoundation\Web\Html\Enums\InputType;
use Plugins\Hardware\Devices\Interfaces\OptionsInterface;
use Plugins\Hardware\Devices\Interfaces\ProfileInterface;


/**
 * Class Profile
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Hardware
 */
class Profile extends DataEntry implements ProfileInterface
{
    use DataEntryComments;
    use DataEntryDescription;
    use DataEntryDeviceObject;
    use DataEntryName;


    /**
     * The device driver options for this profile
     *
     * @var OptionsInterface
     */
    protected OptionsInterface $options;


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
    public static function getDataEntryName(): string
    {
        return tr('Hardware profile');
    }


    /**
     * @inheritDoc
     */
    public static function getUniqueColumn(): ?string
    {
        return null;
    }


    /**
     * Returns  if this profile is the default profile or not
     *
     * @return bool|null
     */
    public function getDefault(): ?bool
    {
        return $this->getSourceColumnValue('string', 'default');
    }


    /**
     * Sets if this profile is the default profile or not
     *
     * @param int|bool|null $default
     * @return static
     */
    public function setDefault(int|bool|null $default): static
    {
        return $this->setSourceValue('default', $default);
    }


    /**
     * Returns the device driver options list for this profile
     *
     * @return OptionsInterface
     */
    public function getOptions(): OptionsInterface
    {
        if (empty($this->options)) {
            $this->options = Options::new()->$this->setParent($this)->load();
        }

        return $this->options;
    }


    /**
     * Erase this profile from the database and with it all linked hardware device options
     *
     * @return static
     */
    public function erase(): static
    {
        // Erase all linked driver options
        sql()->query('DELETE FROM `hardware_options` WHERE `profiles_id` = :profiles_id', [
            ':profiles_id' => $this->getId()
        ]);

        return parent::erase();
    }


    /**
     * @inheritDoc
     */
    protected function setDefinitions(DefinitionsInterface $definitions): void
    {
        $definitions
            ->addDefinition(Definition::new($this, 'devices_id')
                ->setVisible(true)
                ->setOptional(true)
                ->setSize(4)
                ->addValidationFunction(function (ValidatorInterface $validator) {
                    // Validate the programs id
                    $validator->orColumn('device')->isDbId()->isQueryResult('SELECT `id` FROM `hardware_devices` WHERE `id` = :id AND `status` IS NULL', [':id' => '$devices_id']);
                }))
            ->addDefinition(Definition::new($this, 'device')
                ->setOptional(true)
                ->setVirtual(true)
                ->setVisible(false)
                ->setSize(4)
                ->setInputType(InputType::select)
                ->addValidationFunction(function (ValidatorInterface $validator) {
                    // Validate the device name
                    $validator->orColumn('devices_id')->isVariable()->setColumnFromQuery('programs_id', 'SELECT `id` FROM `hardware_devices` WHERE `name` = :name AND `status` IS NULL', [':name' => '$device']);
                })
                ->setLabel(tr('Device'))
                ->setHelpText(tr('The device this driver option belongs')))
            ->addDefinition(DefinitionFactory::getName($this))
            ->addDefinition(DefinitionFactory::getSeoName($this))
            ->addDefinition(Definition::new($this, 'default')
                ->setVisible(true)
                ->setOptional(true, false)
                ->setInputType(InputType::checkbox)
                ->setLabel(tr('Default profile'))
            )
            ->addDefinition(DefinitionFactory::getComments($this));
    }
}