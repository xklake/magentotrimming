<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Skstore_Model_System_Config_Source_Layout_Category_Layer_Position
{

    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Left')),
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('Right')),
        );
    }

}
