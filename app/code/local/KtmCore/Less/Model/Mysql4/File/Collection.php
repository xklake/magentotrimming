<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Less_Model_Mysql4_File_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('less/file');
    }
    
    protected function _afterLoad()
    {
        parent::_afterLoad();
        $this->walk('afterLoad');
        return $this;
    }
    
    public function toOptionArray()
    {
        return parent::_toOptionArray('file_id', 'path');
    }
    
    public function toOptionHash()
    {
        return parent::_toOptionHash('file_id', 'path');
    }
    
    public function toPathCacheOptionArray()
    {
        return parent::_toOptionArray('path', 'cache');
    }
    
    public function toPathCacheOptionHash()
    {
        return parent::_toOptionHash('path', 'cache');
    }
}