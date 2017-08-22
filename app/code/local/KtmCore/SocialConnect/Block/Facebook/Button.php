<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_SocialConnect_Block_Facebook_Button extends Mage_Core_Block_Template
{
    protected $client = null;
    protected $userInfo = null;
    protected $redirectUri = null;

    protected function _construct() {
        parent::_construct();

        $this->client = Mage::getSingleton('ktmcore_socialconnect/facebook_client');
        if(!($this->client->isEnabled())) {
            return;
        }

        $this->userInfo = Mage::registry('ktmcore_socialconnect_facebook_userinfo');
        
        // CSRF protection
        Mage::getSingleton('core/session')->setFacebookCsrf($csrf = md5(uniqid(rand(), TRUE)));
        $this->client->setState($csrf);
        
        if(!($redirect = Mage::getSingleton('customer/session')->getBeforeAuthUrl())) {
            $redirect = Mage::helper('core/url')->getCurrentUrl();      
        }        
        
        // Redirect uri
        Mage::getSingleton('core/session')->setFacebookRedirect($redirect);        

        $this->setTemplate('ktmcore/socialconnect/facebook/button.phtml');
    }

    protected function _getButtonUrl()
    {
        if(empty($this->userInfo)) {
            return $this->client->createAuthUrl();
        } else {
            return $this->getUrl('socialconnect/facebook/disconnect');
        }
    }

    protected function _getButtonText()
    {
        if(empty($this->userInfo)) {
            if(!($text = Mage::registry('ktmcore_socialconnect_button_text'))){
                $text = $this->__('Connect');
            }
        } else {
            $text = $this->__('Disconnect');
        }
        
        return $text;
    }

}
