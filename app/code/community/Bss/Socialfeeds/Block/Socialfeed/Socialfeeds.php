<?php
/**
 * Bss_Socialfeeds extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Bss
 * @package        Bss_Socialfeeds
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Socialfeed view block
 *
 * @category    Bss
 * @package     Bss_Socialfeeds
 * @author      Ultimate Module Creator
 */
$lib_path = Mage::getBaseDir('lib');
require_once $lib_path."/Socialfeeds/fb/facebook.php";
require_once $lib_path."/Socialfeeds/tw/twitter.php";
require_once $lib_path."/Socialfeeds/in/instagram.php";
require_once $lib_path."/Socialfeeds/pi/pinterest.php";
require_once $lib_path."/Socialfeeds/yt/youtube.php";  
 
class Bss_Socialfeeds_Block_Socialfeed_Socialfeeds extends Mage_Core_Block_Template
{
    
	/**
     * get the url to the socialfeeds list page
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
	public function _construct()
    {
		$_helper = Mage::helper('bss_socialfeeds/socialfeed'); 
		if(!$_helper->getCheckMod()){ 
			return;
		}
	} 
	
	/**
     * get the current socialfeed
     *
     * @access public
     * @return mixed (Bss_Socialfeeds_Model_Socialfeed|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentSocialfeed()
    {
        return Mage::registry('current_socialfeed');
    }
	
	/**
	* Set the facebook credentials 
	*/	
	public function initFB(){
		$config = array();
		$pageid = trim(Mage::getStoreConfig('bss_socialfeeds/fb_socialfeed/fb_page_id'));
		$config['appId'] = trim(Mage::getStoreConfig('bss_socialfeeds/fb_socialfeed/fb_app_id')); 
		$config['secret'] =  trim(Mage::getStoreConfig('bss_socialfeeds/fb_socialfeed/fb_secret_key'));  
		$config['fileUpload'] = true; 
		if($config['appId'] != '' && $config['secret'] != '' &&  $pageid != ''){
			return new Facebook($config);
		}
	}
	
	/**
	* Set the twitter credentials 
	*/	
	public function initTW(){
		
		$config = array(
			'oauth_access_token' => trim(Mage::getStoreConfig('bss_socialfeeds/tw_socialfeed/tw_access_token')),
			'oauth_access_token_secret' => trim(Mage::getStoreConfig('bss_socialfeeds/tw_socialfeed/tw_access_token_secret')),
			'consumer_key' => trim(Mage::getStoreConfig('bss_socialfeeds/tw_socialfeed/tw_consumer_key')),
			'consumer_secret' => trim(Mage::getStoreConfig('bss_socialfeeds/tw_socialfeed/tw_consumer_secret')),
		);
		$sc_name = trim(Mage::getStoreConfig('bss_socialfeeds/tw_socialfeed/tw_screen_name'));
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield = '?screen_name='.$sc_name;
		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange($config);
		$response = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
		if($config['oauth_access_token'] != '' && $config['oauth_access_token_secret'] != '' && $config['consumer_key'] != '' && $config['consumer_secret'] != '' && $sc_name != ''){
			return $response;
		}
	}
	
	/**
	* Set the instagram credentials 
	*/ 
	public function initIN(){
		
		$user_id = trim(Mage::getStoreConfig('bss_socialfeeds/ins_socialfeed/ins_user_id'));
		$access_token = trim(Mage::getStoreConfig('bss_socialfeeds/ins_socialfeed/ins_access_token'));
		$response = file_get_contents("https://api.instagram.com/v1/users/".$user_id."/media/recent/?access_token=".$access_token."&count=6"); 
		return $response;
	}
	
	/**
	* Set the pinterest credentials 
	*/ 
	public function initPI(){
		
		$user_name = trim(Mage::getStoreConfig('bss_socialfeeds/pi_socialfeed/ins_user_name'));
		$response = getPinterest($user_name);
		return $response;
	}
	
	/**
	* Get the youtube video 
	*/ 
	public function initYT(){
		$video_url = trim(Mage::getStoreConfig('bss_socialfeeds/yt_socialfeed/yt_url'));
		$response = '';
		if($video_url != ''){
			$response = getVideo($video_url); 
		}
		return $response;
	}
}
