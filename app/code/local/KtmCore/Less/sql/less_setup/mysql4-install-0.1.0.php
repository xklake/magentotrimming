<?php
/**
 * @copyright    Copyright (C) 2015 Skstore. All Rights Reserved.
 */

$installer = $this;
$installer->startSetup();

$installer->run("
CREATE TABLE `{$installer->getTable('less/file')}` (
    `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `path` text character set utf8 NOT NULL,
    `cache` text character set utf8 default NULL,
    `use_global_variables` tinyint(1) unsigned NOT NULL default 1,
    `force_global_variables` tinyint(1) unsigned NOT NULL default 0,
    `custom_variables` text character set utf8 default NULL,
    `force_rebuild` tinyint(1) unsigned NOT NULL default 0,
    PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();