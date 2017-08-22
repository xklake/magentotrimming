<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_Skstore_Adminhtml_SupportController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ktmcore/skstore')
            ->_title(Mage::helper('adminhtml')->__('Help & Support'))
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Help & Support'), Mage::helper('adminhtml')->__('Help & Support'));
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
} 
?>
