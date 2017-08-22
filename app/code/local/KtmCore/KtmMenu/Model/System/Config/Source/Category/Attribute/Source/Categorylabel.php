<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_KtmMenu_Model_System_Config_Source_Category_Attribute_Source_CategoryLabel
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
	protected $_options;
	
	/**
     * Get list of existing category labels
     */
	public function getAllOptions()
	{
		$cfg = Mage::helper('skstore');
		
		if (!$this->_options)
		{	
			$this->_options[] =
					array('value' => '', 'label' => " ");
					
			if ($tmp = trim($cfg->getCfg('menu/label1')))
			{
				$this->_options[] =
					array('value' => 'label1', 'label' => $tmp);
			}
			if ($tmp = trim($cfg->getCfg('menu/label2')))
			{
				$this->_options[] =
					array('value' => 'label2', 'label' => $tmp);
			}
        }
        return $this->_options;
    }
}
