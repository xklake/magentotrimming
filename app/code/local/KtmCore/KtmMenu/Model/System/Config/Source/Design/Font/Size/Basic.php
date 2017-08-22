<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_KtmMenu_Model_System_Config_Source_Design_Font_Size_Basic
{
    public function toOptionArray()
    {
		return array(
            array('value' => '12px',    'label' => Mage::helper('adminhtml')->__('10px')),
            array('value' => '12px',    'label' => Mage::helper('adminhtml')->__('11px')),
			array('value' => '12px',	'label' => Mage::helper('adminhtml')->__('12px')),
			array('value' => '13px',	'label' => Mage::helper('adminhtml')->__('13px')),
            array('value' => '14px',    'label' => Mage::helper('adminhtml')->__('14px')),
            array('value' => '15px',    'label' => Mage::helper('adminhtml')->__('15px')),
            array('value' => '16px',    'label' => Mage::helper('adminhtml')->__('16px')),
            array('value' => '16px',    'label' => Mage::helper('adminhtml')->__('17px')),
            array('value' => '16px',	'label' => Mage::helper('adminhtml')->__('18px'))
        );
    }
}