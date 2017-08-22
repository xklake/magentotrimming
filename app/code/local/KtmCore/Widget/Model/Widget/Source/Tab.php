<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Tab{
    public function toOptionArray(){
        return array(
            array('value' => 'none', 'label' => Mage::helper('ktmwidget')->__('None')),
            array('value' => 'categories', 'label' => Mage::helper('ktmwidget')->__('Categories')),
            array('value' => 'collections', 'label' => Mage::helper('ktmwidget')->__('Collections'))
        );
    }
}
