<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Brand_Linktypes{
    public function toOptionArray(){
        $types = array(
            array('value' => '0', 'label' => Mage::helper('ktmwidget')->__('No Link')),
            array('value' => '1', 'label' => Mage::helper('ktmwidget')->__('Quick Search Results')),
            array('value' => '2', 'label' => Mage::helper('ktmwidget')->__('Advanced Search Results')),
            array('value' => '3', 'label' => Mage::helper('ktmwidget')->__('Custom Page')),
        );

        return $types;
    }
}
