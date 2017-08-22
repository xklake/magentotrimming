<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Skstore_Model_System_Config_Source_Layout_Category_Template
{

    public function toOptionArray()
    {
        return array(
            array('value' => 'page/2columns-left.phtml', 'label' => Mage::helper('adminhtml')->__('2 Columns left')),
			array('value' => 'page/2columns-right.phtml', 'label' => Mage::helper('adminhtml')->__('2 Columns Right')),
            array('value' => 'page/1column.phtml', 'label' => Mage::helper('adminhtml')->__('1 Column')),
        );
    }

}
