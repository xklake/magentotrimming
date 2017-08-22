<?php

class KtmCore_Widget_Model_Widget_Source_Sorter
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => Varien_Data_Collection::SORT_ORDER_DESC,
                'label' => Mage::helper('ktmwidget')->__('Newest first'),
            ),
            array(
                'value' => KtmCore_Widget_Helper_Data::BLOG_POST_ORDER_RANDOM,
                'label' => Mage::helper('ktmwidget')->__('Random'),
            ),
        );
    }
}