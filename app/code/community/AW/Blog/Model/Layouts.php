<?php

class AW_Blog_Model_Layouts
{
    protected $_options = null;

    public function toOptionArray()
    {
        if ($this->_options === null) {
            $this->_options = array();
            foreach (Mage::getSingleton('page/config')->getPageLayouts() as $layout) {
                
                $this->_options[] = array(
                    'value' => $layout->getTemplate(),
                    'label' => $layout->getLabel(),
                );
            }
            $addtionalArray = array(
                'value' => 'page/2columns-right-blog.phtml',
                'label' => '2 columns with right blog bar',
            );

            array_push($this->_options,$addtionalArray);

        }
        return $this->_options;
    }
}