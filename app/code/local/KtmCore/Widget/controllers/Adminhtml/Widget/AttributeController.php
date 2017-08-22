<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
class KtmCore_Widget_Adminhtml_Widget_AttributeController extends Mage_Adminhtml_Controller_Action{
    public function optionAction(){
        if ($this->getRequest()->isPost()){
            $values = explode(',', $this->getRequest()->getParam('value'));
            if (count($values) == 2){
                list($attributeId, $attributeCode) = $values;
                $optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
                    ->setAttributeFilter($attributeId)
                    ->setStoreFilter()
                    ->load();
                $options = array();
                foreach ($optionCollection as $option){
                    $options[] = array(
                        'id' => $option->getId(),
                        'label' => $option->getValue(),
                        'image' => $option->getImage()
                    );
                }
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($options));
            }
        }
    }
}