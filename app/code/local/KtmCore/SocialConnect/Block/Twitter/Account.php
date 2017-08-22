<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_SocialConnect_Block_Twitter_Account extends Mage_Core_Block_Template
{
    protected $client = null;
    protected $userInfo = null;

    protected function _construct() {
        parent::_construct();

        $this->client = Mage::getSingleton('ktmcore_socialconnect/twitter_client');
        if(!($this->client->isEnabled())) {
            return;
        }

        $this->userInfo = Mage::registry('ktmcore_socialconnect_twitter_userinfo');

        $this->setTemplate('ktmcore/socialconnect/twitter/account.phtml');

    }

    protected function _hasUserInfo()
    {
        return (bool) $this->userInfo;
    }

    protected function _getTwitterId()
    {
        return $this->userInfo->id;
    }

    protected function _getStatus()
    {
        return '<a href="'.sprintf('https://twitter.com/%s', $this->userInfo->screen_name).'" target="_blank">'.
                    $this->htmlEscape($this->userInfo->screen_name).'</a>';
    }

    protected function _getPicture()
    {
        if(!empty($this->userInfo->profile_image_url)) {
            return Mage::helper('ktmcore_socialconnect/twitter')
                    ->getProperDimensionsPictureUrl($this->userInfo->id,
                            $this->userInfo->profile_image_url);
        }

        return null;
    }

    protected function _getName()
    {
        return $this->userInfo->name;
    }

}
