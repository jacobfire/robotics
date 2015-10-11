<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alesioo
 * Date: 12.12.12
 * Time: 16:24
 * To change this template use File | Settings | File Templates.
 */
function loo_min ($s)
{
    return $s->price;
}

class Etheme_Evoqueconfig_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function fileLoad($name, &$formData, $pathModule)
    {
        if (isset($_FILES[$name]['name']) && $_FILES[$name]['name'] != null)
        {
            $fileUploader = new Varien_File_Uploader($name);
            $fileUploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $fileUploader->setAllowRenameFiles(false);
            $fileUploader->setFilesDispersion(false);
            //$path = Mage::getBaseDir() . DS.$pathModule.DS ;
            $path = 'skin' . DS . 'adminhtml' . DS . 'base' . DS . 'default' . DS . 'evoque' . DS . 'images' . DS . 'Configsets' . DS;
            $fileUploader->save($path, $_FILES[$name]['name']);
            $formData[$name] = $pathModule . DS . $_FILES[$name]['name'];
        }
    }

    //loop through folders and sub folders with option to remove specific files.
    public function listFolderFiles($dir, $exclude)
    {
        $ffs = scandir($dir);
        echo '<ul class="ulli">';
        foreach ($ffs as $ff) {
            if (is_array($exclude) and !in_array($ff, $exclude)
            ) {
                if ($ff != '.' && $ff != '..') {
                    if (!is_dir($dir . '/' . $ff)) {
                        echo '<li><a href="edit_page.php?path=' . ltrim($dir . '/' . $ff, './') . '">' . $ff . '</a>';
                    } else {
                        echo '<li>' . $ff;
                    }
                    if (is_dir($dir . '/' . $ff)) $this->listFolderFiles($dir . '/' . $ff, $exclude);
                    echo '</li>';
                }
            }
        }
        echo '</ul>';
    }


    //Return an array of file names and folders in directory:
    function ReadFolderDirectory($dir = "root_dir/here")
    {
        $listDir = array();
        if ($handler = opendir($dir)) {
            while (($sub = readdir($handler)) !== FALSE) {
                if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
                    if (is_file($dir . "/" . $sub)) {
                        $listDir[] = $sub;
                    } elseif (is_dir($dir . "/" . $sub)) {
                        $listDir[$sub] = $this->ReadFolderDirectory($dir . "/" . $sub);
                    }
                }
            }
            closedir($handler);
        }
        return $listDir;
    }

    //view files by extension

    public function listFolderFiles_by_ext($dir, $type)
    {
        $dir = '.\\' . $dir . '\\'; // reminder: escape your slashes
        $filetype = "*." . $type;
        $filelist = shell_exec("dir {$dir}{$filetype} /a-d /b");
        $file_arr = explode("\n", $filelist);
        array_pop($file_arr); // last line is always blank
        return $file_arr;
    }


    public function cropResizeImg($fileName, $tmp, $width, $height = '')
    {
        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageURL = $folderURL . $fileName;

        $basePath = $tmp;
        $newPath = Mage::getBaseDir() . DS . 'skin' . DS . 'adminhtml' . DS . 'base' . DS . 'default' . DS . 'evoque' . DS . 'images' . DS . 'Configsets' . DS . $fileName;

        if (is_file($tmp)) {
            $imageObj = new Varien_Image($basePath);
            $imageObj->constrainOnly(TRUE);
            $imageObj->keepAspectRatio(FALSE);
            $imageObj->keepFrame(FALSE);

            $currentRatio = $imageObj->getOriginalWidth() / $imageObj->getOriginalHeight();
            $targetRatio = $width / $height;

            if ($targetRatio > $currentRatio) {
                $imageObj->resize($width, null);
            } else {
                $imageObj->resize(null, $height);
            }

            $diffWidth = $imageObj->getOriginalWidth() - $width;
            $diffHeight = $imageObj->getOriginalHeight() - $height;


            //$imageObj->resize($width, $height);
            $imageObj->crop(
                floor($diffHeight * 0.5),
                floor($diffWidth / 2),
                ceil($diffWidth / 2),
                ceil($diffHeight * 0.5)
            );

            $imageObj->save($newPath);
        }

        return $fileName;
    }





    public function addToCartLink($_product, $el, $in_list_mode = false)
    {
        if(Mage::getStoreConfig('evoqueconfig/options/show_add_to_cart'))
        {
            $IE8 = false;
            if (preg_match('/(?i)msie [1-8]/', $_SERVER['HTTP_USER_AGENT'])) $IE8 = true;
            if (Mage::getStoreConfig('evoqueconfig/options/catalog_mode')) return;
            $output = '';

            if (!$in_list_mode) $output .= '';
            if ($_product->isSaleable()) {
                if (Mage::getStoreConfig('evoqueconfig/options/ajax_add_to_cart') && !$IE8) {
                    if (!($_product->getTypeInstance(true)->hasRequiredOptions($_product) || $_product->isGrouped())) {
                        if (!$in_list_mode) $output .= '<a class="addtocart_btn"  onclick="setLocationAjax(\'' . $el->getAddToCartUrl($_product) . '\',\'' . $_product->getId() . '\')"><i class="typcn typcn-shopping-cart"></i><span>' . $el->__('Add to Cart') . '</span></a>';
                        else $output .= '<a class="btn btn-default btn-xl"  onclick="setLocationAjax(\'' . $el->getAddToCartUrl($_product) . '\',\'' . $_product->getId() . '\')"><i class="typcn typcn-shopping-cart"></i>' . $el->__('Add to Cart') . '</a>';

                    } else {
                        if (!$in_list_mode) $output .= '<a class="bt" href="' . $el->getAddToCartUrl($_product) . '"><i class="typcn typcn-shopping-cart"></i><span>' . $el->__('Add to Cart') . '</span></a>';
                        else $output .= '<a class="btn btn-default btn-xl" href="' . $el->getAddToCartUrl($_product) . '"><i class="typcn typcn-shopping-cart"></i><span>' . $el->__('Add to Cart') . '</span></a>';
                   }
                } else {
                    if (!$in_list_mode) $output .= '<a class="bt" href="' . $el->getAddToCartUrl($_product) . '"><i class="typcn typcn-shopping-cart"></i><span>' . $el->__('Add to Cart') . '</span></a>';
                    else $output .= '<a class="btn btn-default btn-xl"  href="' . $el->getAddToCartUrl($_product) . '"><i class="typcn typcn-shopping-cart"></i><span>' . $el->__('Add to Cart') . '</span></a>';
                }
            } else {
                 $output .= '<a class="outofstock">' . $el->__('Out of stock') . '</a>';
            }
            if (!$in_list_mode) $output .= '';
            return $output;
        } else return;
    }




    public function addWishCompLink($_product, $el)
    {
        $output = '';

        $IE8 = false;
        if (preg_match('/(?i)msie [1-8]/', $_SERVER['HTTP_USER_AGENT'])) $IE8 = true;

        if(Mage::getStoreConfig('evoqueconfig/options/catalog_mode'))return;

        //if (!$in_product) $output .= '<div class="clearfix"></div><div class="product-link">';


            if (Mage::getStoreConfig('evoqueconfig/options/ajax_wish_comp') && !$IE8) {
                if (Mage::helper('wishlist')->isAllow() && Mage::getStoreConfig('evoqueconfig/options/show_add_to_wishlist'))
                {
                    $output .= '<a class="bt" href="#"  onclick="ajaxWishlist(\'' . $el->helper('wishlist')->getAddUrlWithParams($_product,array('_secure'=>false)) . '\',' . $_product->getId() . ');return false;"><i class="typcn typcn-heart-outline"></i><span>'. $el->__('Add to Wishlist') .'</span></a>';
                }

                if(Mage::getStoreConfig('evoqueconfig/options/show_add_to_compare'))
                {
                    if ($_compareUrl = $el->getAddToCompareUrl($_product)) {

                            $output .= '<a class="bt" href="#" onclick="ajaxCompare(\'' . $_compareUrl . '\',' . $_product->getId() . ');return false;"><i class="typcn typcn-chart-bar-outline"></i><span>' . $el->__('Add to Compare') . '</span></a>';
                    }
                }

            }else{

                    if (Mage::helper('wishlist')->isAllow() && Mage::getStoreConfig('evoqueconfig/options/show_add_to_wishlist'))
                    {
                        $output .= '<a class="bt" href="'.Mage::helper('wishlist')->getAddUrlWithParams($_product,array('_secure'=>false)).'"><i class="typcn typcn-heart-outline"></i><span>'. $el->__('Add to Wishlist') .'</span></a>';
                    }
                    if(Mage::getStoreConfig('evoqueconfig/options/show_add_to_compare'))
                    {
                        $output .= '<a class="bt" href="'.Mage::helper('catalog/product_compare')->getAddUrl($_product) . '"><i class="typcn typcn-chart-bar-outline"></i><span>' . $el->__('Add to Compare') . '</span></a> ';
                    }

            }



        //if (!$in_product) $output .= '</div>';
        return $output;
    }



    public function getProductHtml($_product, $el, $widthBig, $heightBig, $price, $tag='li', $class='',$in_slider=false,$count=0, $category_double_product_id=0)
    {
        $second_image='';
        $first_image='';
        if($category_double_product_id)
        {
            $category_double_product_ids=explode(',',$category_double_product_id);

            if( in_array($_product->getId(),$category_double_product_ids))
            {
                $class='product-2x';
                $widthBig=568;
            }
        }


        if(Mage::getStoreConfig('evoqueconfig/options/catalog_mode'))
        {
            $price='';

        }
        if(Mage::getStoreConfig('evoqueconfig/options/image_rollover_mode'))
        {
            $_product->load('media_gallery');
            if ($temp = $_product->getMediaGalleryImages())
            {
                if ($_image = $temp->getItemByColumnValue('position', Mage::getStoreConfig('evoqueconfig/options/image_rollover_sort')))
                {
                    if($category_double_product_id)
                    {
                        if(in_array($_product->getId(),$category_double_product_ids) && Mage::getStoreConfig('evoquelayout/options/product_listing')=='izotope')
                        {
                            $second_image='<img class="second" src="' . $el->helper('catalog/image')->init($_product, 'small_image',$_image->getFile())->constrainOnly(true)->keepAspectRatio(true)->keepFrame(false)->resize(568)  . '"   alt="' . $el->stripTags($_product->getName(), null, true) . '"/>';
                        }
                        else
                        {
                            $second_image='<img class="second" src="' . $el->helper('catalog/image')->init($_product, 'small_image',$_image->getFile())->resize($widthBig, $heightBig) . '"   alt="' . $el->stripTags($_product->getName(), null, true) . '"/>';
                        }

                    }
                    else
                    {
                        $second_image='<img class="second" src="' . $el->helper('catalog/image')->init($_product, 'small_image',$_image->getFile())->resize($widthBig, $heightBig) . '"   alt="' . $el->stripTags($_product->getName(), null, true) . '"/>';
                    }
                    $first_image='first';
                }
            }
        }


        $output = '<'.$tag.' class="product '.$class.'">
            <div class="inside">';

        $output.=$this->getProductLabel($_product,$el);

        $output.= ' <div class="image_wrapper">
                    <div class="image">
                        <a href="'.$_product->getProductUrl().'">';


        $keep_frame=true;
        if(Mage::getStoreConfig('evoquelayout/options/product_listing')=='izotope' && !$in_slider)$keep_frame=false;
        $image=$el->helper('catalog/image')->init($_product, 'small_image')
            ->constrainOnly(true)
            ->keepAspectRatio(true)
            ->keepFrame($keep_frame);

        if(Mage::getStoreConfig('evoquelayout/options/product_listing')=='izotope' && !$in_slider)
        {

            $image=$image->resize($widthBig);
        }else{
            $image=$image->resize($widthBig, $heightBig);
        }


        $output.= '<img  src="' .$image . '" class="product-retina '.$first_image.'"   data-image2x="' . $el->helper('catalog/image')->init($_product, 'small_image')->resize($widthBig * 2, $heightBig * 2) . '"  alt="' . $el->stripTags($_product->getName(), null, true) . '">';
        $output.=$second_image;




        $output.= '     </a>
                    </div>';



        if( (Mage::getStoreConfig('evoqueconfig/options/show_add_to_compare') ||
            Mage::getStoreConfig('evoqueconfig/options/show_add_to_wishlist') ||
            Mage::getStoreConfig('evoqueconfig/options/show_add_to_cart') ||
            Mage::getStoreConfig('evoqueconfig/options/quick_view')) && !Mage::getStoreConfig('evoqueconfig/options/catalog_mode'))
        {
            $output.= '<div class="buttons">
                        '.$this->addToCartLink($_product, $el).'
                        '.$this->addWishCompLink($_product, $el).'
                        '.$this->QuickView($_product, $el).'
                    </div>';

            $output.=$this->QuickView_part2($_product, $el);
        }

        $output.='</div>
                 <div class="text_wrapper">
                   <div class="sort_price">'.$_product->getFinalPrice().'</div>';

        if($count)$output.='<div class="sort_position">'.$count.'</div>';
        $output.=   $price.'
                    <div class="info font2"><a href="'.$_product->getProductUrl().'" title="'.$el->stripTags($_product->getName(), null, true).'">'.$el->stripTags($_product->getName(), null, true).'</a></div>
                </div>
            </div>
        </'.$tag.'>';


        return $output;
    }

    function nicetime($date)
    {
        if (empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();
        $unix_date = strtotime($date);

        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";

        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

    function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    function getProductLabel($_product,$el)
    {


        $output = '';
        if (Mage::getStoreConfig('evoqueconfig/product_labels/show_sale_label')) {

            $now = date("Y-m-d");
            $specialFrom = substr($_product->getData('special_from_date'), 0, 10);
            $specialTo = substr($_product->getData('special_to_date'), 0, 10);

            $special = false;

            if (!empty($specialFrom) && !empty($specialTo)) {
                if ($now >= $specialFrom && $now <= $specialTo) $special = true;

            } elseif (!empty($specialFrom) && empty($specialTo)) {
                if ($now >= $specialFrom) $special = true;

            } elseif (empty($specialFrom) && !empty($specialTo)) {
                if ($now <= $specialTo) $special = true;
            }
            if ($special) $output .= '
                <div class="label_sale">
                    <div class="pull-left">'.$el->__('Sale').'</div>
                    '.$this->outputDiscountLabel($_product).'
                </div>';

        }

        if (Mage::getStoreConfig('evoqueconfig/product_labels/show_new_label')) {
            $now = date("Y-m-d");
            $newsFrom = substr($_product->getData('news_from_date'), 0, 10);
            $newsTo = substr($_product->getData('news_to_date'), 0, 10);

            $new = false;

            if (!empty($newsFrom) && !empty($newsTo)) {
                if ($now >= $newsFrom && $now <= $newsTo) $new = true;

            } elseif (!empty($newsFrom) && empty($newsTo)) {
                if ($now >= $newsFrom) $new = true;

            } elseif (empty($newsFrom) && !empty($newsTo)) {
                if ($now <= $newsTo) $new = true;
            }

            if ($new) $output .= '<div class="label_new"> '.$el->__('New').' </div>';

        }
        return $output;
    }



    public function outputDiscountLabel($_product)
    {

        if(Mage::getStoreConfig('evoqueconfig/options/catalog_mode'))return;
        if (!($_product->type_id == 'grouped' || $_product->type_id == 'bundle')) {

            if(!Mage::getStoreConfig('evoqueconfig/product_labels/discount_label'))return;
            if ($_product->type_id != 'grouped')
                $price_new = $_product->getFinalPrice();
            else
                $price_new = $_product->min_price;

            $price_old = $_product->getPrice();

            if($price_old==0)$price_old=1;
            $discount=round((($price_new-$price_old)*100)/$price_old);


            return '<div class="pull-left percent">'.$discount.'%</div>';
        } else return '';


    }

    public function QuickView($_product,$el)
    {

        $text=$el->__('Quick View');
        if(!Mage::getStoreConfig('evoqueconfig/options/quick_view'))return;
        return '
            <a  class="bt hidden-phone hidden-small-desktop hidden-tablet" onclick="showOptions(\'' . $_product->getId() . '\')"><i class="typcn typcn-zoom"></i><span>'.$text.'</span></a>

        ';
    }
    public function QuickView_part2($_product,$el)
    {

        if(!Mage::getStoreConfig('evoqueconfig/options/quick_view'))return;
        return '
            <a href=\'' . $el->getUrl('ajax/index/options', array('product_id' => $_product->getId())) . '\'   class="hidden fancybox popup_fancybox' . $_product->getId() . '"></a>
        ';
    }


    function replace_uri($str) {
        $pattern = '#(^|[^\"=]{1})(http://|ftp://|mailto:|news:)([^\s<>]+)([\s\n<>]|$)#sm';
        return preg_replace($pattern,"\\1<a target=\"_blank\" href=\"\\2\\3\">\\2\\3</a>\\4",$str);
    }


    function refreshCssFiles($store, $website)
    {
        /*3 ways to refresh CSS
         * DEFAULT-WEBSITES-STORES  (All available stores)
         * WEBSITES-STORES (stores from choosen website)
         * STORE (choosen store)
         * */
        if(!$website)
        {
            //refresh all Websites css
            foreach(Mage::app()->getWebsites() as $website)
            {
                $this->refreshWebsiteStores($website);
            }
        }
        else
        {
            if($store)
            {
                //refresh Store css
                $this->refreshStoreCss($store);
            }
            else
            {
                //refresh Website css
                $this->refreshWebsiteStores($website);
            }
        }
    }

    function refreshStoreCss($store)
    {
        Mage::register('store_for_css', $store);
        $path = Mage::getBaseDir() . '/' . 'skin/frontend/evoque/default/css/colors/';

        $prefix = 'colors_';
        if ($store) {
            $filename = $store;
        }

        $path_full = $path . $prefix . $filename . '.css';


        /*
         * how get frontend phtml output http://stackoverflow.com/questions/12290938/get-frontend-phtml-templates-output-inside-a-model-method-in-magento
         * */
        $css_output = Mage::app()->getLayout()->createBlock('core/template')->setData('area', 'frontend')->setTemplate('etheme/evoque/cssrefresh/colors.phtml')->toHtml();

        /*
         * write to file described here  http://inchoo.net/ecommerce/magento/magento-code-library/
         * */
        try {
            if(file_exists($path_full))unlink($path_full);
            $flocal = new Varien_Io_File();
            $flocal->open(array('path' => $path));
            $flocal->streamOpen($path_full, 'w+');
            $flocal->streamWrite($css_output);
            $flocal->streamClose();
            Mage::getSingleton('adminhtml/session')->addSuccess('CSS file '.$prefix.$store.'.css was refreshed successfully.');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        Mage::unregister('store_for_css');
    }

    function refreshWebsiteStores($website)
    {
        foreach(Mage::app()->getWebsite($website)->getStoreCodes() as $store)$this->refreshStoreCss($store);
    }

    public function getIsHomePage()
    {
        $page = Mage::app()->getFrontController()->getRequest()->getRouteName();
        $homePage = false;

        if($page =='cms'){
            $cmsSingletonIdentifier = Mage::getSingleton('cms/page')->getIdentifier();
            $homeIdentifier = Mage::app()->getStore()->getConfig('web/default/cms_home_page');
            if($cmsSingletonIdentifier === $homeIdentifier){
                $homePage = true;
            }
        }

        return $homePage;
    }
}