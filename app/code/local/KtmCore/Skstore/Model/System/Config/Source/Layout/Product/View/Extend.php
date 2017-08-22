<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Skstore_Model_System_Config_Source_Layout_Product_View_Extend
{

    public function toOptionArray()
    {
        return array(
			array('value' => 1, 'label' => Mage::helper('adminhtml')->__('In all product, replace by static block if Extend attribute empty')),
			array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Only in product have Extend attribute not empty')),
        );
    }

}
