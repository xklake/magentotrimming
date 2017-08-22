<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_Skstore_Helper_Image extends Mage_Core_Helper_Abstract
{
	public function getImg($product, $w, $h, $imgVersion='image', $file=NULL)
	{
        $ratiocf = Mage::getStoreConfig('skstore/category/aspect_ratio_size');
		if ($h <= 0)
		{
            $w_new = $w ? $w : '280';
            switch ($ratiocf) {
                case '1:1':
                    $new_h = $w_new;
                    break;
                case '3:4':
                    $new_h = round($w_new*(3/4));
                    break;
                case '4:3':
                    $new_h = round($w_new*(4/3));
                    break;
            }
            return $url = Mage::helper('catalog/image')
                ->init($product, $imgVersion, $file)
                ->resize($w_new, $new_h);
		}
		else
		{
            return $url = Mage::helper('catalog/image')
				->init($product, $imgVersion, $file)
				->resize($w, $h);
		}
	}
}
