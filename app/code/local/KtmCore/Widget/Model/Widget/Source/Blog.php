<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Blog
{
    public function toOptionArray()
    {
        if (Mage::helper('core')->isModuleEnabled('AW_Blog')) {
            $collection = Mage::getModel('blog/cat')->getCollection();
            $cats = array();
            foreach ($collection as $item) {
                $cats[] = array(
                    'value' => $item->getCatId(),
                    'label' => $item->getTitle()
                );
            }
            return $cats;
        }
    }
}