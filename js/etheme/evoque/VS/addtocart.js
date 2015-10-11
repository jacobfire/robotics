/*jQuery.noConflict();*/
jQuery(document).ready(function(){


    jQuery('.fancybox').on('click',function() {
        if (jQuery(window).width()<769)  {
            window.location = jQuery('a:first',jQuery(this).parent()).attr('href');
            return false;
        }
        $fancylink = jQuery(this);
        jQuery.fancybox({
                hideOnContentClick : true,
                width: 876,
                height:450,
                margin:0,
                padding:0,
                autoDimensions: true,
                type : 'iframe',
                showTitle: false,
                scrolling: 'no',
                href: $fancylink.attr('href'),

                onComplete: function(){
                    jQuery('#fancybox-frame').load(function () {
                        jQuery('#fancybox-content').height(jQuery(this).contents().height());
                        jQuery.fancybox.resize();

                    });
                }
            }
        );
        return false;
    });

    jQuery('.show-options').on('click', function(){
        jQuery('.popup_fancybox'+id).trigger('click');
        return false;
    });
});
function showOptions(id){
    jQuery('.popup_fancybox'+id).trigger('click');
}
function setAjaxData(data,iframe){
    if(data.status == 'ERROR'){
        jQuery('#preloader .inside').html(data.message);
        jQuery('#preloader .message').fadeIn(300);

        setTimeout(function(){
            jQuery('#preloader .message').fadeOut();
        },3000)
    }else{
        if(jQuery('#shopping_cart')){
            jQuery('#shopping_cart').replaceWith(data.sidebar);
        }

        if(jQuery('.header_toplinks')){
            jQuery('.header_toplinks').replaceWith(data.toplink);
        }
        jQuery.fancybox.close();

        jQuery('.btn.btn-default.dropdown-toggle > .typcn.typcn-shopping-cart').addClass('expandOpen');

        jQuery('#preloader .inside').html(data.message);
        jQuery('#preloader .message').fadeIn(300);

        setTimeout(function(){
            jQuery('#preloader .message').fadeOut();
        },2300)
    }
}
function setLocationAjax(url,id){
    url += 'isAjax/1';
    url = url.replace("checkout/cart","ajax/index");


    jQuery('#preloader .loader').fadeIn(300);

    try {
        jQuery.ajax( {
            url : url,
            dataType : 'json',
            success : function(data) {
                jQuery('#preloader .loader').hide();
                setAjaxData(data,false);

            }
        });
    } catch (e) {

    }


}