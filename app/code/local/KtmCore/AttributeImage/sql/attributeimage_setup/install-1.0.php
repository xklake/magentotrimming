<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn(
    $installer->getTable('eav/attribute_option'),
    'image',
    'VARCHAR(255) NULL DEFAULT NULL COMMENT "Attribute Image"'
);
$installer->getConnection()->addColumn(
    $installer->getTable('eav/attribute_option'),
    'thumb',
    'VARCHAR(255) NULL DEFAULT NULL COMMENT "Attribute Image Thumb"'
);