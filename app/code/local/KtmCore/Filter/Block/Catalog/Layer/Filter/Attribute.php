<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Filter_Block_Catalog_Layer_Filter_Attribute extends Mage_Catalog_Block_Layer_Filter_Attribute{

    public function __construct() {
        parent::__construct();
        if (Mage::helper('ktmcorefilter')->isPriceEnable()){
            $this->setTemplate('ktmcore/filter/attribute.phtml');
            // $this->_hash = Mage::helper('core')->uniqHash('slider-');
            $this->_filterModelName = 'ktmcorefilter/layer_filter_attribute';
        }
    }

    public function getVar() {
        //Get request variable name which is used for apply filter
        return $this->_filter->getRequestVar();
    }

    public function getClearUrl() {
        //Get URL and rewrite with SEO frieldly URL
        $_seoURL = '';
        $this->getVar();
        //Get request filters with URL 
        $query = Mage::helper('layerednav')->getParams();
        if (!empty($query[$this->getVar()])) {
            $query[$this->getVar()] = null;
            $_seoURL = Mage::getUrl('*/*/*', array(
                        '_use_rewrite' => true,
                        '_query' => $query,
            ));
        }

        return $_seoURL;
    }

    public function getHtmlId($item) {
        //Make HTMLID with requested filter + value of param
        return $this->getVar() . '-' . $item->getValueString();
    }

    public function Selectedfilter($item) {
        //Set Selected filters 
        $ids = (array) $this->_filter->getActiveState();
        return in_array($item->getValueString(), $ids);
    }
}