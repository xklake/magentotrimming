<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_KtmMenu_Model_System_Config_Source_Category_Attribute_Source_Block_Display
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
	public function getAllOptions()
	{
		if (!$this->_options)
		{
			$this->_options = array(
				array('value' => '1',		'label' => 'Yes'),
                array('value' => '0',		'label' => 'No')
			);
        }
		return $this->_options;
    }
}
