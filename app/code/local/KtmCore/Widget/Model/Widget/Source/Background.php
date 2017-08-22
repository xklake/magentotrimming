<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

class KtmCore_Widget_Model_Widget_Source_Background{
    public function toOptionArray(){
        return array(
            array('value' => '', 'label' => 'No'),
            array('value' => 'parallax', 'label' => 'Parallax'),
            array('value' => 'kenburns', 'label' => 'Ken Burns')
        );
    }
}
