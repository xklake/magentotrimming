<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Skstore_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/skstore/", Mage::helper('skstore')->checkSSL()));
    }
    public function blocksAction() {
        $config = Mage::helper('skstore')->getCfg('install/overwrite_blocks');
        Mage::getSingleton('skstore/import_cms')->importCmsItems('cms/block', 'blocks', $config);
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/skstore/", Mage::helper('skstore')->checkSSL()));
    }
    public function pagesAction() {
        $config = Mage::helper('skstore')->getCfg('install/overwrite_pages');
        Mage::getSingleton('skstore/import_cms')->importCmsItems('cms/page', 'pages', $config);
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/skstore/", Mage::helper('skstore')->checkSSL()));
    }
    public function widgetsAction() {
        Mage::getSingleton('skstore/import_cms')->importWidgetItems('widget/widget_instance', 'widgets', false);
        $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/skstore/", Mage::helper('skstore')->checkSSL()));
    }
}
