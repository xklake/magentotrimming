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
 * Socialfeed model
 *
 * @category    Bss
 * @package     Bss_Socialfeeds
 * @author      Ultimate Module Creator
 */
class Bss_Socialfeeds_Model_Socialfeed extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'bss_socialfeeds_socialfeed';
    const CACHE_TAG = 'bss_socialfeeds_socialfeed';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bss_socialfeeds_socialfeed';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'socialfeed';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('bss_socialfeeds/socialfeed');
    }

    /**
     * before save socialfeed
     *
     * @access protected
     * @return Bss_Socialfeeds_Model_Socialfeed
     * @author Ultimate Module Creator
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * get the url to the socialfeed details page
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getSocialfeedUrl()
    {
        if ($this->getUrlKey()) {
            $urlKey = '';
            if ($prefix = Mage::getStoreConfig('bss_socialfeeds/socialfeed/url_prefix')) {
                $urlKey .= $prefix.'/';
            }
            $urlKey .= $this->getUrlKey();
            if ($suffix = Mage::getStoreConfig('bss_socialfeeds/socialfeed/url_suffix')) {
                $urlKey .= '.'.$suffix;
            }
            return Mage::getUrl('', array('_direct'=>$urlKey));
        }
        return Mage::getUrl('bss_socialfeeds/socialfeed/view', array('id'=>$this->getId()));
    }

    /**
     * check URL key
     *
     * @access public
     * @param string $urlKey
     * @param bool $active
     * @return mixed
     * @author Ultimate Module Creator
     */
    public function checkUrlKey($urlKey, $active = true)
    {
        return $this->_getResource()->checkUrlKey($urlKey, $active);
    }

    /**
     * save socialfeed relation
     *
     * @access public
     * @return Bss_Socialfeeds_Model_Socialfeed
     * @author Ultimate Module Creator
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
