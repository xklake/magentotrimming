<?php
class KtmCore_Masonry_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isEnableMansonryMode(){return Mage::getStoreConfig("masonry/general/enable");}
	public function masonryItemsPerPage(){return array (5,9,14,18);}
	public function getMasonryRow($n){switch($n){case 5:return 1;break;case 9:return 2;break;case 14:return 3;break;case 18:return 4;break;}}
}
	 