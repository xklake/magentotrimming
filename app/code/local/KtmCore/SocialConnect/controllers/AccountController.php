<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_SocialConnect_AccountController extends Mage_Core_Controller_Front_Action
{
    
    public function preDispatch()
    {
        parent::preDispatch();

        if (!$this->getRequest()->isDispatched()) {
            return;
        }
        
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);
        }
    }    

    public function googleAction()
    {        
        $userInfo = Mage::getSingleton('ktmcore_socialconnect/google_userinfo')
                ->getUserInfo();
        
        Mage::register('ktmcore_socialconnect_google_userinfo', $userInfo);
        
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function facebookAction()
    {        
        $userInfo = Mage::getSingleton('ktmcore_socialconnect/facebook_userinfo')
            ->getUserInfo();
        
        Mage::register('ktmcore_socialconnect_facebook_userinfo', $userInfo);
        
        $this->loadLayout();
        $this->renderLayout();
    }    
    
    public function twitterAction()
    {        
        // Cache user info inside customer session due to Twitter window frame rate limits
        if(!($userInfo = Mage::getSingleton('customer/session')
                ->getKtmCoreSocialconnectTwitterUserinfo())) {
            $userInfo = Mage::getSingleton('ktmcore_socialconnect/twitter_userinfo')
                ->getUserInfo();
            
            Mage::getSingleton('customer/session')->setKtmCoreSocialconnectTwitterUserinfo($userInfo);
        }
        
        Mage::register('ktmcore_socialconnect_twitter_userinfo', $userInfo);
        
        $this->loadLayout();
        $this->renderLayout();
    }    
    
}
