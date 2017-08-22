<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
class KtmCore_Widget_Block_Adminhtml_Widget_Renderer_Layout extends Mage_Adminhtml_Block_Template{
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element){
        $html = "
<div id='layout_{$this->getData("target")}' class='layout-preview'></div>
<script type='text/javascript'>
    document.observe('dom:loaded', function(){
        window.layout_{$this->getData("target")}_object = new KtmLayoutPreview('layout_{$this->getData("target")}', '{$this->getFieldsetId()}', '{$this->getData("target")}');
    });
    setTimeout(function(){
        window.layout_{$this->getData("target")}_object = new KtmLayoutPreview('layout_{$this->getData("target")}', '{$this->getFieldsetId()}', '{$this->getData("target")}');
    }, 100);
</script>
";
        $element->setData('after_element_html', $html);
        return $element;
    }
}