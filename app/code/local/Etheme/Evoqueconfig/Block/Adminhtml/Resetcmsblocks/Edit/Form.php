<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Evoqueconfig_Block_Adminhtml_Resetcmsblocks_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form_builder = new Varien_Data_Form();
        $fieldset = $form_builder->addFieldset('action_fieldset', array('legend'=>Mage::helper('evoqueconfig')->__('Choose store')));

        $fieldset->addField('store_id', 'select', array(
            'name'      => 'store',
            'title'     => Mage::helper('cms')->__('Store View'),
            'label'     => Mage::helper('cms')->__('Store View'),
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            'note'=>'Restore only absent evoque CMS blocks/pages content'
        ));

        $fieldset->addField('cms_rewrite_no', 'checkbox', array(
            'label' => Mage::helper('evoqueconfig')->__('Restore ALL Cms Pages & Blocks'),
            'note' => Mage::helper('evoqueconfig')->__('ATTENTION: Check this and you will restore ALL evoque blocks and pages.'),
            'required' => false,
            'name' => 'cms_rewrite_no',
            'value' => 1,
        ))->setIsChecked(0);


        $form_builder->setMethod('post');
        $form_builder->setAction($this->getUrl('*/*/reset'));
        $form_builder->setUseContainer(true);
        $form_builder->setId('edit_form');
        $this->setForm($form_builder);
        
        return parent::_prepareForm();
    }
}
