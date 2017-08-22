<?php

class AW_Blog_Model_Layoutblog
{
    protected $_options = null;

    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'aw_blog/blog.phtml',
                'label' => Mage::helper('adminhtml')->__('Standard'),
            ),
            array(
                'value' => 'aw_blog/blog-matrix.phtml',
                'label' => Mage::helper('adminhtml')->__('Matrix'),
            ),
            array(
                'value' => 'aw_blog/blog-masonry.phtml',
                'label' => Mage::helper('adminhtml')->__('Masonry'),
            ),
        );
    }
}