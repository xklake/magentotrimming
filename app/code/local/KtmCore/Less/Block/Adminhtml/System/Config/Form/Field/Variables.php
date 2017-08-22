<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Block_Adminhtml_System_Config_Form_Field_Variables
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
     public function __construct()
    {
        $this->addColumn('code', array(
            'label' => $this->__('Code'),
            'style' => 'width:110px;',
        ));
        $this->addColumn('value', array(
            'label' => $this->__('Value'),
            'style' => 'width:110px;',
        ));
        
        $this->_addAfter = false;
        $this->_addButtonLabel = $this->__('Add Variable');
        parent::__construct();
    }
}