<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Skstore_Model_System_Config_Source_Layout_Header_Header
{

    public function toOptionArray()
    {
        return array(
            array('value' => 'layout1', 'label' => Mage::helper('adminhtml')->__('Layout 1')),
            array('value' => 'layout2', 'label' => Mage::helper('adminhtml')->__('Layout 2')),
            array('value' => 'layout3', 'label' => Mage::helper('adminhtml')->__('Layout 3')),
            array('value' => 'layout4', 'label' => Mage::helper('adminhtml')->__('Layout 4'))
        );
    }

}
