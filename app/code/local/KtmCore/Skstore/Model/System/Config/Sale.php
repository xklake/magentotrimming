<?php
class KtmCore_Skstore_Model_System_Config_Sale
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'sale', 'label'=>Mage::helper('adminhtml')->__('Sale')),
            array('value' => 'percent', 'label'=>Mage::helper('adminhtml')->__('% Off')),
            array('value' => '', 'label'=>Mage::helper('adminhtml')->__('No')),
        );
    }
}