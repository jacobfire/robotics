<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Evoqueflex_Block_Adminhtml_Evoqueflex extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_evoqueflex';
		$this->_blockGroup = 'evoqueflex';
		$this->_headerText = Mage::helper('evoqueflex')->__('Flex Slider');
		$this->_addButtonLabel = Mage::helper('evoqueflex')->__('Add Item');
		parent::__construct();
	}
}