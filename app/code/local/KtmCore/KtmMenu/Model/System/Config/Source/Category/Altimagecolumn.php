<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_KtmMenu_Model_System_Config_Source_Category_Altimagecolumn
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'label', 'label'=>Mage::helper('adminhtml')->__('Label')),
            array('value'=>'position', 'label'=>Mage::helper('adminhtml')->__('Sort Order'))
        );
    }

}