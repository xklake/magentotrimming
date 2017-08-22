<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Block_Adminhtml_Widget_Grid_Column_Filter_Cache
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Filter_Select
{
    protected function _getOptions()
    {
        return array(
            array(
                'value' => null,
                'label' => null,
            ),
            array(
                'value' => 1,
                'label' => $this->__('Existing'),
            ),
            array(
                'value' => 0,
                'label' => $this->__('None'),
            ),
        );
    }
    
    public function getCondition()
    {
        if (is_null($this->getValue())) {
            return null;
        }
        return ((bool)$this->getValue() ? array('notnull' => true) : array('null' => true));
    }
}