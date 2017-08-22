<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Animate_Type{
    public function toOptionArray(){
        return array(
            array('value' => 'animate-zoomOut', 'label' => Mage::helper('ktmwidget')->__('Zoom Out')),
            array('value' => 'animate-zoomIn', 'label' => Mage::helper('ktmwidget')->__('Zoom In')),
            array('value' => 'animate-bounceIn', 'label' => Mage::helper('ktmwidget')->__('Bounce In')),
            array('value' => 'animate-bounceInRight', 'label' => Mage::helper('ktmwidget')->__('Bounce In Right')),
            array('value' => 'animate-pageTop', 'label' => Mage::helper('ktmwidget')->__('Page Top')),
            array('value' => 'animate-pageBottom', 'label' => Mage::helper('ktmwidget')->__('Page Bottom')),
            array('value' => 'animate-starwars', 'label' => Mage::helper('ktmwidget')->__('Star Wars')),
            array('value' => 'animate-pageLeft', 'label' => Mage::helper('ktmwidget')->__('Page Left')),
            array('value' => 'animate-pageRight', 'label' => Mage::helper('ktmwidget')->__('Page Right')),
            array('value' => 'animate-fadeIn', 'label' => Mage::helper('ktmwidget')->__('Fade In')),
            array('value' => 'animate-fadeInDown', 'label' => Mage::helper('ktmwidget')->__('Fade In Down')),
            array('value' => 'animate-fadeInUp', 'label' => Mage::helper('ktmwidget')->__('Fade In Up')),
            array('value' => 'animate-flipInX', 'label' => Mage::helper('ktmwidget')->__('Flip In X')),
            array('value' => 'animate-flipInY', 'label' => Mage::helper('ktmwidget')->__('Flip In Y'))
        );
    }
}
