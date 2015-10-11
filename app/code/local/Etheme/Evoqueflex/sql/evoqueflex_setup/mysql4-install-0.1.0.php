<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */
$installer = $this;
$installer->startSetup();
$installer->run("

DROP TABLE IF EXISTS `{$this->getTable('evoqueflex')}`;
CREATE TABLE `{$this->getTable('evoqueflex')}` (
  `slide_id` int(11) unsigned NOT NULL auto_increment,
  `image` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `store_id` varchar(255) NOT NULL default '',
  `caption` text NOT NULL default '',
  PRIMARY KEY (`slide_id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `{$this->getTable('evoqueflex')}` (`slide_id`, `image`, `link`, `status`, `store_id`, `caption`) VALUES (1, 'etheme/evoque/evoqueflex/slider1.jpg', '#', 1, '0', '<div  style=\"font-size:1em; text-transform:uppercase;\">Elegance is the</div><div  style=\"font-size:1.8em; text-transform:uppercase; font-weight: bold;\">only beauty</div><div class=\"font2\" style=\"font-size:1em;  font-style:italic;\">That never fades</div>');
INSERT INTO `{$this->getTable('evoqueflex')}` (`slide_id`, `image`, `link`, `status`, `store_id`, `caption`) VALUES (2, 'etheme/evoque/evoqueflex/slider2.jpg', '#', 1, '0', '<div  style=\"font-size:1em; text-transform:uppercase;\">forever </div><div  style=\"font-size:2em; text-transform:uppercase; font-weight: bold;\">in Style</div><div class=\"font2\" style=\"font-size:1em; font-style:italic;\">For Successful Living</div>');
INSERT INTO `{$this->getTable('evoqueflex')}` (`slide_id`, `image`, `link`, `status`, `store_id`, `caption`) VALUES (3, 'etheme/evoque/evoqueflex/slider3.jpg', '#', 1, '0', '<div  style=\"font-size:1em; text-transform:uppercase;\">A fashion </div><div  style=\"font-size:2em; text-transform:uppercase; font-weight: bold;\">is nothing</div><div class=\"font2\" style=\"font-size:1em; font-style:italic;\">But an induced epidemic</div>');

");
$installer->endSetup();




