<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_SocialConnect_Model_Twitter_Userinfo
{
    protected $client = null;
    protected $userInfo = null;

    public function __construct() {
        if(!Mage::getSingleton('customer/session')->isLoggedIn())
            return;

        $this->client = Mage::getSingleton('ktmcore_socialconnect/twitter_client');
        if(!($this->client->isEnabled())) {
            return;
        }

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if(($socialconnectTid = $customer->getKtmCoreSocialconnectTid()) &&
                ($socialconnectTtoken = $customer->getKtmCoreSocialconnectTtoken())) {
            $helper = Mage::helper('ktmcore_socialconnect/twitter');

            try{
                $this->client->setAccessToken($socialconnectTtoken);
                
                $this->userInfo = $this->client->api('/account/verify_credentials.json', 'GET', array('skip_status' => true)); 

            }  catch (KtmCore_SocialConnect_TwitterOAuthException $e) {
                $helper->disconnect($customer);
                Mage::getSingleton('core/session')->addNotice($e->getMessage());                
            } catch(Exception $e) {
                $helper->disconnect($customer);
                Mage::getSingleton('core/session')->addError($e->getMessage());
            }

        }
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }
}