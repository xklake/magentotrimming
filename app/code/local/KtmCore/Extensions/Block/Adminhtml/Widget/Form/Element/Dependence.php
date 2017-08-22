<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Extensions_Block_Adminhtml_Widget_Form_Element_Dependence
    extends Mage_Adminhtml_Block_Widget_Form_Element_Dependence{

    /**
     * Register field name dependence one from each other by specified values
     *
     * @param string $fieldName
     * @param string $fieldNameFrom
     * @param string|array $refValues
     * @return KtmCore_Extensions_Block_Adminhtml_Widget_Form_Element_Dependence
     */
    public function addFieldDependence($fieldName, $fieldNameFrom, $refValues)
    {
        $this->_depends[$fieldName][$fieldNameFrom] = $refValues;
        return $this;
    }

    /**
     * HTML output getter
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_depends) {
            return '';
        }
        return '<script type="text/javascript"> new Ktm.FormElementDependenceController('
        . $this->_getDependsJson()
        . ($this->_configOptions ? ', ' . Mage::helper('core')->jsonEncode($this->_configOptions) : '')
        . '); </script>';
    }
}
