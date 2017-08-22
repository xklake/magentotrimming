<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
class KtmCore_AttributeImage_Model_Observer {
    public function updateLayout(){
        Mage::helper('ktmext')->loadJsLibs('browser');
    }
}