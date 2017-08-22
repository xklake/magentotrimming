<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */
?>
<?php

class KtmCore_Skstore_Model_Import_Cms extends Mage_Core_Model_Abstract
{
	private $_importPath;

	public function __construct()
    {
        parent::__construct();
		$this->_importPath = Mage::getBaseDir() . '/app/code/local/KtmCore/Skstore/etc/import/';
    }
	
	/**
	 * Import CMS items
	 * @param string model string
	 * @param string name of the main XML node (and name of the XML file)
	 * @param bool overwrite existing items
	 */

	public function importCmsItems($modelString, $itemContainerNodeString, $overwrite = false)
    {
		try
		{
			$xmlPath = $this->_importPath . $itemContainerNodeString . '.xml';
			if (!is_readable($xmlPath))
			{
				throw new Exception(
					Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath)
					);
			}
			$xmlObj = new Varien_Simplexml_Config($xmlPath);
			
			$conflictingOldItems = array();
			$i = 0;
			foreach ($xmlObj->getNode($itemContainerNodeString)->children() as $item)
			{

				//Check if block already exists
				$oldBlocks = Mage::getModel($modelString)->getCollection()
					->addFieldToFilter('identifier', $item->identifier)
					->load();
				
				//If items can be overwritten
				if ($overwrite)
				{
					if (count($oldBlocks) > 0)
					{
						$conflictingOldItems[] = $item->identifier;
						foreach ($oldBlocks as $old)
							$old->delete();
					}
				}
				else
				{
					if (count($oldBlocks) > 0)
					{
						$conflictingOldItems[] = $item->identifier;
						continue;
					}
				}
				
				if ($modelString == 'cms/page') {
                    Mage::getModel($modelString)
                        ->setInstanceId($item->instance_id)
                        ->setTitle($item->title)
                        ->setRootTemplate($item->root_template)
                        ->setContent($item->content)
                        ->setIdentifier($item->identifier)
                        ->setIsActive($item->is_active)
                        ->setStores(array(0))
                        ->save();
                } else {
                    Mage::getModel($modelString)
                        ->setInstanceId($item->instance_id)
                        ->setTitle($item->title)
                        ->setContent($item->content)
                        ->setIdentifier($item->identifier)
                        ->setIsActive($item->is_active)
                        ->setStores(array(0))
                        ->save();
                }
				$i++;
			}
			
			//Final info
			
			if ($i)
			{
				Mage::getSingleton('adminhtml/session')->addSuccess(
					Mage::helper('adminhtml')->__('Number of imported items: %s', $i)
				);
			}
			else
			{
				Mage::getSingleton('adminhtml/session')->addNotice(
					Mage::helper('adminhtml')->__('No items were imported')
				);
			}
			
			if ($overwrite)
			{
				if ($conflictingOldItems)
					Mage::getSingleton('adminhtml/session')->addSuccess(
						Mage::helper('adminhtml')
						->__('Items (%s) with the following identifiers were overwritten:<br />%s', count($conflictingOldItems), implode(', ', $conflictingOldItems))
					);
			}
			else
			{
				if ($conflictingOldItems)
					Mage::getSingleton('adminhtml/session')->addNotice(
						Mage::helper('adminhtml')
						->__('Unable to import items (%s) with the following identifiers (they already exist in the database):<br />%s', count($conflictingOldItems), implode(', ', $conflictingOldItems))
					);
			}
		}
		catch (Exception $e)
		{
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			Mage::logException($e);
		}
    }

    /**
     * Import Widget items
     * @param string model string
     * @param string name of the main XML node (and name of the XML file)
     * @param bool overwrite existing items
     */

    public function importWidgetItems($modelString, $itemContainerNodeString, $overwrite = false)
    {
        try
        {
            $xmlPath = $this->_importPath . $itemContainerNodeString . '.xml';
            if (!is_readable($xmlPath))
            {
                throw new Exception(
                    Mage::helper('adminhtml')->__("Can't read data file: %s", $xmlPath)
                );
            }
            $xmlObj = new Varien_Simplexml_Config($xmlPath);

            $i = 0;
            foreach ($xmlObj->getNode($itemContainerNodeString)->children() as $item)
            {
                $model = Mage::getModel($modelString)
                    ->setTitle($item->title)
                    ->setInstanceType($item->instance_type)
                    ->setPackageTheme($item->package_theme)
                    ->setWidgetParameters($item->widget_parameters)
                    ->setSortOrder($item->sort_order)
                    ->save();
                foreach($item->page as $object){
                    Mage::getSingleton('skstore/resource_widget')->importInstancePage($model->getInstanceId(), $object, $item->sort_order, $item->xml);
                }
                $i++;
            }
            //Final info
            if ($i)
            {
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Number of imported items: %s', $i)
                );
            }
            else
            {
                Mage::getSingleton('adminhtml/session')->addNotice(
                    Mage::helper('adminhtml')->__('No items were imported')
                );
            }
        }
        catch (Exception $e)
        {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::logException($e);
        }
    }
}
