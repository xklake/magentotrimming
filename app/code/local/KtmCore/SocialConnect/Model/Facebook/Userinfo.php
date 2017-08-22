<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_SocialConnect_Model_Facebook_Userinfo
{
    protected $client = null;
    protected $userInfo = null;

    public function __construct() {
        if(!Mage::getSingleton('customer/session')->isLoggedIn())
            return;

        $this->client = Mage::getSingleton('ktmcore_socialconnect/facebook_client');
        if(!($this->client->isEnabled())) {
            return;
        }

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        if(($socialconnectFid = $customer->getKtmCoreSocialconnectFid()) &&
                ($socialconnectFtoken = $customer->getKtmCoreSocialconnectFtoken())) {
            $helper = Mage::helper('ktmcore_socialconnect/facebook');

            try{
                $this->client->setAccessToken($socialconnectFtoken);
                $this->userInfo = $this->client->api(
                    '/me',
                    'GET',
                    array(
                        'fields' =>
                        'id,name,first_name,last_name,link,birthday,gender,email,picture.type(large)'
                    )
                );

            } catch(FacebookOAuthException $e) {
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