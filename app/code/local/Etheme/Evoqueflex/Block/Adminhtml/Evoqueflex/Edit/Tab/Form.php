<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Evoqueflex_Block_Adminhtml_Evoqueflex_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('evoqueflex_form', array('legend'=>Mage::helper('evoqueflex')->__('Slide information')));


      if (!Mage::app()->isSingleStoreMode()) {
          $fieldset->addField('store_id', 'multiselect', array(
              'name' => 'stores[]',
              'label' => Mage::helper('evoqueflex')->__('Store View'),
              'title' => Mage::helper('evoqueflex')->__('Store View'),
              'required' => true,
              'values' => Mage::getSingleton('adminhtml/system_store')
                  ->getStoreValuesForForm(false, true),
          ));
      }
      else {
          $fieldset->addField('store_id', 'hidden', array(
              'name' => 'stores[]',
              'value' => Mage::app()->getStore(true)->getId()
          ));
      }


      $fieldset->addField('link', 'text', array(
          'label'     => Mage::helper('evoqueflex')->__('Link'),
          'required'  => false,
          'name'      => 'link',
          'index'      => 'link',
      ));

      $fieldset->addField('caption', 'textarea', array(
          'label'     => Mage::helper('evoqueflex')->__('Caption'),
          'required'  => false,
          'name'      => 'caption',
          'index'      => 'caption',
          'note'=>'use such template <br />'.htmlspecialchars('<div  style="font-size:1em; text-transform:uppercase;">forever </div>
                        <div  style="font-size:2em; text-transform:uppercase; font-weight: bold;">in Style</div>
                        <div class="font2" style="font-size:1em; font-style:italic;">For Successful Living</div>')
      ));


	  $data = array();
	  if ( Mage::getSingleton('adminhtml/session')->getevoqueflexData() )
      {
			$data = Mage::getSingleton('adminhtml/session')->getevoqueflexData();
	  } elseif ( Mage::registry('evoqueflex_data') ) {
			$data = Mage::registry('evoqueflex_data')->getData();
	  }


	  $imgfront='';
      if (!empty($data['image']) )$imgfront = '<br/><a href="' . Mage::getBaseUrl('media').$data['image'] . '" target="_blank" >'."<img src=" . Mage::getBaseUrl('media').$data['image'] . " width='200px' alt='' /></a>";

      $fieldset->addField('image', 'file', array(
          'label'     => Mage::helper('evoqueflex')->__('Slide Image'),
          'name'      => 'image',
	      'note' => $imgfront,
	  ));




      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('evoqueflex')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('evoqueflex')->__('Active'),
              ),
              array(
                  'value'     => 2,
                  'label'     => Mage::helper('evoqueflex')->__('Inactive'),
              ),
          ),
      ));

      if ( Mage::getSingleton('adminhtml/session')->getevoqueflexData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getevoqueflexData());
          Mage::getSingleton('adminhtml/session')->setevoqueflexData(null);
      } elseif ( Mage::registry('evoqueflex_data') ) {
          $form->setValues(Mage::registry('evoqueflex_data')->getData());
      }
      return parent::_prepareForm();
  }
}