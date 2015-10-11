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

Mage::getConfig()->saveConfig('cms/wysiwyg/enabled', 'hidden');

/**
 * Adding Different Attributes
 */
$setup->addAttributeGroup('catalog_product', 'Default', 'Video', 1000);

$setup->addAttribute('catalog_product', 'videobox', array(
    'group'         => 'Video',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Video url 1',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'note'=>'ex. http://vimeo.com/47480346  or http://www.youtube.com/watch?v=KckzPvtTnkU',
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_product', 'customtabtitle', array(
    'group'         => 'Custom Tab',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Custom Tab Title',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$setup->addAttribute('catalog_product', 'customtab', array(
    'group'         => 'Custom Tab',
    'input'         => 'textarea',
    'type'          => 'text',
    'label'         => 'Custom Tab',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$installer->endSetup();