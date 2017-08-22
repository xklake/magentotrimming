<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_SocialConnect_Model_Google_Userinfo
{
    protected $client = null;
    protected $userInfo = null;

    public function __construct() {
        if(!Mage::getSingleton('customer/session')->isLoggedIn())
            return;

        $this->client = Mage::getSingleton('ktmcore_socialconnect/google_client');
        if(!($this->client->isEnabled())) {
            return;
        }

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if(($socialconnectGid = $customer->getKtmCoreSocialconnectGid()) &&
                ($socialconnectGtoken = $customer->getKtmCoreSocialconnectGtoken())) {
            $helper = Mage::helper('ktmcore_socialconnect/google');

            try{
                $this->client->setAccessToken($socialconnectGtoken);

                $this->userInfo = $this->client->api('/userinfo');

                /* The access token may have been updated automatically due to
                 * access type 'offline' */
                $customer->setKtmCoreSocialconnectGtoken($this->client->getAccessToken());
                $customer->save();

            } catch(KtmCore_SocialConnect_GoogleOAuthException $e) {
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