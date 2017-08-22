<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Responsive{
    public function toOptionArray(){
        return array(
            array('value'=>'width', 'label'=>Mage::helper('ktmwidget')->__('By Width')),
            array('value'=>'breakpoint', 'label'=>Mage::helper('ktmwidget')->__('By Breakpoints'))
        );
    }
}