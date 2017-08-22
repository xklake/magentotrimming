<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_KtmMenu_Model_System_Config_Source_Mainmenu_Menuleftanimation
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'show', 'label'=>Mage::helper('adminhtml')->__('Show/Hide')),
            array('value'=>'slide', 'label'=>Mage::helper('adminhtml')->__('Slide')),
            array('value'=>'slideWidth', 'label'=>Mage::helper('adminhtml')->__('Slide Width')),
            array('value'=>'fade', 'label'=>Mage::helper('adminhtml')->__('Fade')),
        );
    }

}
