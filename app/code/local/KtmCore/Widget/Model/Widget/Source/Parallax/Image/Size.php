<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Parallax_Image_Size{
    public function toOptionArray(){
        $types[] = array('value' => 'cover',    'label' => Mage::helper('ktmwidget')->__('cover'));
        $types[] = array('value' => 'contain',   'label' => Mage::helper('ktmwidget')->__('contain'));

        return $types;
    }
}