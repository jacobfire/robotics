<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Evoqueconfig_Model_Fields_Source_Productcustomblock
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'customhtml','label' => Mage::helper('evoqueconfig')->__('Custom HTML')),
            array('value'=>'related','label' => Mage::helper('evoqueconfig')->__('Related Products')),
            array('value'=>'0','label' => Mage::helper('evoqueconfig')->__('Disabled')),
        );
    }
}
