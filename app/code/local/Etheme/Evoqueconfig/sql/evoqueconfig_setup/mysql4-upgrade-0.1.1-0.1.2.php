<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alesioo
 * Date: 12.12.12
 * Time: 16:24
 * To change this template use File | Settings | File Templates.
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();

/**
 * Adding Different Attributes
 */


$setup->addAttribute('catalog_category', 'bs_category_lable', array(
    'group'         => 'Megamenu',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Category lable, for ex. "Hot!"',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'This filed is compatible only with 1st-level category',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_category', 'bs_category_icon', array(
    'group'         => 'Megamenu',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Category Icon Image Name"',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'Write image_name.jpg. You must upload manually image icon by ftp in folder /media/wysiwyg/ev_category_icons/image_name.jpg',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$setup->addAttribute('catalog_product', 'videoboxself', array(
    'group'         => 'Video',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Video url 2',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'note'=>'ex. http://vimeo.com/47480346  or http://www.youtube.com/watch?v=KckzPvtTnkU',
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));



$installer->endSetup();