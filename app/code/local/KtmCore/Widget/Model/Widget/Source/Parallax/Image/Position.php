<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Parallax_Image_Position{
    public function toOptionArray(){
        $types[] = array('value' => 'center',       'label' => 'center');
        $types[] = array('value' => 'left top',     'label' => 'left top');
        $types[] = array('value' => 'left center',  'label' => 'left center');
        $types[] = array('value' => 'left bottom',  'label' => 'left bottom');
        $types[] = array('value' => 'right top',    'label' => 'right top');
        $types[] = array('value' => 'right center', 'label' => 'right center');
        $types[] = array('value' => 'right bottom', 'label' => 'right bottom');
        $types[] = array('value' => 'center top',   'label' => 'center top');
        $types[] = array('value' => 'center right', 'label' => 'center right');
        $types[] = array('value' => 'center bottom', 'label' => 'center bottom');

        return $types;
    }
}