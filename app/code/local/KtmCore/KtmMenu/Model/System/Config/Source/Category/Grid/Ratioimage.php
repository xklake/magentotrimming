<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_KtmMenu_Model_System_Config_Source_Category_Grid_Ratioimage
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'1:1', 'label'=>Mage::helper('adminhtml')->__('Square Rectangle')),
            array('value'=>'3:4', 'label'=>Mage::helper('adminhtml')->__('Horizontal Rectangle')),
            array('value'=>'4:3', 'label'=>Mage::helper('adminhtml')->__('Vertical Rectangle'))
        );
    }

}