<?php

/**
 * @copyright   Copyright (C) 2015 IcoTheme.com. All Rights Reserved.
 */
class KtmCore_KtmMenu_Model_System_Config_Source_Product_Zoom_Type
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'lens', 'label' => Mage::helper('adminhtml')->__('Lens')),
            array('value' => 'inner', 'label' => Mage::helper('adminhtml')->__('Inner'))
        );
    }
}