<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_KtmMenu_Model_System_Config_Source_Category_Grid_Columncount
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'2', 'label'=>Mage::helper('adminhtml')->__('2')),
            array('value'=>'3', 'label'=>Mage::helper('adminhtml')->__('3')),
            array('value'=>'4', 'label'=>Mage::helper('adminhtml')->__('4')),
            array('value'=>'6', 'label'=>Mage::helper('adminhtml')->__('6')),
        );
    }

}