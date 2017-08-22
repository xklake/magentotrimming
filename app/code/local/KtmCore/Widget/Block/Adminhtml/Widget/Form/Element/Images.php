<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Block_Adminhtml_Widget_Form_Element_Images
    extends Mage_Adminhtml_Block_Widget
    implements Varien_Data_Form_Element_Renderer_Interface{

    protected $_element;
    protected $_images;

    public function __construct(){
        parent::__construct();
        $this->setTemplate('ktmcore/widget/adminhtml/widget/form/element/images.phtml');
    }

    public function getElement(){
        return $this->_element;
    }

    public function setElement(Varien_Data_Form_Element_Abstract $element){
        return $this->_element = $element;
    }

    public function render(Varien_Data_Form_Element_Abstract $element){
        $this->setElement($element);
        return $this->toHtml();
    }

    protected function _beforeToHtml(){
        $addBtn = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'label'     => Mage::helper('ktmwidget')->__('Add Image'),
            'onclick'   => 'window.kenburnsImages.add()',
            'class'     => 'add'
        ));
        $this->setChild('addBtn', $addBtn);

        $delBtn = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
            'onclick'   => 'window.kenburnsImages.remove({{id}})',
            'class'     => 'delete'
        ));
        $this->setChild('delBtn', $delBtn);

        return parent::_beforeToHtml();
    }

    public function getImages(){
        if ($this->_images) return $this->_images;

        $this->_images = array();
        $values = $this->getElement()->getValue();
        if (is_array($values)){
            foreach ($values as $value){
                if ($value) $this->_images[] = $value;
            }
        }

        return $this->_images;
    }
}
