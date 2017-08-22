<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Block_Adminhtml_Catalog_Category_Widget_Chooser extends Mage_Adminhtml_Block_Catalog_Category_Widget_Chooser{
    public function __construct(){
        parent::__construct();
        $this->setTemplate('ktmcore/widget/catalog/category/widget/tree.phtml');
        $this->_withProductCount = false;
    }

    public function getLoadTreeUrl($expanded=null){
        return $this->getUrl('adminhtml/catalog_category_widget/categoriesJson', array_merge(Mage::helper('skstore')->checkSSL(), array(
            '_current'=>true,
            'uniq_id' => $this->getId(),
            'use_massaction' => $this->getUseMassaction()
        )));
    }
}