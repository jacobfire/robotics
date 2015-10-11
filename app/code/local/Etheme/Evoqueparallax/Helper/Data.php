<?php
/**
 * @version   1.0 14.08.2012
 * @author    TonyEcommerce http://www.TonyEcommerce.com <support@TonyEcommerce.com>
 * @copyright Copyright (c) 2012 TonyEcommerce
 */

class Etheme_evoqueparallax_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getDataSlide($num)
    {
        $slide='slide'.$num;
        $xml = new Varien_Simplexml_Config(Mage::getBaseDir().'/app/code/local/Etheme/Evoqueparallax/Model/data_slides.xml');
        $slides=$xml->getXpath('slides');
        $slides=$slides[0];
        return (string)($slides->$slide);
    }
}