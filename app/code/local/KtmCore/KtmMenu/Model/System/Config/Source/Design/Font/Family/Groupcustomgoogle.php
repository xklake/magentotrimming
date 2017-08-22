<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_KtmMenu_Model_System_Config_Source_Design_Font_Family_Groupcustomgoogle
{
    public function toOptionArray()
    {
		return array(
			array('value' => 'custom', 'label' => Mage::helper('adminhtml')->__('Custom...')),
			array('value' => 'google', 'label' => Mage::helper('adminhtml')->__('Google Fonts...')),
			array('value' => 'Arial, "Helvetica Neue", Helvetica, sans-serif', 'label' => Mage::helper('adminhtml')->__('Arial, "Helvetica Neue", Helvetica, sans-serif')),
			array('value' => 'Georgia, serif', 'label' => Mage::helper('adminhtml')->__('Georgia, serif')),
			array('value' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif', 'label' => Mage::helper('adminhtml')->__('"Lucida Sans Unicode", "Lucida Grande", sans-serif')),
			array('value' => '"Palatino Linotype", "Book Antiqua", Palatino, serif', 'label' => Mage::helper('adminhtml')->__('"Palatino Linotype", "Book Antiqua", Palatino, serif')),
			array('value' => 'Tahoma, Geneva, sans-serif', 'label' => Mage::helper('adminhtml')->__('Tahoma, Geneva, sans-serif')),
			array('value' => '"Trebuchet MS", Helvetica, sans-serif', 'label' => Mage::helper('adminhtml')->__('"Trebuchet MS", Helvetica, sans-serif')),
			array('value' => 'Verdana, Geneva, sans-serif', 'label' => Mage::helper('adminhtml')->__('Verdana, Geneva, sans-serif')),
        );
    }
}