<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Block_Widget extends Mage_Catalog_Block_Product_Abstract implements Mage_Widget_Block_Interface {
    const CACHE_GROUP = 'ktmcore_widget';
    protected static $_helper;
    protected $_productCollection;

    protected function _construct(){
        parent::_construct();
        if (!self::$_helper && Mage::helper('core')->isModuleEnabled('AW_Blog')) {
            self::$_helper = Mage::helper('blog');
        }
        $this->setData('cache_tags', array(self::CACHE_GROUP, Mage_Core_Block_Template::CACHE_GROUP));
    }

    public function getCacheLifetime(){
        return $this->getData('cache') ? (int)$this->getData('cache') : null;
    }

    public function getCacheKeyInfo(){
        return array(
            self::CACHE_GROUP,
            Mage::app()->getStore()->getId(),
            Mage::getSingleton('customer/session')->getCustomerGroupId(),
            $this->getData('widget_type'),
            $this->getData('widget_tab'),
            $this->getData('collections'),
            $this->getData('category_ids'),
            $this->getData('product_ids'),
            $this->getData('brand'),
            $this->getData('brand_attribute'),
            //$this->getData('attribute_link'),
            $this->getData('block_ids'),
            $this->getData('mode'),
            $this->getData('limit'),
            $this->getData('scroll'),
            $this->getData('row'),
            $this->getData('column'),
            $this->getData('animate'),
            $this->getData('background')
        );
    }

    protected function _beforeToHtml(){
        if ($this->getTemplate() == 'ktmcore/widget/default.phtml'){
            switch ($this->getData('widget_type')){
                case 'product':
                    switch ($this->getData('mode')){
                        case 'related':
                            $this->setTemplate('ktmcore/widget/related.phtml');
                            break;
                        default:
                            $this->setTemplate('ktmcore/widget/product.phtml');
                            break;
                    }
                    switch ($this->getData('widget_tab')){
                        case 'categories':
                        case 'collections':
                            $this->setTemplate('ktmcore/widget/tab.phtml');
                            break;
                    }
                    break;
                case 'attribute':
                    $this->setTemplate('ktmcore/widget/attribute.phtml');
                    break;
                case 'block':
                    $this->setTemplate('ktmcore/widget/block.phtml');
                    break;
                case 'category':
                    $this->setTemplate('ktmcore/widget/category.phtml');
                    break;
				case 'brand':
					 $this->setTemplate('ktmcore/widget/brands.phtml');
                    break;
                case 'blog':
                    $this->setTemplate('ktmcore/widget/blog.phtml');
                    break;
            }
        }
        return parent::_beforeToHtml();
    }

    public function getCategories(){
        if (!$this->getData('category_ids')) return array();

        $categories = array();
        foreach (explode(',', $this->getData('category_ids')) as $categoryId){
            /* @var $category Mage_Catalog_Model_Category */
            $category = Mage::getModel('catalog/category')
                ->setStore(Mage::app()->getStore())
                ->load($categoryId, array('name', 'image', 'thumbnail'));
            if ($category->getId()){
                $categories[] = array(
                    'url'   => $category->getUrl('', Mage::helper('skstore')->checkSSL()),
                    'label' => $category->getName(),
                    'image' => $category->getThumbnail() ? Mage::getBaseUrl('media'). 'catalog/category/' . $category->getThumbnail() : '',
                    'count' => $category->getProductCount()
                );
            }
        }

        return $categories;
    }

    public function getTabs(){
        $tabs = array();
        $type = $this->getData('widget_tab');
        $labels = explode('||', $this->getData('labels'));

        switch ($type){
            case 'categories':
                $categoryIds = explode(',', $this->getData('category_ids'));
                foreach ($categoryIds as $index => $categoryId){
                    /* @var $categoryModel Mage_Catalog_Model_Category */
                    $categoryModel = Mage::getModel('catalog/category')->load($categoryId, array('name'));
                    if ($categoryModel->getId()){
                        $tabs[] = array(
                            'type'  => 'category',
                            'id'    => 'category-' . $categoryModel->getId(),
                            'label' => isset($labels[$index]) && $labels[$index] ? $labels[$index] : $categoryModel->getName(),
                            'value' => $categoryModel->getId()
                        );
                    }
                }
                break;
            case 'collections':
                $collectionNames = $this->getData('collections');
                if (!is_array($collectionNames)) $collectionNames = explode(',', $this->getData('collections'));
                foreach ($collectionNames as $index => $collectionName){
                    $tabs[] = array(
                        'type'  => 'collection',
                        'id'    => 'collection-' . $collectionName,
                        'label' => isset($labels[$index]) && $labels[$index] ? $labels[$index] : $collectionName,
                        'value' => $collectionName
                    );
                }
                break;
        }

        return $tabs;
    }

    public function checkCollectionSize($type, $value){
        $collection = $this->_getProductCollection($type, $value);
        return $collection->count();
    }

    public function renderCollection($type, $value, $template='ktmcore/widget/collection.phtml', $pricePrefixId = null){
        /* @var $block KtmCore_Widget_Block_Widget_Collection */
        $block = $this->getLayout()->createBlock('ktmwidget/widget_collection');

        $block->setData(array(
            'row'           => $this->getConfig('row'),
            'column'        => $this->getConfig('column'),
            'carousel'      => $this->getConfig('scroll'),
            'collection'    => $this->_getProductCollection($type, $value),
            'price-prefix'  => $pricePrefixId
        ));
        $block->setTemplate($template);

        return $block->toHtml();
    }

    protected function _getProductCollection($type, $value){
        if (!$this->_productCollection){
            /* @var $helper KtmCore_Widget_Helper_Data */
            $helper = Mage::helper('ktmwidget');
            $params = array();

            if ($this->getData('category_ids')){
                $params['category_ids'] = explode(',', $this->getData('category_ids'));
            }
            if ($this->getData('product_ids')){
                $params['product_ids'] = explode(',', $this->getData('product_ids'));
            }
            if ($this->getCustomerId()) {
                $params['customer_id'] = $this->getCustomerId();
            }
            $this->_productCollection = $helper->getProductCollection($type, $value, $params, $this->getLimit());
        }

        return $this->_productCollection;
    }

    public function getLimit(){
        return is_numeric($this->getData('limit')) ? $this->getData('limit') : 10;
    }

    public function getBlocks(){
        $blocks     = array();
        $layout     = $this->getLayout();
        $storeId    = Mage::app()->getStore()->getId();

        $classes    = array();
        $order      = array();

        foreach (array('lg', 'md', 'sm', 'xs') as $l){
            foreach (explode('|', $this->getData('block_' . $l)) as $block){
                list($blockId, $column, $cls) = explode(',', $block);

                if (!isset($classes[$blockId])){
                    $classes[$blockId] = "col-{$l}-{$column} ";
                }else{
                    $classes[$blockId] .= "col-{$l}-{$column} ";
                }
                $classes[$blockId] .= "{$cls} ";

                if (!in_array($blockId, $order)){
                    $order[] = $blockId;
                }
            }
        }

        foreach ($order as $blockId){
            /* @var $collection Mage_Cms_Model_Resource_Block_Collection */
            $collection = Mage::getResourceModel('cms/block_collection')
                ->addFieldToFilter('identifier', array('eq' => $blockId));

            if ($collection->count()){
                /* @var $block Mage_Cms_Model_Block */
                $block = $collection->getFirstItem();
                $block->load($block->getId());
                $storeIds = $block->getStoreId();
                if ($block->getIsActive() && (in_array($storeId, $storeIds) || in_array(0, $storeIds))){
                    $blocks[] = array(
                        'class'     => isset($classes[$blockId]) ? $classes[$blockId] : '',
                        'content'   => $layout->createBlock('cms/block')->setStoreId()->setBlockId($blockId)->toHtml()
                    );
                }
            }
        }

        return $blocks;
    }

    public function getBlog()
    {
        if(Mage::helper('core')->isModuleEnabled('AW_Blog')) {
            $catids = (array)$this->getData('blog_cat_ids');
            $collection = Mage::getModel('blog/blog')->getCollection()
                ->addPresentFilter()
                ->addEnableFilter(AW_Blog_Model_Status::STATUS_ENABLED)
                ->addStoreFilter()
                ->addCatsFilter(implode(',', $catids));

            //Set limit article to display
            $collection->setPageSize((int)$this->getData('count'));

            //Set order
            $sortDirection = $this->getData('order');
            if($sortDirection == KtmCore_Widget_Helper_Data::BLOG_POST_ORDER_RANDOM){
                $collection->getSelect()->orderRand(new Zend_Db_Expr('RAND()'));
            } else {
                $collection->setOrder('created_time', $sortDirection);
            }

            foreach ($collection as $item) {
                $item->setPostContent($this->truncate(strip_tags($item->getShortContent()), $length = 100, $etc = ' ...'));
                $item->setAddress($this->getBlogUrl($item->getIdentifier()));
            }
            return $collection;
        }
    }

    public function truncate($string, $chars = 50, $terminator = ' ...')
    {
        $cutPos = $chars - mb_strlen($terminator);
        $boundaryPos = mb_strrpos(mb_substr($string, 0, mb_strpos($string, ' ', $cutPos)), ' ');
        return mb_substr($string, 0, $boundaryPos === false ? $cutPos : $boundaryPos) . $terminator;
    }

    public function getBlogUrl($route = null, $params = array())
    {
        $blogRoute = self::$_helper->getRoute();
        if (is_array($route)) {
            foreach ($route as $item) {
                $item = urlencode($item);
                $blogRoute .= "/{$item}";
            }
        } else {
            $blogRoute .= "/{$route}";
        }

        foreach ($params as $key => $value) {
            $value = urlencode($value);
            $blogRoute .= "{$key}/{$value}/";
        }

        return $this->getUrl($blogRoute, Mage::helper('skstore')->checkSSL());
    }

    public function getAttibuteOptions(){
        $showOptions = explode(',', $this->getData('attribute_options'));
        list($attributeId, $attributeCode) = explode(',' , $this->getData('attribute'));

        $optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setAttributeFilter($attributeId)
            ->setStoreFilter()
            ->load();

        $options = array();
        foreach ($optionCollection as $option){
            if (in_array($option->getId(), $showOptions)){
                if ($this->getData('attribute_link')){
                    $options[] = array(
                        'id'    => $option->getId(),
                        'label' => $option->getValue(),
                        'image' => $option->getImage() ?
                                (
                                    strpos($option->getImage(), 'http') === 0 ?
                                    $option->getImage() :
                                    Mage::getBaseUrl('media') . $option->getImage()
                                ):
                                null,
                        'link'  => $this->getUrl('catalogsearch/result/index', array_merge(Mage::helper('skstore')->checkSSL(), array('q' => $option->getValue())))
                    );
                }else{
                    $options[] = array(
                        'id'    => $option->getId(),
                        'label' => $option->getValue(),
                        'image' => $option->getImage() ?
                                (
                                    strpos($option->getImage(), 'http') === 0 ?
                                    $option->getImage() :
                                    Mage::getBaseUrl('media') . $option->getImage()
                                ):
                                null
                    );
                }
            }
        }

        return $options;
    }
	
	public function getHyphenatedString($str)
    {
        $result = false;
        if (function_exists('iconv')) {
            $result = @iconv('UTF-8', 'ASCII//TRANSLIT', $str); // will issue a notice on failure, we handle failure
        }

        if (!$result) {
            $result = dechex(crc32($this->normalizeKey($str)));
        }

        return preg_replace('/([^a-z0-9]+)/', '-', $this->normalizeKey($result));
    }

    public function normalizeKey($key) {
        if (function_exists('mb_strtolower')) {
            return trim(mb_strtolower($key, 'UTF-8'));
        }
        return trim(strtolower($key));
    }
	
	public function getBrands(){
		$brand = trim($this->getData('brand_attribute'));	
		$attribute = Mage::getSingleton('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, $brand);
		$options = $attribute->getSource()->getAllOptions(false);
		$brandArray = array();
		$linkType = $this->getData('brand_img_link');
		$ext = trim($this->getData('brand_img_extensions'));
		foreach ($options as $option) {
			$imgOption = $this->getImageBrand($option["label"],$ext );
			if (!$imgOption) {
				$imgOption = $option["label"];
			}
			$brandArray[] = array(
				'id'    => $option["value"],
                'label' => $option["label"],
				'image' => $this->getImageBrand($option["label"],$ext ),
				'link'  => $this->getBrandLink($attribute,$option,$linkType)
			);
			
		}
		return $brandArray;
	}
	
	public function existBrandFile($filename) {
		$basedir = Mage::getBaseDir('media');
		$basepath = $basedir . DS . 'wysiwyg' .DS . 'ktmcore'. DS . 'brands' .DS;
		$imageFile = $basepath . $filename;
		return file_exists ($imageFile);
	}
	
	public function getImageBrand($optionLabel,$ext = 'png') {
		if ($ext) {
			$ext = trim(strip_tags($ext));
		}
		$label = $this->getHyphenatedString($optionLabel);
		$imageName = $label. "." .$ext;
		if ($this->existBrandFile($imageName)){
			$imgageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'wysiwyg/ktmcore/brands/'.$imageName;
			return $imgageUrl;
		}	else {
			return false;
		}
	}
	
	public function getBrandLink($attributeCode,$option,$linkType) {
		
		$optionLabel = trim ($option["label"]);
		$optionValue = $option["value"];
		if ($linkType == 0) {
			return false;
		}	
		else if ($linkType==1) {
			$link = Mage::getBaseUrl().'catalogsearch/result/?q=' .  str_replace(" ", "+", $optionLabel );
			return $link;
		}	
		else if ($linkType==2) {
			$link = Mage::getBaseUrl().'catalogsearch/advanced/result/?=' .$attributeCode . '=' .$optionValue;
			return $link;
		}	
		else if ($linkType==3) {
			$custom_link_type = $this->getData("brand_link_option");
			if ($custom_link_type == "cms") {
				$cmsPage = trim($this->getData('brand_link_cms'));
				$link = Mage::helper('cms/page')->getPageUrl($cmsPage);
			}	else {
				$brands_parent_cate_id = trim($this->getData('brand_link_cate'));
				$cateid = explode(",",$brands_parent_cate_id)[0];
				$cate = Mage::getModel("catalog/category")->load($cateid);
				
				$link =  Mage::getBaseUrl(). $cate->getUrlKey() ."/". $this->getHyphenatedString($optionLabel).'.html';
				return $link;
			}
			
		}
		
	}
	
	
    protected function _getKenburnsImages(){
        $prefix = Mage::getBaseUrl('media');
        $images = $this->getData('kenburns_images');
        $out = array();

        if (!is_array($images)){
            $images = explode(',', $images);
        }

        foreach ($images as $image){
            if ($image){
                $out[] = strpos($image, 'http') !== false ? $image : $prefix . $image;
            }
        }

        if (count($out) == 1){
            $out[] = $out[0];
        }

        return $out;
    }
	public function outputRelativeHtml($data) {
		return Mage::helper('cms')->getPageTemplateProcessor()->filter($data);
	}
    public function getConfig($name, $param=null){
        /* @var $helper Mage_Core_Helper_Data */
        $helper = Mage::helper('core');

        switch ($name){
			case 'widget_custom_html_bottom':
				return $this->outputRelativeHtml($this->getData('widget_custom_html_bottom'));
				break;
			case 'widget_description':
				return $this->outputRelativeHtml($this->getData('widget_description'));
				break;
            case 'countdown':
                return $helper->jsonEncode(array(
                    'enable'            => (bool) $this->getData('countdown'),
                    'yearText'          => Mage::helper('ktmwidget')->__('years'),
                    'monthText'         => Mage::helper('ktmwidget')->__('months'),
                    'weekText'          => Mage::helper('ktmwidget')->__('weeks'),
                    'dayText'           => Mage::helper('ktmwidget')->__('days'),
                    'hourText'          => Mage::helper('ktmwidget')->__('hours'),
                    'minText'           => Mage::helper('ktmwidget')->__('mins'),
                    'secText'           => Mage::helper('ktmwidget')->__('secs'),
                    'yearSingularText'  => Mage::helper('ktmwidget')->__('year'),
                    'monthSingularText' => Mage::helper('ktmwidget')->__('month'),
                    'weekSingularText'  => Mage::helper('ktmwidget')->__('week'),
                    'daySingularText'   => Mage::helper('ktmwidget')->__('day'),
                    'hourSingularText'  => Mage::helper('ktmwidget')->__('hour'),
                    'minSingularText'   => Mage::helper('ktmwidget')->__('min'),
                    'secSingularText'   => Mage::helper('ktmwidget')->__('sec'),
                    'engineSrc'         => Mage::getBaseUrl('js') . 'ktmcore/lib/jcountdown/dist/jquery.jcountdown.min.js'
                ));
                break;
            case 'kenburns':
                return $helper->jsonEncode(array(
                    'enable'    => $this->getData('background') == 'kenburns',
                    'images'    => $this->_getKenburnsImages(),
                    'overlay'   => $this->getData('background_overlay'),
                    'engineSrc' => Mage::getBaseUrl('js') . 'ktmcore/extensions/jquery/plugins/kenburns.js'
                ));
                break;
            case 'parallax':
                return $helper->jsonEncode(array(
                    'enable'    => $this->getData('background') == 'parallax',
                    'type'      => $this->getData('parallax_type'),
                    'overlay'   => $this->getData('background_overlay'),
                    'video'     => array(
                        'src'       => $this->getData('parallax_video_src'),
                        'volume'    => (bool) $this->getData('parallax_video_volume'),
                    ),
                    'image'     => array(
                        'src'       => $this->getData('parallax_image_src') ?
                                        (
                                            strpos($this->getData('parallax_image_src'), 'http') === 0 ?
                                            $this->getData('parallax_image_src') :
                                            Mage::getBaseUrl('media') . $this->getData('parallax_image_src')
                                        ):
                                        null,
                        'fit'       => $this->getData('parallax_image_fit'),
                        'repeat'    => $this->getData('parallax_image_repeat'),
                        'height'    => $this->getData('parallax_content_height') ? $this->getData('parallax_content_height') : '500px'
                    ),
                    'file'      => array(
                        'poster'    => $this->getData('parallax_video_poster') ?
                                        (
                                            strpos($this->getData('parallax_video_poster'), 'http') === 0 ?
                                            $this->getData('parallax_video_poster') :
                                            Mage::getBaseUrl('media') . $this->getData('parallax_video_poster')
                                        ):
                                        null,
                        'mp4'       => $this->getData('parallax_video_mp4') ?
                                        (
                                            strpos($this->getData('parallax_video_mp4'), 'http') === 0 ?
                                            $this->getData('parallax_video_mp4') :
                                            Mage::getBaseUrl('media') . $this->getData('parallax_video_mp4')
                                        ):
                                        null,
                        'webm'      => $this->getData('parallax_video_webm') ?
                                        (
                                            strpos($this->getData('parallax_video_webm'), 'http') === 0 ?
                                            $this->getData('parallax_video_webm') :
                                            Mage::getBaseUrl('media') . $this->getData('parallax_video_webm')
                                        ):
                                        null,
                        'volume'    => (bool) $this->getData('parallax_video_volume')
                    )
                ));
                break;
            case 'carousel':
                return $helper->jsonEncode(array(
                    'enable'                => (bool) $this->getData('scroll'),
                    'dots'                  => (bool) $this->getData('paging'),
                    'autoplay'              => is_numeric($this->getData('autoplay')) ? true : false,
                    'autoplayTimeout'       => is_numeric($this->getData('autoplay')) ? (int) $this->getData('autoplay') : false,
                    'autoplayHoverPause'    => flase,
                    'smartSpeed'            => 500,
                    'animateOut'            => 'fadeOut',
                    'animateIn'             => 'fadeIn',
                    'items'                 => is_numeric($this->getData('column')) ? (int) $this->getData('column') : 4,
                    'loop'                  => false,
                    'lazyLoad'              => true,
                    'margin'                => is_numeric($this->getData('margin')) ? (int) $this->getData('margin') : 30,
                    'autoHeight'            => false,
                    'rtl'                   => $this->helper('skstore')->getThemeLayoutCfg('responsive/rtl_language') ? true : false,
                    'responsive'            => array(
                        0=>Mage::helper('ktmwidget')->string2KeyedArray($this->getData('x0')),
                        480=>Mage::helper('ktmwidget')->string2KeyedArray($this->getData('x480')),
                        768=>Mage::helper('ktmwidget')->string2KeyedArray($this->getData('x768')),
                        992=>Mage::helper('ktmwidget')->string2KeyedArray($this->getData('x992')),
                        1200=>Mage::helper('ktmwidget')->string2KeyedArray($this->getData('x1200'))
                    ),
                    'nav'                   => (bool) $this->getData('navigation'),
                    'rewind'                => true,
                    'navText'               => array($this->getData('navigation_prev')?$this->getData('navigation_prev'):'<i class="fa fa-angle-left"></i>', $this->getData('navigation_next')?$this->getData('navigation_next'):'<i class="fa fa-angle-right"></i>'),
                    'engineSrc'             => Mage::getBaseUrl('js') . 'ktmcore/lib/owl-carousel2/dist/owl.carousel.min.js'
                ));
                break;
            case 'animation':
                return $helper->jsonEncode(array(
                    'enable'        => (bool) $this->getData('animate'),
                    'animationName' => $this->getData('animation'),
                    'animationDelay'=> is_numeric($this->getData('animation_delay')) ? (int) $this->getData('animation_delay') : 300,
                    'itemSelector'  => $this->getData('animate_item_selector'),
                    'engineSrc'     => Mage::getBaseUrl('js') . 'ktmcore/extensions/wow/wow.js'
                ));
                break;
            case 'widget_title':
                return $this->getData('widget_title');
                break;
			case 'layout_type':
				return $this->getData('layout_type'); 
				break;
			case 'brand_attribute':
				return $this->escapeHtml($this->getData('brand_attribute')); 
				break;				
            case 'id':
                return $helper->uniqHash(is_string($param) ? $param : 'widget-');
                break;
            case 'row':
                return is_numeric($this->getData('row')) ? (int) $this->getData('row') : 1;
                break;
            case 'column':
                return is_numeric($this->getData('column')) ? (int) $this->getData('column') : 4;
                break;
            case 'limit':
                return is_numeric($this->getData('limit')) ? (int) $this->getData('limit') : 1;
                break;
            case 'classes':
                return $this->getData('classes') . ($this->getData('animate') ? ' ' . $this->getData('animation') : '');
                break;
			case 'text_readmore':
				return $this->escapeHtml($this->getData('text_readmore'));
				break;
            default:
                return $this->getData($name);
        }
    }

    public function countTimeFromStart($timing) {
        return AW_Blog_Block_Blog::timeShowing($timing);
    }
}