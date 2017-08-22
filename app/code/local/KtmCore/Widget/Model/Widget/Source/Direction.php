<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Direction{
    public function toOptionArray(){
        return array(
            array('value'=>'horizontal', 'label'=>Mage::helper('ktmwidget')->__('Horizontal')),
            array('value'=>'vertical', 'label'=>Mage::helper('ktmwidget')->__('Vertical'))
        );
    }
}