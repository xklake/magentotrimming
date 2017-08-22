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
 * Socialfeed front contrller
 *
 * @category    Bss
 * @package     Bss_Socialfeeds
 * @author      Ultimate Module Creator
 */
class Bss_Socialfeeds_SocialfeedController extends Mage_Core_Controller_Front_Action
{

    /**
      * default action
      *
      * @access public
      * @return void
      * @author Ultimate Module Creator
      */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('bss_socialfeeds/socialfeed')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('bss_socialfeeds')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'socialfeeds',
                    array(
                        'label' => Mage::helper('bss_socialfeeds')->__('Socialfeeds'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('bss_socialfeeds/socialfeed')->getSocialfeedsUrl());
        }
        $this->renderLayout();
    }

    /**
     * init Socialfeed
     *
     * @access protected
     * @return Bss_Socialfeeds_Model_Socialfeed
     * @author Ultimate Module Creator
     */
    protected function _initSocialfeed()
    {
        $socialfeedId   = $this->getRequest()->getParam('id', 0);
        $socialfeed     = Mage::getModel('bss_socialfeeds/socialfeed')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($socialfeedId);
        if (!$socialfeed->getId()) {
            return false;
        } elseif (!$socialfeed->getStatus()) {
            return false;
        }
        return $socialfeed;
    }

    /**
     * view socialfeed action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $socialfeed = $this->_initSocialfeed();
        if (!$socialfeed) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_socialfeed', $socialfeed);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('socialfeeds-socialfeed socialfeeds-socialfeed' . $socialfeed->getId());
        }
        if (Mage::helper('bss_socialfeeds/socialfeed')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('bss_socialfeeds')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'socialfeeds',
                    array(
                        'label' => Mage::helper('bss_socialfeeds')->__('Socialfeeds'),
                        'link'  => Mage::helper('bss_socialfeeds/socialfeed')->getSocialfeedsUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'socialfeed',
                    array(
                        'label' => $socialfeed->getSocialfeedsStatus(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $socialfeed->getSocialfeedUrl());
        }
        $this->renderLayout();
    }
}
