<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Block_Adminhtml_Widget_Grid_Column_Renderer_Variables
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected function _sortValues($a, $b)
    {
        $result = strcmp($a['code'], $b['code']);
        return ($result === 0 ? strcasecmp($a['value'], $b['value']) : $result);
    }
    
    protected function _getValue(Varien_Object $row)
    {
        if (is_array($value = parent::_getValue($row))) {
            usort($value, array($this, '_sortValues'));
            $html = array();
            
            foreach ($value as $variable) {
                $html[] = '<strong>'.$this->htmlEscape($variable['code']).'</strong>'
                    . ' : ' . $this->htmlEscape($variable['value']);
            }
            
            return implode('<br />', $html);
        } else {
            return $this->__('None');
        }
    }
}