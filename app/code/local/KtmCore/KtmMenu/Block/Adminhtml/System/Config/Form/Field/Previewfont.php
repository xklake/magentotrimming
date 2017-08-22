<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php
class KtmCore_KtmMenu_Block_Adminhtml_System_Config_Form_Field_Previewfont extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element); 
       	$html .= '<br/><div id="font_'.$element->getHtmlId().'" class="font_preview" style="font-size: 13px; padding: 10px; 0">The quick brown fox jumps over the lazy dog 123456789</div>';
       	$html .= '
       			<script type="text/javascript">
       				jQuery(document).ready(function(){
       					var font = jQuery("#'.$element->getHtmlId().'").val();
       					changeFont'.$element->getHtmlId().'(font);
    					jQuery("#'.$element->getHtmlId().'").bind("change", function() {
       						value = jQuery("#'.$element->getHtmlId().'").val();
       						changeFont'.$element->getHtmlId().'(value); 
						});
       					function changeFont'.$element->getHtmlId().'(val){ 
       						var link = jQuery("<link>", {
							    type: "text/css",
							    rel: "stylesheet", 
							    href: "//fonts.googleapis.com/css?family=" + val, 
							}).appendTo("head");
							jQuery("#font_'.$element->getHtmlId().'").css("font-family", val);
    					}
    				});
       			</script>
       			';
        return $html;
    }
}
?>