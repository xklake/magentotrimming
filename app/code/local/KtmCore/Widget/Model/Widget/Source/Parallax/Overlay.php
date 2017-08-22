<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Parallax_Overlay{
    public function toOptionArray(){
        $types[] = array('value' => 'none', 'label' => Mage::helper('ktmwidget')->__('None'));
        $types[] = array('value' => 'ktmcore/widget/images/gridtile.png', 'label' => Mage::helper('ktmwidget')->__('2 x 2 Black'));
        $types[] = array('value' => 'ktmcore/widget/images/gridtile_white.png', 'label' => Mage::helper('ktmwidget')->__('2 x 2 White'));
        $types[] = array('value' => 'ktmcore/widget/images/gridtile_3x3.png', 'label' => Mage::helper('ktmwidget')->__('3 x 3 Black'));
        $types[] = array('value' => 'ktmcore/widget/images/gridtile_3x3_white.png', 'label' => Mage::helper('ktmwidget')->__('3 x 3 White'));

        return $types;
    }
}
