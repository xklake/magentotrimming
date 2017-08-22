<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Newsletter_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCfgEnable()
    {
        return Mage::getStoreConfig('ktmcorenewsletter/display_options/enable');
    }
    // public function getCfgWidth()
    // {
    //     return Mage::getStoreConfig('ktmcorenewsletter/display_options/width');
    // }
    // public function getCfgHeight()
    // {
    //     return Mage::getStoreConfig('ktmcorenewsletter/display_options/height');
    // }
    public function getCfgBackgroundColor()
    {
        return Mage::getStoreConfig('ktmcorenewsletter/display_options/background_color');
    }
    public function getCfgNewsletterImage()
    {
        return Mage::getStoreConfig('ktmcorenewsletter/display_options/newsletter_image');
    }
    public function getCfgGotoLink()
    {
        return Mage::getStoreConfig('ktmcorenewsletter/display_options/goto_link');
    }
    public function getCfgTitleNewsletter()
    {
        return Mage::getStoreConfig('ktmcorenewsletter/display_options/title_newsletter');
    }
    public function getCfgBackgroundImage()
    {
        return Mage::getStoreConfig('ktmcorenewsletter/display_options/background_image');
    }
    public function getCfgIntro()
    {
        return Mage::getStoreConfig('ktmcorenewsletter/display_options/intro');
    }
}