<?php
class KtmCore_Skstore_Model_System_Config_New
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'new', 'label'=>Mage::helper('adminhtml')->__('New')),
            array('value' => '', 'label'=>Mage::helper('adminhtml')->__('No')),
        );
    }
}