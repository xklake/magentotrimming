<?php

class KtmCore_Widget_Model_Widget_Source_Listtemplate
{
    public function toOptionArray()
    {

        $path = Mage::getBaseDir('design').'\frontend\skstore\default\template\ktmcore\widget';
        $list_files = array_diff(scandir($path), array('..', '.'));

        $result[] = array(
            'value' => 'ktmcore/widget/default.phtml',
            'label' => 'default.phtml',
        );
        foreach ($list_files as $file){
            if (is_dir($path . DIRECTORY_SEPARATOR . $file)) continue;
            $result[] = array(
                            'value' => 'ktmcore/widget/'.$file,
                            'label' => $file,
                        );
        }

        return $result;
    }
}