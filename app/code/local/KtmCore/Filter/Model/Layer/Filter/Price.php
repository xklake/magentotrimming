<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Filter_Model_Layer_Filter_Price extends Mage_Catalog_Model_Layer_Filter_Price{
    public function getItemsCount(){
        return true;
    }

    /**
     * Retrieve resource instance
     *
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Layer_Filter_Price
     */
    protected function _getResource(){
        if (is_null($this->_resource)) {
            $this->_resource = Mage::getResourceModel('ktmcorefilter/layer_filter_price');
        }
        return $this->_resource;
    }

    /**
     * Apply price range filter to collection
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param $filterBlock
     *
     * @return Mage_Catalog_Model_Layer_Filter_Price
     */
    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock){
        if (Mage::helper('ktmcorefilter')->isPriceEnable() && version_compare(Mage::getVersion(), '1.7.0.0') < 0){
            /**
             * Filter must be string: $index,$range
             */
            $filter = $request->getParam($this->getRequestVar());
            if (!$filter) {
                return $this;
            }

            $filter = explode('-', $filter);
            if (count($filter) != 2) {
                return $this;
            }

            list($index, $range) = $filter;

            if (is_numeric($index) && is_numeric($range)) {
                $this->setPriceRange((int)$range);
                $this->setPriceRangeCustom($filter);

                $this->_applyToCollection($range, $index);
                $this->getLayer()->getState()->addFilter(
                    $this->_createItem($this->_renderItemLabelCustom($index, $range), $filter)
                );

                $this->_items = array();
            }
            return $this;
        }else{
            parent::apply($request, $filterBlock);
        }
    }

    /**
     * Prepare text of range label
     *
     * @param float|string $fromPrice
     * @param float|string $toPrice
     * @return string
     */
    protected function _renderItemLabelCustom($fromPrice, $toPrice){
        $store = Mage::app()->getStore();
        $formattedFromPrice  = $store->formatPrice($fromPrice);
        if ($toPrice === '') {
            return Mage::helper('catalog')->__('%s and above', $formattedFromPrice);
        } elseif ($fromPrice == $toPrice) {
            return $formattedFromPrice;
        } else {
            return Mage::helper('catalog')->__('%s - %s', $formattedFromPrice, $store->formatPrice($toPrice));
        }
    }
    /**
     * Get data for build price filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        if (Mage::app()->getStore()->getConfig(self::XML_PATH_RANGE_CALCULATION) == self::RANGE_CALCULATION_IMPROVED) {
            return $this->_getCalculatedItemsData();
        } /*elseif ($this->getInterval()) {
            return array();
        }*/

        $range      = $this->getPriceRange();
        $dbRanges   = $this->getRangeItemCounts($range);
        $data       = array();

        if (!empty($dbRanges)) {
            $lastIndex = array_keys($dbRanges);
            $lastIndex = $lastIndex[count($lastIndex) - 1];

            foreach ($dbRanges as $index => $count) {
                $fromPrice = ($index == 1) ? '' : (($index - 1) * $range);
                $toPrice = ($index == $lastIndex) ? '' : ($index * $range);

                $data[] = array(
                    'label' => $this->_renderRangeLabel($fromPrice, $toPrice),
                    'value' => $fromPrice . '-' . $toPrice,
                    'count' => $count,
                );
            }
        }

        return $data;
    }
}
