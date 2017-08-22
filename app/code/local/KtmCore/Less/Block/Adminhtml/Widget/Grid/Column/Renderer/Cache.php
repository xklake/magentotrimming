<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Block_Adminhtml_Widget_Grid_Column_Renderer_Cache
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected function _getValue(Varien_Object $row)
    {
        if (is_array($value = parent::_getValue($row))) {
            return $this->__('Existing');
        } else {
            return $this->__('None');
        }
    }
}