<?php

declare(strict_types=1);

namespace Plugins\Hardware\Devices;

use Phoundation\Core\Log\Log;
use Phoundation\Data\DataEntry\DataEntry;
use Phoundation\Data\DataEntry\Definitions\Definition;
use Phoundation\Data\DataEntry\Definitions\DefinitionFactory;
use Phoundation\Data\DataEntry\Definitions\Interfaces\DefinitionsInterface;
use Phoundation\Data\DataEntry\Traits\DataEntryClass;
use Phoundation\Data\DataEntry\Traits\DataEntryComments;
use Phoundation\Data\DataEntry\Traits\DataEntryDescription;
use Phoundation\Data\DataEntry\Traits\DataEntryDevice;
use Phoundation\Data\DataEntry\Traits\DataEntryManufacturer;
use Phoundation\Data\DataEntry\Traits\DataEntryModel;
use Phoundation\Data\DataEntry\Traits\DataEntryName;
use Phoundation\Data\DataEntry\Traits\DataEntryProduct;
use Phoundation\Data\DataEntry\Traits\DataEntryType;
use Phoundation\Data\DataEntry\Traits\DataEntryUrl;
use Phoundation\Data\DataEntry\Traits\DataEntryVendor;
use Phoundation\Data\Validator\Interfaces\ValidatorInterface;
use Phoundation\Os\Processes\Commands\ScanImage;
use Phoundation\Servers\Traits\DataEntryServer;
use Phoundation\Web\Html\Enums\InputType;
use Phoundation\Web\Html\Enums\InputTypeExtended;
use Plugins\Hardware\Devices\Interfaces\DeviceInterface;
use Plugins\Hardware\Devices\Interfaces\ProfilesInterface;
use Stringable;


/**
 * Class Device
 *
 *
 *
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Plugins\Hardware
 */
class Device extends DataEntry implements DeviceInterface
{
    use DataEntryClass;
    use DataEntryComments;
    use DataEntryDevice;
    use DataEntryDescription;
    use DataEntryManufacturer;
    use DataEntryModel;
    use DataEntryName;
    use DataEntryProduct;
    use DataEntryServer;
    use DataEntryType;
    use DataEntryUrl;
    use DataEntryVendor;


    /**
     * Device options
     *
     * @var ProfilesInterface $profiles
     */
    protected ProfilesInterface $profiles;


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
    public static function getDataEntryName(): string
    {
        return tr('Hardware device');
    }


    /**
     * @inheritDoc
     */
    public static function getUniqueColumn(): ?string
    {
        return 'name';
    }


    /**
     * Returns the vendor_sString for this object
     *
     * @return string|null
     */
    public function getVendorString(): ?string
    {
        return $this->getSourceValueTypesafe('string', 'vendor_string');
    }


    /**
     * Sets the vendor for this object
     *
     * @param Stringable|string|null $vendor
     * @return static
     */
    public function setVendorString(Stringable|string|null $vendor): static
    {
        return $this->setSourceValue('vendor_string', (string) $vendor);
    }


    /**
     * Returns the seo_vendor_sString for this object
     *
     * @return string|null
     */
    public function getSeoVendorString(): ?string
    {
        return $this->getSourceValueTypesafe('string', 'seo_vendor_string');
    }


    /**
     * Sets the seo_vendor for this object
     *
     * @param Stringable|string|null $seo_vendor
     * @return static
     */
    protected function setSeoVendorString(Stringable|string|null $seo_vendor): static
    {
        return $this->setSourceValue('seo_vendor_string', (string) $seo_vendor);
    }


    /**
     * Returns the seo_product_sString for this object
     *
     * @return string|null
     */
    public function getSeoProductString(): ?string
    {
        return $this->getSourceValueTypesafe('string', 'seo_product_string');
    }


    /**
     * Sets the seo_product for this object
     *
     * @param Stringable|string|null $seo_product
     * @return static
     */
    protected function setSeoProductString(Stringable|string|null $seo_product): static
    {
        return $this->setSourceValue('seo_product_string', (string) $seo_product);
    }


    /**
     * Returns the _product_sString for this object
     *
     * @return string|null
     */
    public function getProductString(): ?string
    {
        return $this->getSourceValueTypesafe('string', 'product_string');
    }


    /**
     * Sets the _product for this object
     *
     * @param Stringable|string|null $_product
     * @return static
     */
    public function setProductString(Stringable|string|null $_product): static
    {
        return $this->setSourceValue('product_string', (string) $_product);
    }


    /**
     * Returns the string for this object
     *
     * @return string|null
     */
    public function getString(): ?string
    {
        return $this->getSourceValueTypesafe('string', 'string');
    }


    /**
     * Sets the string for this object
     *
     * @param Stringable|string|null $_product
     * @return static
     */
    public function setString(Stringable|string|null $_product): static
    {
        return $this->setSourceValue('string', (string) $_product);
    }


    /**
     * Returns the seo string for this object
     *
     * @return string|null
     */
    public function getSeoString(): ?string
    {
        return $this->getSourceValueTypesafe('string', 'seo_string');
    }


    /**
     * Sets the seo string for this object
     *
     * @param Stringable|string|null $_product
     * @return static
     */
    protected function setSeoString(Stringable|string|null $_product): static
    {
        return $this->setSourceValue('seo_string', (string) $_product);
    }


    /**
     * Returns the libusb for this object
     *
     * @return string|null
     */
    public function getLibusb(): ?string
    {
        return $this->getSourceValueTypesafe('string', 'libusb');
    }


    /**
     * Sets the libusb for this object
     *
     * @param Stringable|string|null $_product
     * @return static
     */
    public function setLibusb(Stringable|string|null $_product): static
    {
        return $this->setSourceValue('libusb', (string) $_product);
    }


    /**
     * Returns the bus for this object
     *
     * @return string|null
     */
    public function getBus(): ?string
    {
        return $this->getSourceValueTypesafe('string', 'bus');
    }


    /**
     * Sets the bus for this object
     *
     * @param Stringable|string|null $_product
     * @return static
     */
    public function setBus(Stringable|string|null $_product): static
    {
        return $this->setSourceValue('bus', (string) $_product);
    }


    /**
     * Returns the default for this object
     *
     * @return bool|null
     */
    public function getDefault(): ?bool
    {
        return $this->getSourceValueTypesafe('bool', 'default');
    }


    /**
     * Sets the default for this object
     *
     * @param int|bool|null $_product
     * @return static
     */
    public function setDefault(int|bool|null $_product): static
    {
        return $this->setSourceValue('default', (bool) $_product);
    }


    /**
     * Searches for driver options for this device and stores them in the database
     *
     * @return $this
     */
    public function updateOptions(): static
    {
        // Delete the default profile
        Profile::find([
            'devices_id' => $this->getId(),
            'name'       => 'options'
        ], exception: false)?->erase();

        // Create new default profile
        $profile = Profile::new()
            ->setDevicesId($this->getId())
            ->setName('options')
            ->save();

        Log::action(tr('Adding driver options for ":class" class device ":name"', [
            ':class' => $this->getClass(),
            ':name'  => $this->getName()
        ]));

        $options = $profile->getOptions();
        $found   = ScanImage::new()->listOptions($this->getDevice());

        foreach ($found as $option) {
            $options->add(Option::fromSource($option)
                ->setDevicesId($this->getId())
                ->setProfilesId($profile->getId())
                ->save());
        }

        Log::success(tr('Added ":count" driver options for ":class" class device ":device"', [
            ':count'  => $options->getCount(),
            ':class'  => $this->getClass(),
            ':device' => $this->getDevice()
        ]));

        return $this;
    }


    /**
     * @return ProfilesInterface
     */
    public function getProfiles(): ProfilesInterface
    {
        if (empty($this->profiles)) {
            $this->profiles = Profiles::new()->setParent($this)->load();
        }

        return $this->profiles;
    }


    /**
     * @inheritDoc
     */
    protected function setDefinitions(DefinitionsInterface $definitions): void
    {
        $definitions
            ->addDefinition(DefinitionFactory::getServersId($this))
            ->addDefinition(DefinitionFactory::getServer($this))
            ->addDefinition(DefinitionFactory::getName($this)
                ->setOptional(false)
                ->setInputType(InputTypeExtended::name)
                ->setSize(12)
                ->setMaxlength(64)
                ->setHelpText(tr('The name for this role'))
                ->addValidationFunction(function (ValidatorInterface $validator) {
                    $validator->isUnique(tr('value ":name" already exists', [':name' => $validator->getSelectedValue()]));
                }))
            ->addDefinition(DefinitionFactory::getSeoName($this))
            ->addDefinition(Definition::new($this, 'class')
                ->setOptional(false)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setSource([
                    'scanner'   => tr('Scanner'),
                    'printer'   => tr('Printer'),
                    'webcam'    => tr('Webcam'),
                    'biometric' => tr('Biometric'),
                ])
                ->setMaxlength(9)
                ->setLabel(tr('Class')))
            ->addDefinition(Definition::new($this, 'type')
                ->setOptional(false)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Type')))
            ->addDefinition(Definition::new($this, 'vendor')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setMaxlength(32)
                ->setSize(3)
                ->setLabel(tr('Vendor')))
            ->addDefinition(Definition::new($this, 'vendor_string')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Vendor string')))
            ->addDefinition(Definition::new($this, 'seo_vendor_string')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setVisible(false)
                ->setMaxlength(32))
            ->addDefinition(Definition::new($this, 'vendor')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Vendor')))
            ->addDefinition(Definition::new($this, 'manufacturer')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Manufacturer')))
            ->addDefinition(Definition::new($this, 'model')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Model')))
            ->addDefinition(Definition::new($this, 'product')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Product')))
            ->addDefinition(Definition::new($this, 'product_string')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Product string')))
            ->addDefinition(Definition::new($this, 'seo_product_string')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setVisible(false)
                ->setMaxlength(32))
            ->addDefinition(Definition::new($this, 'libusb')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Libusb')))
            ->addDefinition(Definition::new($this, 'bus')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(32)
                ->setLabel(tr('Bus')))
            ->addDefinition(Definition::new($this, 'device')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(128)
                ->setLabel(tr('Device')))
            ->addDefinition(Definition::new($this, 'string')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(128)
                ->setLabel(tr('String')))
            ->addDefinition(Definition::new($this, 'seo_string')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setVisible(false)
                ->setSize(3)
                ->setMaxlength(128))
            ->addDefinition(Definition::new($this, 'url')
                ->setOptional(true)
                ->setInputType(InputType::text)
                ->setSize(3)
                ->setMaxlength(2048)
                ->setLabel(tr('URL')))
            ->addDefinition(Definition::new($this, 'default')
                ->setOptional(true)
                ->setInputType(InputType::checkbox)
                ->setSize(3)
                ->setMaxlength(2048)
                ->setLabel(tr('Default device')))
            ->addDefinition(DefinitionFactory::getDescription($this))
            ->addDefinition(DefinitionFactory::getComments($this));
    }
}
