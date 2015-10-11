<?php
class Etheme_Evoqueconfig_Block_Megamenu extends Mage_Catalog_Block_Navigation
{

    /**
     * Render category to html
     *
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @param boolean Whether ot not this item is first, affects list item class
     * @param boolean Whether ot not this item is outermost, affects list item class
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @param boolean Whether ot not to add on* attributes to list item
     * @return string
     */
    public function _renderCategoryMenuItemHtml($category,
                                                $level = 0,
                                                $isLast = false,
                                                $isFirst = false,
                                                $isOutermost = false,
                                                $outermostItemClass = '',
                                                $childrenWrapClass = '',
                                                $noEventAttributes = false)
    {
        if (!$category->getIsActive()) {
            return '';
        }
        $html = array();

        // get all children
        if (Mage::helper('catalog/category_flat')->isEnabled()) {
            $children = (array)$category->getChildrenNodes();
            $childrenCount = count($children);
        } else {
            $children = $category->getChildren();
            $childrenCount = $children->count();
        }
        $hasChildren = ($children && $childrenCount);

        // select active children
        $activeChildren = array();
        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $activeChildren[] = $child;
            }
        }
        $activeChildrenCount = count($activeChildren);
        $hasActiveChildren = ($activeChildrenCount > 0);




        // prepare list item html classes

        $classes = array();
        if($level==0)
        {
            $classes[]='title';
        }
        $classes[] = 'level' . $level;
        $classes[] = 'nav-' . $this->_getItemPosition($level);
        if ($this->isCategoryActive($category)) {
            $classes[] = 'active';
        }
        $linkClass = '';
        if ($isOutermost && $outermostItemClass) {
            $classes[] = $outermostItemClass;
            $linkClass = ' class="'.$outermostItemClass.'"';
        }
        if ($isFirst) {
            $classes[] = 'first';
        }
        if ($isLast) {
            $classes[] = 'last';
        }
        if ($hasActiveChildren) {
            $classes[] = 'parent';
        }



        if ($this->isCategoryActive($category)) {
            $classes[] = 'current';
        }

         $classes[]='collapse closed';


        // prepare list item attributes
        $attributes = array();
        if (count($classes) > 0) {
            $attributes['class'] = implode(' ', $classes);
        }
        if ($hasActiveChildren && !$noEventAttributes) {
            $attributes['onmouseover'] = 'toggleMenu(this,1)';
            $attributes['onmouseout'] = 'toggleMenu(this,0)';
        }


        if($level==0) {
            $category_data=Mage::getModel('catalog/category')->load($category->getId());
        }


        if($level==0)
        {
            $html[]='<li class="col"><ul>';
        }


        // assemble list item with attributes

        $htmlLi = '<li';
        foreach ($attributes as $attrName => $attrValue) {
            $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
        }
        $htmlLi .= '>';
        $html[] = $htmlLi;

        if($level==0)
        {
            if($category_icon=$category_data->getBs_category_icon())
            {
                $html[]='<img class="icon" alt="" width="28"  src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'wysiwyg/ev_category_icons/'.$category_icon.'">';
            }
        }


        $html[] = '<a class="collapse closed" href="'.$this->getCategoryUrl($category).'">'. $this->escapeHtml($category->getName());






        if($level==0)
        {
            $label= $category_data->getBs_category_lable();
            if(!empty($label))$html[]='<span class="hot"> '.$label.' </span>';
        }



        $html[] ='</a>';

        if($level!=0 && $hasChildren)
        {
            $html[]='<span class="minus click">&#8211;</span><span class="plus click">+</span>';
        }


        // render children
        $htmlChildren = '';
        $j = 0;

            foreach ($activeChildren as $child) {
                $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                    $child,
                    ($level + 1),
                    ($j == $activeChildrenCount - 1),
                    ($j == 0),
                    false,
                    $outermostItemClass,
                    $childrenWrapClass,
                    $noEventAttributes
                );
                $j++;

            }



        if (!empty($htmlChildren)) {





            if($level!=0)$html[] = '<ul class="nav nav-list">';
            $html[] = $htmlChildren;
            if($level!=0)$html[] = '</ul>';



        }

        $html[] = '</li>';

        if($level==0)
        {
            $html[]='</li></ul>';
        }

        $html = implode("\n", $html);
        return $html;
    }

    public function renderCategoriesMenuHtml($level = 0, $outermostItemClass = '', $childrenWrapClass = '')
    {
        $activeCategories = array();
        foreach ($this->getStoreCategories() as $child) {
            if ($child->getIsActive()) {
                $activeCategories[] = $child;
            }
        }
        $activeCategoriesCount = count($activeCategories);
        $hasActiveCategoriesCount = ($activeCategoriesCount > 0);

        if (!$hasActiveCategoriesCount) {
            return '';
        }

        $html = '';
        $j = 0;
        $count=0;
        $k=0;
        $cols = Mage::getStoreConfig('evoqueconfig/megamenu/bs_count_columns');
        if(empty($cols))$cols=6;
        if($cols>6)$cols=6;
        if($cols<1)$cols=1;

        foreach ($activeCategories as $category) {
            $count++;
            $k++;
            if($count==1 or $count==($cols+1))
            {
                $html.='<li><ul class="menu_row">';
            }
            $html .= $this->_renderCategoryMenuItemHtml(
                $category,
                $level,
                ($j == $activeCategoriesCount - 1),
                ($j == 0),
                true,
                $outermostItemClass,
                $childrenWrapClass,
                true
            );
            $j++;
            if($count==$cols or $k==$activeCategoriesCount)
            {
                $html.='</li></ul>';
                $count=0;
            }
        }

        return $html;
    }


}