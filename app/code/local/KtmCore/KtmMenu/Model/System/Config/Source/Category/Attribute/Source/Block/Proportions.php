<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_KtmMenu_Model_System_Config_Source_Category_Attribute_Source_Block_Proportions
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{	
	/**
     * Get list of available block column proportions
     */
	public function getAllOptions()
	{
		if (!$this->_options)
		{
			$this->_options = array(
				array('value' => '',		'label' => ' '),
                array('value' => '1',		'label' => '1'),
				array('value' => '2',		'label' => '2'),
				array('value' => '3',		'label' => '3'),
				array('value' => '4',		'label' => '4'),
				array('value' => '5',		'label' => '5'),
				array('value' => '6',		'label' => '6')
			);
        }
		return $this->_options;
    }
}
