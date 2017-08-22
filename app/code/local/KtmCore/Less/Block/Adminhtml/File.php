<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Block_Adminhtml_File
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_file';
        $this->_blockGroup = 'less';
        $this->_headerText = $this->__('Manage Less Files');
        parent::__construct();
        $this->_removeButton('add');
    }
}