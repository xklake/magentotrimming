<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Model_System_Config_Backend_Variables
    extends Mage_Adminhtml_Model_System_Config_Backend_Serialized_Array
{
    protected function _beforeSave()
    {
        // Remove empty value
        if (is_array($value = $this->getValue())) {
            unset($value['__empty']);
        } else {
            $value = array();
        }
        
        // Prepare resulting value
        $result = array();
        
        foreach ($value as $key => $variable) {
            // Only save if all values are set
            if (isset($variable['code'])
                && (trim($variable['code']) !== '')
                && !isset($result[$variable['code']])
                && isset($variable['value'])
                && (trim($variable['value']) !== '')) {
                $result[$variable['code']] = $variable;
            }
        }
        
        $this->setValue($result);
        return parent::_beforeSave();
    }
}