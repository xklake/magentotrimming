<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

require_once 'Mage/Adminhtml/controllers/Cms/Wysiwyg/ImagesController.php';

class KtmCore_Extensions_Adminhtml_Cms_Wysiwyg_ImagesController extends Mage_Adminhtml_Cms_Wysiwyg_ImagesController{
    public function indexAction(){
        if ($this->getRequest()->getParam('static_urls_allowed')){
            $this->_getSession()->setStaticUrlsAllowed(true);
        }
        parent::indexAction();
    }

    public function onInsertAction(){
        parent::onInsertAction();
        $this->_getSession()->setStaticUrlsAllowed();
    }
}
