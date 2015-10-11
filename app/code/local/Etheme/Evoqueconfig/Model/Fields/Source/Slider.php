<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Evoqueconfig_Model_Fields_Source_Slider
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'flex','label' => Mage::helper('evoqueconfig')->__('Flexslider')),
            array('value'=>'parallax','label' => Mage::helper('evoqueconfig')->__('Parallax layered slider')),
        );
    }
}
