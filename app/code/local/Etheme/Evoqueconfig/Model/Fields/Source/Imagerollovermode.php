<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_Evoqueconfig_Model_Fields_Source_Imagerollovermode
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'imagerollover','label' => Mage::helper('evoqueconfig')->__('Image rollover')),
            array('value'=>'image_gallery','label' => Mage::helper('evoqueconfig')->__('Info block with image gallery')),
        );
    }
}
