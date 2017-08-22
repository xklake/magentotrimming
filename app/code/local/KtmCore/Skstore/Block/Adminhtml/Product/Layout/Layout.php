<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_Skstore_Block_Adminhtml_Product_Layout_Layout extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){
        $html = parent::_getElementHtml($element);
        $imgParth = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/wysiwyg/ktmcore/skstore/product/layout/';
        $js = $this->getJsUrl('ktmcore/lib/jquery/dist/jquery.min.js');
        $jsnoconflict = $this->getJsUrl('ktmcore/lib/jquery-noConflict.js');
        $jsMigrate = $this->getJsUrl('ktmcore/lib/jquery-migrate/jquery-migrate.min.js');
        $html .= '
                <script type="text/javascript" src="'. $js .'"></script>
                <script type="text/javascript" src="'. $jsnoconflict .'"></script>
                <script type="text/javascript" src="'. $jsMigrate .'"></script>
                <script type="text/javascript">jQuery.noConflict();</script>
                ';
        $html .= '<br/><div id="layout_'.$element->getHtmlId().'" class="layout_preview" style="min-height: 210px;"></div>';
        $html .= '
            <script type="text/javascript">
                jQuery(window).load(function(){
                    var layout = jQuery("#'.$element->getHtmlId().' option:selected").val();
                    jQuery("#'.$element->getHtmlId().'")
                        .change(function() {
                            var imageLayout = "";
                            jQuery( "#'.$element->getHtmlId().' option:selected" ).each(function() {
                            imageLayout += "'.$imgParth.'"+jQuery( this ).val()+".png";
                        });
                        jQuery("#layout_'.$element->getHtmlId().'").html("<img src="+imageLayout+" />");
                    }).trigger("change");
                });
            </script>';
        return $html;
    }
}
?>