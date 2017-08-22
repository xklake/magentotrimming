<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_KtmMenu_Model_System_Config_Source_Css_Background_Repeat
{
    public function toOptionArray()
    {
		return array(
			array('value' => 'no-repeat',	'label' => Mage::helper('adminhtml')->__('no-repeat')),
            array('value' => 'repeat',		'label' => Mage::helper('adminhtml')->__('repeat')),
            array('value' => 'repeat-x',	'label' => Mage::helper('adminhtml')->__('repeat-x')),
			array('value' => 'repeat-y',	'label' => Mage::helper('adminhtml')->__('repeat-y'))
        );
    }
}