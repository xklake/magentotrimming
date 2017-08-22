<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_SocialConnect_Block_Google_Account extends Mage_Core_Block_Template
{
    protected $client = null;
    protected $userInfo = null;

    protected function _construct() {
        parent::_construct();

        $this->client = Mage::getSingleton('ktmcore_socialconnect/google_client');
        if(!($this->client->isEnabled())) {
            return;
        }

        $this->userInfo = Mage::registry('ktmcore_socialconnect_google_userinfo');

        $this->setTemplate('ktmcore/socialconnect/google/account.phtml');

    }

    protected function _hasUserInfo()
    {
        return (bool) $this->userInfo;
    }

    protected function _getGoogleId()
    {
        return $this->userInfo->id;
    }

    protected function _getStatus()
    {
        if(!empty($this->userInfo->link)) {
            $link = '<a href="'.$this->userInfo->link.'" target="_blank">'.
                    $this->htmlEscape($this->userInfo->name).'</a>';
        } else {
            $link = $this->userInfo->name;
        }

        return $link;
    }

    protected function _getEmail()
    {
        return $this->userInfo->email;
    }

    protected function _getPicture()
    {
        if(!empty($this->userInfo->picture)) {
            return Mage::helper('ktmcore_socialconnect/google')
                    ->getProperDimensionsPictureUrl($this->userInfo->id,
                            $this->userInfo->picture);
        }

        return null;
    }

    protected function _getName()
    {
        return $this->userInfo->name;
    }

    protected function _getGender()
    {
        if(!empty($this->userInfo->gender)) {
            return ucfirst($this->userInfo->gender);
        }

        return null;
    }

    protected function _getBirthday()
    {
        if(!empty($this->userInfo->birthday)) {
            if((strpos($this->userInfo->birthday, '0000')) === false) {
                $birthday = date('F j, Y', strtotime($this->userInfo->birthday));
            } else {
                $birthday = date(
                    'F j',
                    strtotime(
                        str_replace('0000', '1970', $this->userInfo->birthday)
                    )
                );
            }

            return $birthday;
        }

        return null;
    }

}
