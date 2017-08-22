<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_CategorySearch_Block_Form extends Mage_Core_Block_Template
{
    /* gets the currently selected category id
     * 1) the active navigation category on category pages (depending on the configuration):
     * 1a) the active category navigation filter (if it is included in the categories dropdrown)
     * 1b) the current category from the main navigation
     * 2) the active category search filter on search results pages
     * 3) the root category on other pages
    **/
    
    protected function _construct()
    {
        parent::_construct();
        if (Mage::getStoreConfigFlag('catalogcategorysearch/general/enabled')){
            $this->setTemplate('ktmcore/categorysearch/form.phtml');
        }else{
            $this->setTemplate('catalogsearch/form.mini.phtml');
        }

        $this->addData(array(
            'cache_lifetime'=> false,
            'cache_tags'    => array(Mage_Core_Model_Store::CACHE_TAG, Mage_Cms_Model_Block::CACHE_TAG)
        ));
    }

    public function getSearchableCategories()
    {
        $rootCategory = Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
        return $this->getSearchableSubCategories($rootCategory);
    }

    public function getSearchableSubCategories($category)
    {
        return Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('all_children')
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToFilter('include_in_menu', 1)
            ->addIdFilter($category->getChildren())
            ->setOrder('position', 'ASC')
            ->load();
    }

    public function getCurrentlySelectedCategoryId() {
        $helper = $this->helper('catalogcategorysearch');
        if ($helper->isCategoryPage() && $helper->selectCategoryOnCategoryPages()) {
            //find active category navigation filter
            foreach (Mage::getSingleton('catalog/layer')->getState()->getFilters() as $filterItem) {
                if ($filterItem->getFilter() instanceof Mage_Catalog_Model_Layer_Filter_Category) {
                    //only return the category id when it does not exceed the level of the categories that are shown
                    if ($filterItem->getFilter()->getCategory()->getLevel() <= $helper->getMaximumCategoryLevel()) {
                        return $filterItem->getValue();
                    }
                }
            }
            //get the current category from the main navigation
            return Mage::getSingleton('catalog/layer')->getCurrentCategory()->getEntityId();
        }
        if ($helper->isSearchResultsPage()) {
            //find first active category search filter
            foreach (Mage::getSingleton('catalogsearch/layer')->getState()->getFilters() as $filterItem) {
                 if ($filterItem->getFilter() instanceof Mage_Catalog_Model_Layer_Filter_Category) {
                     return $filterItem->getValue();
                 }
            }
        }
        //get the root category
        return Mage::app()->getStore()->getRootCategoryId();
    }
}
