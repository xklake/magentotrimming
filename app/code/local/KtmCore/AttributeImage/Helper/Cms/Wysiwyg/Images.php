<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
class KtmCore_AttributeImage_Helper_Cms_Wysiwyg_Images extends Mage_Cms_Helper_Wysiwyg_Images{
    public function isUsingStaticUrlsAllowed(){
        if (Mage::getSingleton('adminhtml/session')->getStaticUrlsAllowed()){
            return true;
        }
        return parent::isUsingStaticUrlsAllowed();
    }
}