<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Helper_Config
    extends Mage_Core_Helper_Abstract
{
    const XML_GENERAL_ENABLED     = 'less/general/enabled';
    const XML_GENERAL_VARIABLES   = 'less/general/variables';
    const XML_GENERAL_SHOW_ERRORS = 'less/general/show_errors';
    
    public function isEnabled()
    {
        return Mage::getStoreConfigFlag(self::XML_GENERAL_ENABLED);
    }
    
    public function getGlobalVariables()
    {
        $variables = Mage::getStoreConfig(self::XML_GENERAL_VARIABLES);
        $variables = (!is_array($variables) ? @unserialize($variables) : $variables);
        
        if (is_array($variables)) {
            $result = array();
            
            foreach ($variables as $variable) {
                $result[$variable['code']] = $variable['value'];
            }
            
            return $result;
        } else {
            return array();
        }
    }
    
    public function getShowErrors()
    {
        return Mage::getStoreConfigFlag(self::XML_GENERAL_SHOW_ERRORS);
    }
}