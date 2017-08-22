<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_AjaxCart_Block_About_Information extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->_getHeaderHtml($element);
        $html .= $this->_getFieldHtml($element);
        $html .= $this->_getFooterHtml($element);
        return $html;
    }

    protected function _getFieldHtml($fieldset)
    {
        $content = 'Ajax Cart version : 1.0.1';
        return $content;
    }
}