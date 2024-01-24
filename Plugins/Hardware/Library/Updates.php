<?php

declare(strict_types=1);

namespace Plugins\Hardware\Library;

use Phoundation\Core\Libraries;
use Phoundation\Core\Locale\Language\Import;
use Phoundation\Core\Log\Log;


/**
 * Updates class
 *
 * This is the Init class for the Core library
 *
 * @see Libraries\Updates
 * @author Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @license http://opensource.org/licenses/GPL-2.0 GNU Public License, Version 2
 * @copyright Copyright (c) 2024 Sven Olaf Oostenbrink <so.oostenbrink@gmail.com>
 * @package Phoundation\Core
 */
class Updates extends Libraries\Updates
{
    /**
     * The current version for this library
     *
     * @return string
     */
    public function version(): string
    {
        return '0.20.0';
    }


    /**
     * The description for this library
     *
     * @return string
     */
    public function description(): string
    {
        return tr('This is the hardware plugin, it manages hardware devices');
    }


    /**
     * The list of version updates available for this library
     *
     * @return void
     */
    public function updates(): void
    {
        $this->addUpdate('0.20.0', function () {
            sql()->schema()->table('hardware_options')->drop();
            sql()->schema()->table('hardware_profiles')->drop();
            sql()->schema()->table('hardware_devices')->drop();

            // Add table for version control itself
            sql()->schema()->table('hardware_devices')->define()
                ->setColumns('
                    `id` bigint NOT NULL AUTO_INCREMENT,
                    `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `created_by` bigint DEFAULT NULL,
                    `meta_id` bigint NULL DEFAULT NULL,
                    `meta_state` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
                    `status` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
                    `servers_id` bigint DEFAULT NULL,
                    `name` varchar(128) NULL DEFAULT NULL,
                    `seo_name` varchar(128) NULL DEFAULT NULL,
                    `class` varchar(32) NULL DEFAULT NULL,
                    `type` varchar(32) NULL DEFAULT NULL,
                    `manufacturer` varchar(32) NULL DEFAULT NULL,
                    `model` varchar(32) NULL DEFAULT NULL,
                    `vendor` varchar(32) NULL DEFAULT NULL,
                    `vendor_string` varchar(32) NULL DEFAULT NULL,
                    `seo_vendor_string` varchar(32) NULL DEFAULT NULL,
                    `product` varchar(32) NULL DEFAULT NULL,
                    `product_string` varchar(32) NULL DEFAULT NULL,
                    `seo_product_string` varchar(32) NULL DEFAULT NULL,
                    `libusb` varchar(8) NULL DEFAULT NULL,
                    `bus` varchar(8) NULL DEFAULT NULL,
                    `device` varchar(128) NULL DEFAULT NULL,
                    `string` varchar(128) NULL DEFAULT NULL,
                    `seo_string` varchar(128) NULL DEFAULT NULL,
                    `url` varchar(2048) NULL DEFAULT NULL,
                    `default` TINYINT(1) NULL DEFAULT NULL,
                    `description` text NULL DEFAULT NULL,
                    `comments` text DEFAULT NULL,
                ')->setIndices('
                    PRIMARY KEY (`id`),
                    KEY `created_on` (`created_on`),
                    KEY `created_by` (`created_by`),
                    KEY `status` (`status`),
                    KEY `meta_id` (`meta_id`),
                    KEY `servers_id` (`servers_id`),
                    KEY `class` (`class`),
                    KEY `type` (`type`),
                    UNIQUE KEY `name` (`name`),
                    UNIQUE KEY `seo_name` (`seo_name`),
                    KEY `manufacturer` (`manufacturer`),
                    KEY `model` (`model`),
                    KEY `product` (`product`),
                ')->setForeignKeys('
                    CONSTRAINT `fk_hardware_devices_created_by` FOREIGN KEY (`created_by`) REFERENCES `accounts_users` (`id`) ON DELETE RESTRICT,
                    CONSTRAINT `fk_hardware_devices_meta_id` FOREIGN KEY (`meta_id`) REFERENCES `meta` (`id`) ON DELETE CASCADE,
                    CONSTRAINT `fk_hardware_devices_servers_id` FOREIGN KEY (`servers_id`) REFERENCES `servers` (`id`) ON DELETE CASCADE,
                ')->create();

            sql()->schema()->table('hardware_profiles')->define()
                ->setColumns('
                    `id` bigint NOT NULL AUTO_INCREMENT,
                    `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `created_by` bigint DEFAULT NULL,
                    `meta_id` bigint NULL DEFAULT NULL,
                    `meta_state` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
                    `status` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
                    `devices_id` bigint NOT NULL,
                    `name` varchar(128) NULL DEFAULT NULL,
                    `seo_name` varchar(128) NULL DEFAULT NULL,
                    `default` tinyint(1) NOT NULL,
                    `comments` text DEFAULT NULL,
                ')->setIndices('
                    PRIMARY KEY (`id`),
                    KEY `created_on` (`created_on`),
                    KEY `created_by` (`created_by`),
                    KEY `status` (`status`),
                    KEY `meta_id` (`meta_id`),
                    KEY `devices_id` (`devices_id`),
                    KEY `default` (`default`),
                    UNIQUE KEY `devices_id_name` (`devices_id`, `name`),
                    UNIQUE KEY `devices_id_seo_name` (`devices_id`, `seo_name`),
                ')->setForeignKeys('
                    CONSTRAINT `fk_hardware_profiles_created_by` FOREIGN KEY (`created_by`) REFERENCES `accounts_users` (`id`) ON DELETE RESTRICT,
                    CONSTRAINT `fk_hardware_profiles_meta_id` FOREIGN KEY (`meta_id`) REFERENCES `meta` (`id`) ON DELETE CASCADE,
                    CONSTRAINT `fk_hardware_profiles_devices_id` FOREIGN KEY (`devices_id`) REFERENCES `hardware_devices` (`id`) ON DELETE CASCADE,
                ')->create();

            sql()->schema()->table('hardware_options')->define()
                ->setColumns('
                    `id` bigint NOT NULL AUTO_INCREMENT,
                    `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `created_by` bigint DEFAULT NULL,
                    `meta_id` bigint NULL DEFAULT NULL,
                    `meta_state` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
                    `status` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
                    `devices_id` bigint NOT NULL,
                    `profiles_id` bigint NOT NULL,
                    `key` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
                    `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
                    `default` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
                    `range` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
                    `values` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
                ')->setIndices('
                    PRIMARY KEY (`id`),
                    KEY `created_on` (`created_on`),
                    KEY `created_by` (`created_by`),
                    KEY `status` (`status`),
                    KEY `meta_id` (`meta_id`),
                    KEY `devices_id` (`devices_id`),
                    KEY `profiles_id` (`profiles_id`),                    
                    KEY `key` (`key`),
                ')->setForeignKeys('
                    CONSTRAINT `fk_hardware_options_created_by` FOREIGN KEY (`created_by`) REFERENCES `accounts_users` (`id`) ON DELETE RESTRICT,
                    CONSTRAINT `fk_hardware_options_meta_id` FOREIGN KEY (`meta_id`) REFERENCES `meta` (`id`) ON DELETE CASCADE,
                    CONSTRAINT `fk_hardware_options_devices_id` FOREIGN KEY (`devices_id`) REFERENCES `hardware_devices` (`id`) ON DELETE CASCADE,
                    CONSTRAINT `fk_hardware_options_profiles_id` FOREIGN KEY (`profiles_id`) REFERENCES `hardware_profiles` (`id`) ON DELETE CASCADE,
                ')->create();
        });
    }
}
