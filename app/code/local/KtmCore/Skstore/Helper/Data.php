<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Skstore_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Get theme's main settings (single option)
     *
     * @return string
     */
    public function getCfg($optionString)
    {
        return Mage::getStoreConfig('skstore/' . $optionString);
    }

    /**
     * Get theme's main settings design (single option)
     *
     * @return array
     */
    public function getCfgSectionDesign($storeId)
    {
        if ($storeId)
            return Mage::getStoreConfig('skstore_design', $storeId);
        else
            return Mage::getStoreConfig('skstore_design');
    }

    /**
     * Get CMS block ID (single option)
     *
     * @return array
     */
    public function getCmsBlock($cmsblock)
    {
        if ($cmsblock)
            return Mage::app()->getLayout()->createBlock('cms/block')->setBlockId($cmsblock)->toHtml();
        else
            return '';
    }

    /**
     * Get theme's design settings (single option)
     *
     * @return string
     */
    public function getThemeDesignCfg($optionString, $storeCode = NULL)
    {
        return Mage::getStoreConfig('skstore_design/' . $optionString, $storeCode);
    }

    /**
     * Get theme's layout settings (single option)
     *
     * @return string
     */
    public function getThemeLayoutCfg($optionString, $storeCode = NULL)
    {
        return Mage::getStoreConfig('skstore_layout/' . $optionString, $storeCode);
    }

    /**
     * Get view product show label
     *
     * @return product detail
     */
    protected function _loadProduct(Mage_Catalog_Model_Product $product)
    {
        $product->load($product->getId());
    }

    /**
     * Get config show label for product
     *
     * @return html label
     */
    public function getLabel(Mage_Catalog_Model_Product $product)
    {
        if ( 'Mage_Catalog_Model_Product' != get_class($product) )
            return;
        $html = '';
        $html2 = '';
        if (!$this->getCfg("product_labels/new") &&
            !$this->getCfg("product_labels/sale")) {
            return $html;
        }
        if ( $this->getCfg("product_labels/sale") == 'sale' && $this->_checkSale($product) ) {
            $html .= '<div class="product-sale-label"><span>'.$this->__('Sale').'</span></div>';
        }

        $_finalPrice = Mage::helper('tax')->getPrice($product, $product->getFinalPrice());
        $_regularPrice = Mage::helper('tax')->getPrice($product, $product->getPrice());
            
        if ( $_regularPrice != $_finalPrice && $this->getCfg("product_labels/sale") == 'percent' && $this->_checkSale($product) ) {
            $getpercentage = number_format($_finalPrice / $_regularPrice * 100, 2);
            $finalpercentage = number_format(100 - $getpercentage,0);
            $html .= '<div class="product-percent-label"><span>-'.$finalpercentage.'%<br/>'/*.$this->__('Off')*/.'</span></div>';
        }

        if ( $this->getCfg("product_labels/new") && $this->_checkNew($product) ) {
            $html .= '<div class="product-new-label"><span>'.$this->__('New').'</span></div>';
        }

        if ($html != '') {
            $html2 = '<div class="product-label">'.$html.'</div>';
        }

        return $html2;
    }

    /**
     * Check date time locale
     *
     * @return true or false
     */
    protected function _checkDate($from, $to)
    {
        $today = strtotime(
            Mage::app()->getLocale()->date()
                ->setTime('00:00:00')
                ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT)
        );
        if ($from && $today < $from) {
            return false;
        }
        if ($to && $today > $to) {
            return false;
        }
        if (!$to && !$from) {
            return false;
        }
        return true;
    }

    /**
     * Get date from new product
     *
     * @return from date and to date
     */
    protected function _checkNew($product)
    {
        $from = strtotime($product->getData('news_from_date'));
        $to = strtotime($product->getData('news_to_date'));

        return $this->_checkDate($from, $to);
    }

    /**
     * Get date from sale product
     *
     * @return from date and to date
     */
    protected function _checkSale($product)
    {
        $from = strtotime($product->getData('special_from_date'));
        $to = strtotime($product->getData('special_to_date'));

        return $this->_checkDate($from, $to);
    }

    /**
     * Get alternative image HTML of the given product
     *
     * @param Mage_Catalog_Model_Product	$product		Product
     * @param int							$w				Image width
     * @param int							$h				Image height
     * @param string						$imgVersion		Image version: image, small_image, thumbnail
     * @return string
     */
    public function getAltImgHtml($product, $w, $h, $imgVersion='small_image')
    {
        $column = $this->getCfg('category/alt_image_column');
        $value = $this->getCfg('category/alt_image_column_value');
        $product->load('media_gallery');
        if ($gal = $product->getMediaGalleryImages())
        {
            if ($altImg = $gal->getItemByColumnValue($column, $value))
            {
                return
                    '<img class="img-responsive alt-img lazy" data-src="' . Mage::helper('skstore/image')->getImg($product, $w, $h, $imgVersion, $altImg->getFile()) . '" src="' .Mage::getDesign()->getSkinUrl('images/loader.gif', Mage::helper('skstore')->checkSSL()). '" alt="' . $product->getName() . '" />';
            }
        }

        return '';
    }

    public function getFormattedBlocks($block, $staticBlockId)
    {
        $colCount = 0;
        $colHtml = array();
        $html = '';
        for ($i = 1; $i < 7; $i++)
        {
            if ($tmp = $block->getChildHtml($staticBlockId . $i))
            {
                $colHtml[] = $tmp;
                $colCount++;
            }
        }

        if ($colHtml)
        {
            if($colCount==5){
                for ($i = 0; $i < $colCount; $i++)
                {
                    if($i==4){
                        $html .= '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">';
                        $html .= $colHtml[$i];
                        $html .= '</div>';
                    }else{
                        $html .= '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                        $html .= $colHtml[$i];
                        $html .= '</div>';
                    }
                }
            }else{
                $n = (int) (12 / $colCount);
                for ($i = 0; $i < $colCount; $i++)
                {
                    $html .= '<div class="col-xs-'.$n.' col-sm-'.$n.' col-md-'.$n.' col-lg-'.$n.'">';
                    $html .= $colHtml[$i];
                    $html .= '</div>';
                }
            }

        }
        return $html;
    }
    
    public function getPreviousProduct()
    {
        $currentProduct = Mage::registry('current_product');

        if (!$currentProduct) {
            return false;
        }

        $prodId = $currentProduct->getId();

        $positions = Mage::getSingleton('core/session')
            ->getPrevNextProductCollection();
        if (!$positions) {

            $currentCategory = Mage::registry('current_category');

            if (!$currentCategory) {
                $categoryIds = Mage::registry('current_product')->getCategoryIds();
                $categoryId = current($categoryIds);

                $currentCategory = Mage::getModel('catalog/category')
                    ->load($categoryId);

                Mage::register('current_category', $currentCategory);
            }

            $positions = array_reverse(array_keys(Mage::registry('current_category')->getProductsPosition()));
        }

        $cpk = @array_search($prodId, $positions);

        $slice = array_reverse(array_slice($positions, 0, $cpk));

        foreach ($slice as $productId) {
            $product = Mage::getModel('catalog/product')
                ->load($productId);

            if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
                return $product;
            }
        }

        return false;
    }
    
    public function getNextProduct()
    {
        $currentProduct = Mage::registry('current_product');

        if (!$currentProduct) {
            return false;
        }

        $prodId = $currentProduct->getId();

        $positions = Mage::getSingleton('core/session')
            ->getPrevNextProductCollection();

        if (!$positions) {

            $currentCategory = Mage::registry('current_category');
            if (!$currentCategory) {
                $categoryIds = Mage::registry('current_product')->getCategoryIds();
                $categoryId = current($categoryIds);

                $currentCategory = Mage::getModel('catalog/category')
                    ->load($categoryId);

                Mage::register('current_category', $currentCategory);
            }

            $positions = array_reverse(array_keys(Mage::registry('current_category')->getProductsPosition()));
        }

        $cpk = @array_search($prodId, $positions);

        $slice = array_slice($positions, $cpk + 1, count($positions));

        foreach ($slice as $productId) {
            $product = Mage::getModel('catalog/product')
                ->load($productId);

            if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
                return $product;
            }
        }

        return false;
    }

    public function getElevateZoomConfig()
    {
        $config['zoomType'] = Mage::getStoreConfig('skstore/product_page/zoom_type')?Mage::getStoreConfig('skstore/product_page/zoom_type'):'lens';
        $config['lensSize'] = is_numeric(Mage::getStoreConfig('skstore/product_page/zoom_lenssize'))?Mage::getStoreConfig('skstore/product_page/zoom_lenssize'):200;
        $config['lensShape'] = Mage::getStoreConfig('skstore/product_page/zoom_lensshape')?Mage::getStoreConfig('skstore/product_page/zoom_lensshape'):'round';
        $config['borderSize'] = 1;
        $config['containLensZoom'] = 1;
        $config['cursor'] = 'crosshair';
        $config['gallery'] = 'gallery_01';
        $config['galleryActiveClass'] = 'active';
        // $config['imageCrossfade'] = 1;
        // $config['galleryActiveClass'] = 'active';

        $out = array();
        foreach ($config as $k=>$v){
            if (is_numeric($v)) $out[] = sprintf("%s:%d", $k, $v);
            else $out[] = sprintf("%s:'%s'", $k, $v);
        }
        return '{' . implode(',', $out) . '}';
    }

    public function getIsHomePage()
    {
        $controller = Mage::app()->getRequest()->getControllerName();
        $route = Mage::app()->getFrontController()->getRequest()->getRouteName();
        if ($route == 'cms' && $controller=='index') return true;
        return false;
    }

    public function checkSSL()
    {
        $loadFromSSL = Mage::app()->getStore()->isCurrentlySecure();
        return array('_secure'=>$loadFromSSL);
    }
	
	public function getNumberSections() {
		return intval(Mage::getStoreConfig('skstore/customization/numsections'));
	}

    public function getClassGridColumns() {
        $cl = '';
        $c_d = intval($this->getCfg("category_grid/column_count"));
        $c_s = intval($this->getCfg("category_grid/column_count_992"));
        $c_x = intval($this->getCfg("category_grid/column_count_768"));
        $cd = 12/$c_d;$cs=12/$c_s;$cx=12/$c_x;
        $cl .= 'col-xs-'.$cx.' col-sm-'.$cs.' col-md-'.$cd;
        return  $cl;
    }

	public function setLeftRightLayer() {
		if ($this->getCfg("category/layer_position")) {
			return '';
		}	else {
			return 'catalog.leftnav';
		}
	}
	
	public function setCategoryLayout() {
		return $this->getCfg("category/set_layout");
	}
	
	public function getExtendAttributeHtml($product) {
		$extendHtml = "";
		if ($product->getData('extend_block')) {
			$extendHtml = $cmshelper = Mage::helper('cms')->getPageTemplateProcessor()->filter($product->getData('extend_block'));
		}
		return $extendHtml;
	} 
	
	public function getExtendBlockHtml() {
		return $this->getLayout()->createBlock('cms/block')->setBlockId('product_view_extend_block')->toHtml(); 
	}
	
}
