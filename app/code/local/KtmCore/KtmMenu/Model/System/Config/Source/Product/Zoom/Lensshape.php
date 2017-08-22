<?php

/**
 * @copyright   Copyright (C) 2015 IcoTheme.com. All Rights Reserved.
 */
class KtmCore_KtmMenu_Model_System_Config_Source_Product_Zoom_Lensshape
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'round', 'label' => Mage::helper('adminhtml')->__('Round')),
            array('value' => 'square', 'label' => Mage::helper('adminhtml')->__('Square'))
        );
    }
}