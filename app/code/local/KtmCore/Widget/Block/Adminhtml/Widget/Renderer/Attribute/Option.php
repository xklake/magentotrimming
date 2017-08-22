<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
class KtmCore_Widget_Block_Adminhtml_Widget_Renderer_Attribute_Option extends Mage_Adminhtml_Block_Template{
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element){
        $targetId = $this->getFieldsetId().'_'.$this->getConfig('target');
        $block = $this->getLayout()->createBlock('ktmwidget/adminhtml_widget_renderer_depend', '', array(
            'target' => $targetId,
            'url' => $this->getUrl('ktmwidget/adminhtml_widget_attribute/option', Mage::helper('skstore')->checkSSL()),
            'me' => $element->getHtmlId(),
            'value' => implode(',', (array)$element->getValue())
        ));
        $element->setData('after_element_html', $block->toHtml());
        return $element;
    }
}