<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Brand_Linktypes_Custom{
    public function toOptionArray(){
        $types = array(
            array('value' => 'cms', 'label' => Mage::helper('ktmwidget')->__('Cms page')),
            array('value' => 'category', 'label' => Mage::helper('ktmwidget')->__('Category')),
        );

        return $types;
    }
}
