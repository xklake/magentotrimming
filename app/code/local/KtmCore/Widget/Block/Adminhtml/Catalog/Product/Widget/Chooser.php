<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Block_Adminhtml_Catalog_Product_Widget_Chooser extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser{
    public function getGridUrl(){
        return $this->getUrl('adminhtml/catalog_product_widget/chooser', array_merge(Mage::helper('skstore')->checkSSL(), array(
            'products_grid' => true,
            '_current' => true,
            'uniq_id' => $this->getId(),
            'use_massaction' => $this->getUseMassaction()
        )));
    }

    public function getCheckboxCheckCallback(){
        if ($this->getUseMassaction()) {
            return "function (grid, element) {
                $(grid.containerId).fire('productNode:changed', {element: element});
            }";
        }
    }
}