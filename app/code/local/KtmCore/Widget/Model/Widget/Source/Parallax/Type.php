<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Parallax_Type{
    public function toOptionArray(){
        $types[] = array('value' => 'image', 'label' => Mage::helper('ktmwidget')->__('Image'));
        $types[] = array('value' => 'video', 'label' => Mage::helper('ktmwidget')->__('Video Service'));
        $types[] = array('value' => 'file', 'label' => Mage::helper('ktmwidget')->__('Video File'));

        return $types;
    }
}
