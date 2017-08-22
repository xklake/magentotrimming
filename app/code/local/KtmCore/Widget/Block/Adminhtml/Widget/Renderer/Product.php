<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
class KtmCore_Widget_Block_Adminhtml_Widget_Renderer_Product
    extends Mage_Adminhtml_Block_Template
    implements Varien_Data_Form_Element_Renderer_Interface {

    protected $_element;

    public function __construct(){
        parent::__construct();
        $this->setTemplate('ktmcore/widget/product.phtml');
        $this->id = Mage::helper('core')->uniqHash('grid');
    }

    public function render(Varien_Data_Form_Element_Abstract $element){
        $this->setElement($element);
        return $this->toHtml();
    }

    public function setElement($element){
        $this->_element = $element;
    }

    public function getElement(){
        return $this->_element;
    }

    public function getProductsChooserUrl(){
        return $this->getUrl('ktmwidget/adminhtml_widget_instance/products', array_merge(Mage::helper('skstore')->checkSSL(), array('_current' => true)));
    }
}