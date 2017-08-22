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
 * Socialfeed list block
 *
 * @category    Bss
 * @package     Bss_Socialfeeds
 * @author Ultimate Module Creator
 */
class Bss_Socialfeeds_Block_Socialfeed_List extends Mage_Core_Block_Template
{
    /**
     * initialize
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $socialfeeds = Mage::getResourceModel('bss_socialfeeds/socialfeed_collection')
                         ->addFieldToFilter('status', 1);
        $socialfeeds->setOrder('socialfeeds_status', 'asc');
        $this->setSocialfeeds($socialfeeds);
    }

    /**
     * prepare the layout
     *
     * @access protected
     * @return Bss_Socialfeeds_Block_Socialfeed_List
     * @author Ultimate Module Creator
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock(
            'page/html_pager',
            'bss_socialfeeds.socialfeed.html.pager'
        )
        ->setCollection($this->getSocialfeeds());
        $this->setChild('pager', $pager);
        $this->getSocialfeeds()->load();
        return $this;
    }

    /**
     * get the pager html
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
