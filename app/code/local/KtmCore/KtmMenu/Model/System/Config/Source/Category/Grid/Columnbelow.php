<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_KtmMenu_Model_System_Config_Source_Category_Grid_Columnbelow
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'1', 'label'=>Mage::helper('adminhtml')->__('1')),
            array('value'=>'2', 'label'=>Mage::helper('adminhtml')->__('2')),
            array('value'=>'3', 'label'=>Mage::helper('adminhtml')->__('3'))
        );
    }

}