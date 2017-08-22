<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_CollectionController extends Mage_Core_Controller_Front_Action{
    public function getAction(){
        //if (!$this->_validateFormKey()) return null;
        if (!$this->getRequest()->isPost()) return null;

        $type   = $this->getRequest()->getPost('type');
        $value  = $this->getRequest()->getPost('value');

        if (!$type && !$value) return null;

        $limit          = $this->getRequest()->getPost('limit', 10);
        $carousel       = $this->getRequest()->getPost('carousel', 0);
        $column         = $this->getRequest()->getPost('column', 4);
        $row            = $this->getRequest()->getPost('row', 1);
        $pricePrefixId  = $this->getRequest()->getPost('pricePrefixId');
        $cid            = $this->getRequest()->getPost('cid');
        $template       = $this->getRequest()->getPost('template', 'ktmcore/widget/collection.phtml');

        /* @var $helper KtmCore_Widget_Helper_Data */
        $helper = Mage::helper('ktmwidget');
        /* @var $block KtmCore_Widget_Block_Widget_Collection */
        $block = $this->getLayout()->createBlock('ktmwidget/widget_collection');
        $params = array();

        if ($cid){
            $params['category_ids'] = explode(',', $cid);
        }

        $block->setTemplate($template);
        $block->setData(array(
            'row'           => $row,
            'column'        => $column,
            'carousel'      => $carousel,
            'collection'    => $helper->getProductCollection($type, $value, $params, $limit),
            'price-prefix'  => $pricePrefixId
        ));

        return $this->getResponse()->setBody($block->toHtml());
    }
}
