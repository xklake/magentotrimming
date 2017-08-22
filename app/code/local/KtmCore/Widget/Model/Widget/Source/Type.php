<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Type{
    public function toOptionArray(){
        $types = array(
            array('value' => 'product', 'label' => Mage::helper('ktmwidget')->__('Product')),
            array('value' => 'block', 'label' => Mage::helper('ktmwidget')->__('Block')),
            // array('value' => 'attribute', 'label' => Mage::helper('ktmwidget')->__('Attribute')),
            array('value' => 'category', 'label' => Mage::helper('ktmwidget')->__('Category')),
            array('value' => 'blog', 'label' => Mage::helper('ktmwidget')->__('Blog')),
			array('value' => 'brand', 'label' => Mage::helper('ktmwidget')->__('Brands'))
        );

        return $types;
    }
}
