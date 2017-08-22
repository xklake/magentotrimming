<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

$installer = $this;
$installer->startSetup();

$installer->setCustomerAttributes(
    array(
        'ktmcore_socialconnect_tid' => array(
            'type' => 'text',
            'visible' => false,
            'required' => false,
            'user_defined' => false                
        ),            
        'ktmcore_socialconnect_ttoken' => array(
            'type' => 'text',
            'visible' => false,
            'required' => false,
            'user_defined' => false                
        )          
    )
);

// Install our custom attributes
$installer->installCustomerAttributes();

// Remove our custom attributes (for testing)
//$installer->removeCustomerAttributes();

$installer->endSetup();