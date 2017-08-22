<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Filter_Model_Layer_Filter_Discount extends Mage_Catalog_Model_Layer_Filter_Abstract{
    protected $_resource;

    public function _construct(){
        parent::_construct();
        $this->_requestVar = 'discount';
    }

    public function getName(){
        return Mage::helper('ktmcorefilter')->__('Promotion');
    }

    /**
     * @return KtmCore_Filter_Model_Resource_Catalog_Layer_Filter_Discount
     */
    protected function _getResource(){
        if (is_null($this->_resource)){
            $this->_resource = Mage::getResourceModel('ktmcorefilter/layer_filter_discount');
        }
        return $this->_resource;
    }

    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock){
        $value = $request->getParam($this->_requestVar);

        if (!$value || is_array($value)) return $this;

        $this->_getResource()->applyFilterToCollection($this, $value);
        $this->getLayer()->getState()->addFilter($this->_createItem('Discount', $value));
        $this->_items = array();

        return $this;
    }

    protected function _getItemsData(){
        $data = $this->_getResource()->getCount($this);

        if (isset($data['count']) && $data['count'] > 0){
            return array(
                array(
                    'label' => Mage::helper('ktmcorefilter')->__('Discount'),
                    'value' => 1,
                    'count' => (int)$data['count']
                )
            );
        }else{
            if (!Mage::getStoreConfigFlag('ktmcorefilter/discount/show_empty')){
                return array(
                    array(
                        'label' => Mage::helper('ktmcorefilter')->__('Discount'),
                        'value' => 1,
                        'count' => 0
                    )
                );
            }else{
                return array();
            }
        }
    }
}
