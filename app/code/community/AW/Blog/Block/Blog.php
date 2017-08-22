<?php

class AW_Blog_Block_Blog extends AW_Blog_Block_Abstract
{
    public function getPosts()
    {
        $collection = $this->_prepareCollection();
        $tag = $this->getRequest()->getParam('tag');
        if ($tag) {
            $collection->addTagFilter(urldecode($tag));
        }
        parent::_processCollection($collection);
        return $collection;
    }

    protected function _prepareLayout()
    {
        if ($this->isBlogPage() && ($breadcrumbs = $this->getCrumbs())) {
            parent::_prepareMetaData(self::$_helper);
            $tag = $this->getRequest()->getParam('tag', false);
            if ($tag) {
                $tag = urldecode($tag);
                $breadcrumbs->addCrumb(
                    'blog',
                    array(
                        'label' => self::$_helper->getTitle(),
                        'title' => $this->__('Return to ' . self::$_helper->getTitle()),
                        'link'  => $this->getBlogUrl(),
                    )
                );
                $breadcrumbs->addCrumb(
                    'blog_tag',
                    array(
                        'label' => $this->__('Tagged with "%s"', self::$_helper->convertSlashes($tag)),
                        'title' => $this->__('Tagged with "%s"', $tag),
                    )
                );
            } else {
                $breadcrumbs->addCrumb('blog', array('label' => self::$_helper->getTitle()));
            }
        }
    }

    protected function _prepareCollection()
    {
        if (!$this->getData('cached_collection')) {
            $sortOrder = $this->getRequest()->getParam('order', self::DEFAULT_SORT_ORDER);
            $sortDirection = $this->getCurrentDirection();
            $collection = Mage::getModel('blog/blog')->getCollection()
                ->addPresentFilter()
                ->addEnableFilter(AW_Blog_Model_Status::STATUS_ENABLED)
                ->addStoreFilter()
                ->joinComments()
            ;
            $collection->setOrder($collection->getConnection()->quote($sortOrder), $sortDirection);
            $collection->setPageSize((int)self::$_helper->postsPerPage());

            $this->setData('cached_collection', $collection);
        }
        return $this->getData('cached_collection');
    }


    public function getCurrentDirection()
    {
        $dir = $this->getRequest()->getParam('dir');

        if (in_array($dir, array('asc', 'desc'))) {
            return $dir;
        }

        return Mage::helper('blog')->defaultPostSort(Mage::app()->getStore()->getId());
    }
    public static function timeShowing($previousTimeStamp) {
        //$previousTimeStamp = strtotime("2016/05/11 11:12:34");
 
        $todayTime = strtotime(Mage::getModel('core/date')->date('Y-m-d H:i:s'));
        
        $menos=$todayTime-$previousTimeStamp;

        $mins=$menos/60;
            if($mins<1) {
                $showing= $menos . " seconds ago";
            }else {
                $minsfinal=floor($mins);
                $secondsfinal=$menos-($minsfinal*60);
                $hours=$minsfinal/60;
                    if($hours<1) {
                        if($minsfinal > 1) {$showing= $minsfinal . " minutes ago";}
                        else {$showing= $minsfinal . " minute ago";}

                    }else {
                        $hoursfinal=floor($hours);
                        $minssuperfinal=$minsfinal-($hoursfinal*60);
                        $days=$hoursfinal/24;
                            if($days<1) {
                                if($hoursfinal > 1) {$showing= $hoursfinal . " hours ago";}
                                else {$showing= $hoursfinal . " hour ago";}

                            }else {
                                $daysfinal=floor($days);
                                $hourssuperfinal=$hoursfinal-($daysfinal*24);
                                $mounths = $daysfinal/30;
                                if($mounths<1){
                                    if($daysfinal > 1) {$showing= $daysfinal. " days ago";}
                                    else {$showing= $daysfinal. " day ago";}
                                }else {
                                    $mounthsfinal = floor($mounths);
                                    $years = $mounthsfinal/12;
                                    if($years<1){
                                        if($mounthsfinal > 1) {$showing = $mounthsfinal. " Months ago";}
                                        else {$showing = $mounthsfinal. " Month ago";}
                                    }else {
                                        $yearsfinal = floor($years);
                                        if($mounthsfinal > 1) {$showing = $yearsfinal. " Years ago";}
                                        else {$showing = $yearsfinal. " Year ago";}
                                    }
                                }
                                
                                
                            }
                    }
            }

        return $showing;
    }
}