<?php
$installer = $this;
$installer->startSetup();

$installer->getConnection()
->addColumn($installer->getTable('blog/cat'),'level', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => false,
    'length'    => 50,
    'after'     => 'cat_id', // column name to insert new column after
    'comment'   => 'Level'
    ));
$installer->getConnection()
->addColumn($installer->getTable('blog/cat'),'parent', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => false,
    'length'    => 50,
    'after'     => 'cat_id', // column name to insert new column after
    'comment'   => 'Parent'
    ));
$installer->getConnection()
->addColumn($installer->getTable('blog/cat'),'path', array(
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'nullable'  => false,
    'length'    => 255,
    'after'     => 'cat_id', // column name to insert new column after
    'comment'   => 'Path'
    )); 
$installer->endSetup();