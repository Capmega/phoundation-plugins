<?php

namespace Plugins\Hardware\Devices;

use Phoundation\Data\DataEntry\DataEntry;
use Phoundation\Data\DataEntry\Definitions\Definition;
use Phoundation\Data\DataEntry\Definitions\DefinitionFactory;
use Phoundation\Data\DataEntry\Definitions\Interfaces\DefinitionsInterface;
use Phoundation\Data\DataEntry\Traits\DataEntryComments;
use Phoundation\Data\DataEntry\Traits\DataEntryDescription;
use Phoundation\Data\DataEntry\Traits\DataEntryDeviceObject;
use Phoundation\Data\DataEntry\Traits\DataEntryProfileObject;
use Phoundation\Data\DataEntry\Traits\DataEntryUnits;
use Phoundation\Data\Validator\Exception\ValidationFailedException;
use Phoundation\Data\Validator\Interfaces\ValidatorInterface;
use Phoundation\Utils\Arrays;
use Phoundation\Web\Html\Enums\InputType;


/**
 * Class Option
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Hardware
 */
class Option extends DataEntry
{
    use DataEntryComments;
    use DataEntryDescription;
    use DataEntryUnits;
    use DataEntryDeviceObject;
    use DataEntryProfileObject;


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
    public static function getDataEntryName(): string
    {
        return tr('Device driver option');
    }


    /**
     * @inheritDoc
     */
    public static function getUniqueColumn(): ?string
    {
        return 'key';
    }


    /**
     * Returns the key for this option
     *
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->getSourceColumnValue('string', 'key');
    }


    /**
     * Sets the key for this option
     *
     * @param string|null $key
     * @return static
     */
    public function setKey(?string $key): static
    {
        return $this->setSourceValue('key', $key);
    }


    /**
     * Returns the value for this option
     *
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->getSourceColumnValue('string', 'value');
    }


    /**
     * Sets the value for this option
     *
     * The value must either be one of the values option, or fall within the range for this option
     *
     * @param string|null $value
     * @return static
     */
    public function setValue(?string $value): static
    {
        if ($value) {
            $this->checkRange($value)
                 ->checkValues($value);
        }

        return $this->setSourceValue('value', get_null($value));
    }


    /**
     * Checks if the value is valid for this option
     *
     * @param string|null $value
     * @return $this
     */
    protected function checkValues(?string $value): static
    {
        $values = $this->getValues();

        if ($values) {
            $values = Arrays::force($values, ',');

            if (!in_array($value, $values)) {
                throw new ValidationFailedException(tr('Specified value ":value" for option ":option" is not one of required ":values"', [
                    ':value'  => $value,
                    ':values' => $values,
                    ':option' => $this->getKey()
                ]));
            }
        }

        return $this;
    }


    /**
     * Checks if the value is valid for this option
     *
     * @param string|null $value
     * @return static
     */
    protected function checkRange(?string $value): static
    {
        $range = $this->getRange();

        if ($range) {
            show($value);
            showdie($range);
            $range = Arrays::force($range, ',');

            if (!in_range($value, $range[0], $range[1])) {
                throw new ValidationFailedException(tr('Specified value ":value" for option ":option" is not within the required range of ":values"', [
                    ':value'  => $value,
                    ':values' => implode('...', $range),
                    ':option' => $this->getKey()
                ]));
            }
        }

        return $this;
    }


    /**
     * Returns the values for this option
     *
     * @return string|null
     */
    public function getValues(): ?string
    {
        return $this->getSourceColumnValue('string', 'values');
    }


    /**
     * Sets the values for this option
     *
     * @param string|null $values
     * @return static
     */
    public function setValues(?string $values): static
    {
        return $this->setSourceValue('values', $values);
    }


    /**
     * Returns the range for this option
     *
     * @return string|null
     */
    public function getRange(): ?string
    {
        return $this->getSourceColumnValue('string', 'range');
    }


    /**
     * Sets the range for this option
     *
     * @param string|null $range
     * @return static
     */
    public function setRange(?string $range): static
    {
        return $this->setSourceValue('range', $range);
    }


    /**
     * Returns the default for this option
     *
     * @return string|null
     */
    public function getDefault(): ?string
    {
        return $this->getSourceColumnValue('string', 'default');
    }


    /**
     * Sets the default for this option
     *
     * @param string|null $default
     * @return static
     */
    public function setDefault(?string $default): static
    {
        return $this->setSourceValue('default', $default);
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
                    // Validate the devices id
                    $validator->orColumn('device')->isDbId()->isQueryResult('SELECT `id` FROM `hardware_devices` WHERE `id` = :id AND `status` IS NULL', [
                        ':id' => '$devices_id'
                    ]);
                }))
            ->addDefinition(Definition::new($this, 'device')
                ->setOptional(true)
                ->setVirtual(true)
                ->setVisible(false)
                ->setSize(4)
                ->setInputType(InputType::select)
                ->addValidationFunction(function (ValidatorInterface $validator) {
                    // Validate the device name
                    $validator->orColumn('devices_id')->isVariable()->setColumnFromQuery('programs_id', 'SELECT `id` FROM `hardware_devices` WHERE `name` = :name AND `status` IS NULL', [
                        ':name' => '$device'
                    ]);
                })
                ->setLabel(tr('Device'))
                ->setHelpText(tr('The device this driver option belongs')))
            ->addDefinition(Definition::new($this, 'profiles_id')
                ->setVisible(true)
                ->setOptional(true)
                ->setSize(4)
                ->addValidationFunction(function (ValidatorInterface $validator) {
                    // Validate the programs id
                    $validator
                        ->xorColumn('profile')
                        ->isDbId()
                        ->isQueryResult('SELECT `id` FROM `hardware_profiles` WHERE `id` = :id AND `status` IS NULL', [
                            ':id' => '$profiles_id'
                        ]);
                }))
            ->addDefinition(Definition::new($this, 'profile')
                ->setOptional(true)
                ->setVirtual(true)
                ->setVisible(false)
                ->setSize(4)
                ->setInputType(InputType::select)
                ->addValidationFunction(function (ValidatorInterface $validator) {
                    // Validate the profile name
                    $validator
                        ->xorColumn('profiles_id')
                        ->isName()
                        ->setColumnFromQuery('programs_id', 'SELECT `id` FROM `hardware_profiles` WHERE `name` = :name AND `status` IS NULL', [
                            ':name' => '$profile'
                        ]);
                })
                ->setLabel(tr('Profile'))
                ->setHelpText(tr('The profile this driver option belongs to')))
            ->addDefinition(Definition::new($this, 'key')
                ->setOptional(false)
                ->setVisible(true)
                ->setSize(4)
                ->setMaxlength(32))
            ->addDefinition(Definition::new($this, 'value')
                ->setOptional(false)
                ->setVisible(true)
                ->setSize(4)
                ->setMaxlength(255))
            ->addDefinition(Definition::new($this, 'default')
                ->setOptional(false)
                ->setVisible(true)
                ->setSize(4)
                ->setMaxlength(255))
            ->addDefinition(Definition::new($this, 'range')
                ->setOptional(false)
                ->setVisible(true)
                ->setSize(4)
                ->setMaxlength(64))
            ->addDefinition(Definition::new($this, 'values')
                ->setOptional(false)
                ->setVisible(true)
                ->setSize(4)
                ->setMaxlength(255))
            ->addDefinition(Definition::new($this, 'units')
                ->setOptional(true)
                ->setVisible(true)
                ->setSize(4)
                ->setMaxlength(16))
            ->addDefinition(DefinitionFactory::getComments($this)
                ->setMaxlength(255))
            ->addDefinition(DefinitionFactory::getDescription($this)
                ->setMaxlength(2048));
    }
}