<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Model_Mysql4_File
    extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('less/file', 'file_id');
    }
}