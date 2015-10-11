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
$setup->addAttribute('catalog_category', 'doubleproduct', array(
    'group'         => 'DoubleProduct',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Double product size',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'is_wysiwyg_enabled' => 1,
    'visible_on_front' => 1,
    'note'=>'Write product IDs separate by comma. Script works perfectly in all devices and dimentions if you set One product id',
    'is_html_allowed_on_front' => 1,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$installer->endSetup();