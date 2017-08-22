<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Block_Adminhtml_Widget_Renderer_Category
    extends Mage_Adminhtml_Block_Template
    implements Varien_Data_Form_Element_Renderer_Interface {

    protected $_element;

    public function __construct(){
        parent::__construct();
        $this->setTemplate('ktmcore/widget/category.phtml');
        $this->id = Mage::helper('core')->uniqHash('tree');
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

    public function getCategoriesChooserUrl(){
        return $this->getUrl('ktmwidget/adminhtml_widget_instance/categories', array_merge(Mage::helper('skstore')->checkSSL(), array('_current' => true)));
    }

    public function getSelectedCategories(){
        return (array)$this->_selectedCategories;
    }
}