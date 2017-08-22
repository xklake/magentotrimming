<?php
class KtmCore_Skstore_Model_System_Config_Numsections
{
    public function toOptionArray()
    {	$optionsarray = array();
		for($i=1;$i<=10;$i++) {
			$optionsarray[] =	array('value' => $i, 'label'=>Mage::helper('adminhtml')->__($i));
		}
        return $optionsarray;
    }
}