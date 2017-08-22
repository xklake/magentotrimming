<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Masonry_Model_System_Config_Items
{public function toOptionArray(){$i = Mage::helper('masonry')->masonryItemsPerPage();$k = array();foreach ($i as $v) {$k[]=array('value' => $v, 'label'=> $v);};return $k;}}