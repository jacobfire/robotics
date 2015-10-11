<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Evoqueconfig_Model_Fields_Source_Productlistingmode
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'simple','label' => Mage::helper('evoqueconfig')->__('Simple (image only)')),
            array('value'=>'usual','label' => Mage::helper('evoqueconfig')->__('Usual (description, price)')),
        );
    }
}
