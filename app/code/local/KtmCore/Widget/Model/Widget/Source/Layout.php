<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Layout{
    public function toOptionArray()	{
        $layouts = array(
            array('value' => 'box', 'label' => Mage::helper('ktmwidget')->__('Box')),
            array('value' => 'full', 'label' => Mage::helper('ktmwidget')->__('Full Width')),
        );

        return $layouts;
    }
}
