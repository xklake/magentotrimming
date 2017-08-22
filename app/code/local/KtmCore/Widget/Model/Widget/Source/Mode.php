<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
class KtmCore_Widget_Model_Widget_Source_Mode{
    public function toOptionArray(){
        $modes = array(
            array('value' => 'latest', 'label' => Mage::helper('ktmwidget')->__('Latest Products')),
            array('value' => 'new', 'label' => Mage::helper('ktmwidget')->__('New Products')),
            array('value' => 'bestsell', 'label' => Mage::helper('ktmwidget')->__('Best Sell Products')),
            array('value' => 'mostviewed', 'label' => Mage::helper('ktmwidget')->__('Most Viewed Products')),
            array('value' => 'id', 'label' => Mage::helper('ktmwidget')->__('Specified Products')),
            array('value' => 'random', 'label' => Mage::helper('ktmwidget')->__('Random Products')),
            array('value' => 'related', 'label' => Mage::helper('ktmwidget')->__('Related Products')),
            array('value' => 'upsell', 'label' => Mage::helper('ktmwidget')->__('Up-sell Products')),
            array('value' => 'crosssell', 'label' => Mage::helper('ktmwidget')->__('Cross-sell Products')),
            array('value' => 'discount', 'label' => Mage::helper('ktmwidget')->__('Discount Products')),
            array('value' => 'recentviewed', 'label' => Mage::helper('ktmwidget')->__('Recent Viewed Products')),
            array('value' => 'rating', 'label' => Mage::helper('ktmwidget')->__('Top Rated Products'))
        );

        return $modes;
    }
}
