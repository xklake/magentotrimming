<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Filter_Block_Catalog_Layer_Filter_Discount extends Mage_Catalog_Block_Layer_Filter_Abstract{
    public function __construct(){
        parent::__construct();
        $this->_filterModelName = 'ktmcorefilter/layer_filter_discount';
    }
}
