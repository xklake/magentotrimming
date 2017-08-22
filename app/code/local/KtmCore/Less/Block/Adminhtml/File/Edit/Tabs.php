<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Block_Adminhtml_File_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('less_file_info_tabs');
        $this->setDestElementId('less_file_edit_form');
        $this->setTitle($this->__('Less File'));
    }
    
    public function getLessFile()
    {
        return Mage::registry('current_less_file');
    }
    
    protected function _prepareLayout()
    {
        $file = $this->getLessFile();
        
        $this->addTab('general', array(
            'label'   => $this->__('General'),
            'content' => $this->getLayout()->createBlock('less/adminhtml_file_edit_tab_general')->toHtml(),
            'active'  => true,
        ));
        
        return parent::_prepareLayout();
    }
}