<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_KtmMenu_Model_System_Config_Source_Category_Attribute_Source_Align_Align
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
	public function getAllOptions()
	{
		if (!$this->_options)
		{
			$this->_options = array(
				array('value' => 'left',		'label' => 'Left'),
                array('value' => 'right',		'label' => 'Right'),
                array('value' => 'center',		'label' => 'Center'),
                array('value' => 'justify',		'label' => 'Justify'),
			);
        }
		return $this->_options;
    }
}
