<?php
class KtmCore_Masonry_Block_Catalog_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{
	protected function _construct()
    {
        parent::_construct();
        $this->_orderField  = Mage::getStoreConfig(
            Mage_Catalog_Model_Config::XML_PATH_LIST_DEFAULT_SORT_BY
        );

        $this->_availableOrder = $this->_getConfig()->getAttributeUsedForSortByArray();

        switch (Mage::getStoreConfig('catalog/frontend/list_mode')) {
            case 'grid':
                $this->_availableMode = array('grid' => $this->__('Grid'));
                break;

            case 'list':
                $this->_availableMode = array('list' => $this->__('List'));
                break;

            case 'grid-list':
                $this->_availableMode = array('grid' => $this->__('Grid'), 'list' =>  $this->__('List'));
                break;

            case 'list-grid':
                $this->_availableMode = array('list' => $this->__('List'), 'grid' => $this->__('Grid'));
                break;
        }
        if (Mage::getStoreConfig("masonry/general/enable")) {
        	$this->_availableMode['masonry'] =  $this->__('Masonry');
        }
        $this->setTemplate('catalog/product/list/toolbar.phtml');
    }

    public function getDefaultPerPageValue()
    {
        if ($this->getCurrentMode() == 'list') {
            if ($default = $this->getDefaultListPerPage()) {
                return $default;
            }
            return Mage::getStoreConfig('catalog/frontend/list_per_page');
        }
        elseif ($this->getCurrentMode() == 'grid') {
            if ($default = $this->getDefaultGridPerPage()) {
                return $default;
            }
            return Mage::getStoreConfig('catalog/frontend/grid_per_page');
        }
        elseif ($this->getCurrentMode() == 'masonry') {
            return Mage::getStoreConfig("masonry/general/item_per_page");
        }
        return 0;
    }

    public function getAvailableLimit()
    {
        $currentMode = $this->getCurrentMode();
        if (in_array($currentMode, array('list', 'grid'))) {
            return $this->_getAvailableLimit($currentMode);
        } elseif ($currentMode == "masonry") {
            $a = Mage::helper('masonry')->masonryItemsPerPage();
            $k=array();
            foreach ($a as $v) {
                $k[$v] = $v;
            };
            return $k;
        }   else {
            return $this->_defaultAvailableLimit;
        }
    }
    


}
			