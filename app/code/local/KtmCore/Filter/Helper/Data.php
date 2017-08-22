<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Filter_Helper_Data extends Mage_Core_Helper_Abstract{
    public function getConfig($path=null){
        if ($path) return Mage::getStoreConfig($path);
        else{
            $module = Mage::app()->getRequest()->getModuleName();
            $bar    = $this->getConfig('ktmcorefilter/general/bar');
            return Mage::helper('core')->jsonEncode(
                array(
                    'mainDOM'   => trim($this->getConfig("ktmcorefilter/{$module}/main_selector")),
                    'layerDOM'  => trim($this->getConfig("ktmcorefilter/{$module}/layer_selector")),
                    'enable'    => (bool)$this->getConfig("ktmcorefilter/{$module}/enable"),
                    'bar'       => (bool)$bar
                )
            );
        }
    }

    public function isPriceEnable(){
        $module = Mage::app()->getRequest()->getModuleName();
        return $this->getConfig("ktmcorefilter/{$module}/price");
    }

    protected $_params = null;
    protected $_continueShoppingUrl = null;

    const XML_PATH_RESET_FILTERS = 'layerednav/layerednav/reset_filters';
    
    public function resetFilters($store = null) {
        
        if ($store == null) {
            $store = Mage::app()->getStore()->getId();
        }
        
        return Mage::getStoreConfig(self::XML_PATH_RESET_FILTERS, $store);
    }
    
    public function isSearch() {

        $mod = Mage::app()->getRequest()->getModuleName();
        if ('catalogsearch' === $mod) {
            return true;
        }

        if ('layerednav' === $mod && 'search' == Mage::app()->getRequest()->getActionName()) {
            return true;
        }

        return false;
    }

    public function getContinueShoppingUrl() {
        if (is_null($this->_continueShoppingUrl)) {
            $url = '';

            $allParams = $this->getParams();
            $keys = $this->getNonFilteringParamKeys();

            $query = array();
            foreach ($allParams as $k => $v) {
                if (in_array($k, $keys))
                    $query[$k] = $v;
            }

            if ($this->isSearch()) {

                $url = Mage::getModel('core/url')->getUrl('catalogsearch/result/index', array('_query' => $query));
            } else {
                $category = Mage::registry('current_category');
                $rootId = Mage::app()->getStore()->getRootCategoryId();
                if ($category && $category->getId() != $rootId) {
                    $url = $category->getUrl();
                } else {
                    $url = Mage::app()->getStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
                }
                $url .= $this->toQuery($query);
            }
            $this->_continueShoppingUrl = $url;
        }

        return $this->_continueShoppingUrl;
    }

    public function getParam($k) {
        $p = $this->getParams();
       $v = isset($p[$k]) ? $p[$k] : null;
        return $v;
    }

    // currently we use $without only if $asString=true
    public function getParams($asString = false, $without = null) { 
        if (is_null($this->_params)) { 

            $sessionObject = Mage::getSingleton('catalog/session');
            $bNeedClearAll = false;

            if ($this->resetFilters() AND Mage::registry('new_category')) {

                $bNeedClearAll = true;
            }

            if ($this->isSearch()) {
                $sessionObject = Mage::getSingleton('catalogsearch/session');
                $query = Mage::app()->getRequest()->getQuery();
                if (isset($query['q'])) {
                    if ($sessionObject->getData('layquery') && $sessionObject->getData('layquery') != $query['q']) {
                        $bNeedClearAll = true;
                    }
                    $sessionObject->setData('layquery', $query['q']);
                }
            }

            $nSavedCurrencyRate = $sessionObject->getAdjNavCurrencyRate();

            $nCurrentCurrencyRate = Mage::app()->getStore()->convertPrice(1000000, false);
            $nCurrentCurrencyRate = $nCurrentCurrencyRate / 1000000;

            $nSavedPriceStyle = $sessionObject->getAdjNavPriceStyle();


            $bNeedClearPriceFilter = false;

            if ($nSavedCurrencyRate AND $nSavedCurrencyRate != $nCurrentCurrencyRate) {
                $bNeedClearPriceFilter = true;
            }

            if ($bNeedClearPriceFilter) {
                $sess = (array) $sessionObject->getAdjNav();

                if ($sess) {
                    $aNonFilteringParamKeys = $this->getNonFilteringParamKeys();

                    foreach ($sess as $sKey => $sVal) {
                        if (!in_array($sKey, $aNonFilteringParamKeys)) {
                            $attribute = Mage::getModel('eav/entity_attribute');

                            $attribute->load($sKey, 'attribute_code');

                            if ($attribute->getFrontendInput() == 'price') {
                                unset($sess[$sKey]);
                            }
                        }
                    }

                    $sessionObject->setAdjNav($sess);
                }
            }

            $sessionObject->setAdjNavCurrencyRate($nCurrentCurrencyRate);


          $query = Mage::app()->getRequest()->getQuery();
            $sess = (array) $sessionObject->getAdjNav();

            $this->_params = array_merge($sess, $query);

            if (!empty($query['clearall']) OR $bNeedClearAll) { 
                $this->_params = array();
                if ($this->isSearch() && isset($query['q']))
                    $this->_params['q'] = $query['q'];
            }
            $sess = array();
            foreach ($this->_params as $k => $v) { 
                if ($v && 'clear' != $v)
                    $sess[$k] = $v;
            }

            if (Mage::registry('new_category') AND isset($sess['p'])) {
                unset($sess['p']);
            }

            $sessionObject->setAdjNav($sess);
            $this->_params = $sess;

            Mage::register('current_session_params', $sess);
        }
        if(!Mage::app()->getRequest()->getParam('dir')){ 
            $this->_params = array();
        }
        if ($asString) {
            return $this->toQuery($this->_params, $without);
        }

        return $this->_params;
    }

    public function toQuery($params, $without = null) {
        if (!is_array($without))
            $without = array($without);

        $queryStr = '?';
        foreach ($params as $k => $v) { 
            if (!in_array($k, $without))
                 $queryStr .= $k . '=' . urlencode($v) . '&';
        }
        return substr($queryStr, 0, -1);
    }

    public function stripQuery($url) {
        $pos = strpos($url, '?');
        if (false !== $pos)
            $url = substr($url, 0, $pos);
        return $url;
    }

    public function getClearAllUrl($baseUrl) {
        $baseUrl .= '?clearall=true';
        if ($this->isSearch()) {
            $baseUrl .= '&q=' . urlencode($this->getParam('q'));
        }
        return $baseUrl;
    }

    public function bNeedClearAll() {
        if ($aParams = Mage::registry('current_session_params')) {
            $bNeedClearAll = false;

            $aNonFilteringParamKeys = $this->getNonFilteringParamKeys();

            foreach ($aParams as $sKey => $sVal) {
                if (!in_array($sKey, $aNonFilteringParamKeys)) {
                    $bNeedClearAll = true;
                }
            }

            return $bNeedClearAll;
        } else {
            return false;
        }

        return true;
    }

    public function getCacheKey($attrCode) {
        $keys = $this->getNonFilteringParamKeys();
        $keys[] = $attrCode;
        return md5($this->getParams(true, $keys));
    }

    protected function getNonFilteringParamKeys() {
        return array('x', 'y', 'mode', 'p', 'order', 'dir', 'limit', 'q', '___store', '___from_store', 'sns');
    }

   
    public function getcategorydate($category)
    {
      $name=$category->getName();
      return $name;
    }
}
