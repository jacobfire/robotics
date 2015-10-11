<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alesioo
 * Date: 24.10.13
 * Time: 17:39
 * To change this template use File | Settings | File Templates.
 */

class Etheme_Evoqueconfig_Block_Core_Text_List extends Mage_Core_Block_Text {
    protected function _toHtml()
    {
        $this->setText('');
        foreach ($this->getSortedChildren() as $name) {
            $block = $this->getLayout()->getBlock($name);
            if (!$block) {
                Mage::throwException(Mage::helper('core')->__('Invalid block: %s', $name));
            }
            $move=' move-xs';
            if(str_replace('.','_',$name)=='ev_leftmenu')$move=' catalog active';

            if($this->getNameInLayout()=='left')$this->addText('<div id="Navigation_panel_'.str_replace('.','_',$name).'" class="navigation_panel'.$move.'">');
            $this->addText($block->toHtml());
            if($this->getNameInLayout()=='left')$this->addText('</div>');
        }
        return parent::_toHtml();
    }
}