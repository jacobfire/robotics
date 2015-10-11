function ajaxCompare(url,id){
	url = url.replace("catalog/product_compare/add","ajax/whishlist/compare");
	url += 'isAjax/1/';

    jQuery('#preloader .loader').fadeIn(300);

	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			//jQuery('#ajax_loading'+id).hide();
			if(data.status == 'ERROR'){
                jQuery('#preloader .loader').hide();
                jQuery('#preloader .inside').html(data.message);
                jQuery('#preloader .message').fadeIn(300);

                setTimeout(function(){
                    jQuery('#preloader .message').fadeOut();
                },2300);
			}else{

                jQuery('#preloader .loader').hide();
                jQuery('#preloader .inside').html(data.message);
                jQuery('#preloader .message').fadeIn(300);

                setTimeout(function(){
                    jQuery('#preloader .message').fadeOut();
                },2300);


				if(jQuery('.block-compare').length){
                    jQuery('.block-compare').replaceWith(data.sidebar);
                }

                if(jQuery('.header_toplinks')){
                    jQuery('.header_toplinks').replaceWith(data.toplink);
                }
			}
		}
	});
}

function ajaxWishlist(url,id){
	url = url.replace("wishlist/index","ajax/whishlist");
	url += 'isAjax/1/';
    jQuery('#preloader .loader').fadeIn(300);
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			//jQuery('#ajax_loading'+id).hide();
			if(data.status == 'ERROR'){
                jQuery('#preloader .loader').hide();
                jQuery('#preloader .inside').html(data.message);
                jQuery('#preloader .message').fadeIn(300);

                setTimeout(function(){
                    jQuery('#preloader .message').fadeOut();
                },2300);
			}else{
                jQuery('#preloader .loader').hide();
                jQuery('#preloader .inside').html(data.message);
                jQuery('#preloader .message').fadeIn(300);

                setTimeout(function(){
                    jQuery('#preloader .message').fadeOut();
                },2300);

                if(jQuery('.header_toplinks')){
                    jQuery('.header_toplinks').replaceWith(data.toplink);
                }

                if(jQuery('.block-wishlist').length){
                    jQuery('.block-wishlist').replaceWith(data.sidebar);
                }
			}
		}
	});
}