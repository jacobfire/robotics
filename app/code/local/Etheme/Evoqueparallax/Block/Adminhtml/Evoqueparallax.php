<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Evoqueparallax_Block_Adminhtml_Evoqueparallax extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_evoqueparallax';
		$this->_blockGroup = 'evoqueparallax';
		$this->_headerText = Mage::helper('evoqueparallax')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('evoqueparallax')->__('Add Item');
		parent::__construct();
	}
}