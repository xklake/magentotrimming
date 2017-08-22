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
 * Socialfeed helper
 *
 * @category    Bss
 * @package     Bss_Socialfeeds
 * @author      Ultimate Module Creator
 */

 
class Bss_Socialfeeds_Helper_Socialfeed extends Mage_Core_Helper_Abstract
{
 
	/**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getCheckMod()
    {
        return Mage::getStoreConfigFlag('bss_socialfeeds/socialfeed/mod_status');
    }
	
	/**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getCheckFB()
    {
        return Mage::getStoreConfigFlag('bss_socialfeeds/fb_socialfeed/fb_status');
    }

	/**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */	
    public function getCheckTW()
    {
        return Mage::getStoreConfigFlag('bss_socialfeeds/tw_socialfeed/tw_status');
    }

	/**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getCheckIN()
    {
        return Mage::getStoreConfigFlag('bss_socialfeeds/ins_socialfeed/ins_status');
    }

	/**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getCheckPI()
    {
        return Mage::getStoreConfigFlag('bss_socialfeeds/pi_socialfeed/pi_status');
    }

	/**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getCheckYT()
    {
        return Mage::getStoreConfigFlag('bss_socialfeeds/yt_socialfeed/yt_status');
    }	
}
