jQuery.noConflict();
document.addEventListener("touchmove", Scroll, false);
document.addEventListener("scroll", Scroll, false);

function Scroll() {
    FixPosition(jQuery(window).scrollTop());
}

var getDevicePixelRatio = function() {
    if (window.devicePixelRatio === undefined) { return 1; }
    return window.devicePixelRatio;
}
function retinaProducts(){
    if (getDevicePixelRatio() > 1)
    {
        jQuery('.product-retina').each(function(){
            jQuery(this).attr('src',jQuery(this).attr('data-image2x'));
        });
    }
}
function isTouchDevice() {
    return (typeof (window.ontouchstart) != 'undefined') ? true : false;
}

function GalleryZoomScroll(windowWidth) {
    // delete elevateZoom
    jQuery.removeData(jQuery("#zoom-big-image img"), 'elevateZoom');
    if (jQuery("#zoom-big-image img").parent('.zoomWrapper').length > 0) {
        zoom_img = jQuery("#zoom-big-image img").clone();
        jQuery("#zoom-big-image > .zoomWrapper").replaceWith(zoom_img);
    }
    jQuery('.zoomContainer').each(function () {
        jQuery(this).remove();
    })

    jQuery("#zoom-gallery-outer").mCustomScrollbar("destroy");

    // initialize scrollbar for zoom gallery	
    if (windowWidth < 640) {

        jQuery("#zoom-gallery-outer").css("height", "inherit");
        jQuery("#zoom-big-image img").css('max-width', '100%');
        jQuery("#zoom-big-image").css("height", '');

        jQuery("#zoom-gallery-outer").mCustomScrollbar({
            mouseWheel: false,
            scrollButtons: {
                enable: false
            },
            scrollInertia: 50,
            horizontalScroll: true,
            advanced: {
                updateOnContentResize: true
            },
            theme: "dark"
        });
        stopScroll();
        jQuery("#zoom-gallery-outer a").click(function (e) {
            e.preventDefault();
            var imgURL = jQuery(this).attr("data-image");
            jQuery("#zoom-big-image img").stop(true, false)
                .fadeOut(100, function () {
                    jQuery("#zoom-big-image img").attr('src', imgURL);
                })
                .fadeIn(200);
        });
    } else {
        jQuery("#zoom-gallery-outer").mCustomScrollbar({
            scrollButtons: {
                enable: false
            },
            scrollInertia: 50,
            advanced: {
                updateOnContentResize: true
            },
            theme: "dark"
        });


        if (jQuery("#zoom-big-image").length != 0) {
            var zoomH = jQuery("#zoom-big-image img").height();
            var zoomW = jQuery("#zoom-big-image img").width();
            var zoomPos = 1;
            var zoomType = 'inner';
            /*if (windowWidth < 1199) {
                zoomType = 'inner'
            }*/
            jQuery("#zoom-big-image img").elevateZoom({
                responsive: true,
                easing: false,
                zoomType: zoomType,
                gallery: 'zoom-gallery-outer',
                cursor: "crosshair",
                borderSize: 2,
                showLens: true,
                zoomWindowPosition: zoomPos,
                zoomWindowHeight: zoomH,
                zoomWindowWidth: zoomW,
                borderColour: "#ccc",
                galleryActiveClass: 'active',
                imageCrossfade: true,
                onZoomedImageLoaded: function () {
                    if (jQuery(".zoomWrapper").length != 0) {
                        var zoombigW = jQuery("#zoom-big-image").width();
                        var zoombigH = jQuery("#zoom-big-image").height();
                        jQuery(".zoomWrapper img").css('max-width', zoombigW);
                        jQuery(".zoomWrapper").css('width', zoombigW);
                        jQuery(".zoomWrapper").css('height', jQuery(".zoomWrapper img").height());
                        jQuery('#zoom-gallery-outer').css('height', jQuery(".zoomWrapper img").height());
                        jQuery("#zoom-gallery-outer").mCustomScrollbar("update");
                        stopScroll();
                    }
                }
            });
        }


    }
}
// stop general scroll when hover on custom scroll
function stopScroll() {

    jQuery('.mCustomScrollBox:not(".mCSB_horizontal")  .mCSB_container.stopscroll').hover(function () {
        jQuery(document).unbind('mousewheel DOMMouseScroll MozMousePixelScroll');
    });
    jQuery('.mCustomScrollBox:not(".mCSB_horizontal")  .mCSB_container').each(function () {
        jQuery(this).removeClass('stopscroll');
    });

    jQuery('.mCustomScrollBox:not(".mCSB_horizontal")  .mCSB_container:not(".mCS_no_scrollbar")').each(function () {
        jQuery(this).addClass('stopscroll');
    });
    jQuery('.mCustomScrollBox:not(".mCSB_horizontal")  .mCSB_container.stopscroll').hover(function () {
        jQuery(document).bind('mousewheel DOMMouseScroll MozMousePixelScroll', function (e) {
            if (!e) { /* IE7, IE8, Chrome, Safari */
                e = window.event;
            }
            if (e.preventDefault) { /* Chrome, Safari, Firefox */
                e.preventDefault();
            }
            e.returnValue = false; /* IE7, IE8 */
        });
    }, function () {
        jQuery(document).unbind('mousewheel DOMMouseScroll MozMousePixelScroll');
    });
}

function FixPosition(windowScrollTop) {
    if (!isTouchDevice()) {
        var windowWidth = window.innerWidth || document.documentElement.clientWidth;
        if (windowWidth > 767) {

            if (jQuery("#IndexPage").length) {

                var scrollTop = windowScrollTop;
                var spyPosition = jQuery("#PageLogo").outerHeight() - scrollTop;
                if (spyPosition < 0) {
                    jQuery("#SpyPanel").addClass("fix");
                    if (isTouchDevice()) {
                        jQuery("#LogoSmall").fadeIn(0);
                    } else {
                        jQuery("#LogoSmall").fadeIn(500);
                    }

                    jQuery("#SideColumn").addClass("fix");
                    jQuery("#SideColumn").css('top', jQuery("#SpyPanel").outerHeight());
                    jQuery("#CenterColumn").css('margin-top', jQuery("#SpyPanel").outerHeight());
                    jQuery(".navigation_panel").css('height', jQuery(window).outerHeight() - jQuery("#SpyPanel").outerHeight());
                    jQuery(".navigation_panel.active").mCustomScrollbar("update");
                    stopScroll();
                } else {
                    jQuery("#SpyPanel").removeClass("fix");
                    if (isTouchDevice()) {
                        jQuery("#LogoSmall").fadeOut(0);
                    } else {
                        jQuery("#LogoSmall").fadeOut(500);
                    }
                    jQuery("#SideColumn").removeClass("fix");
                    jQuery("#SideColumn").css('top', 0);
                    jQuery("#CenterColumn").css('margin-top', 0);
                    jQuery(".navigation_panel").css('height', jQuery(window).outerHeight() - jQuery("#SpyPanel").outerHeight() - jQuery("#PageLogo").outerHeight());
                    jQuery(".navigation_panel.active").mCustomScrollbar("update");
                    stopScroll();
                }


            } else {
                jQuery("#SpyPanel").addClass("fix");
                jQuery("#LogoSmall").fadeIn(500);
                jQuery("#SideColumn").addClass("fix");
                jQuery("#SideColumn").css('top', jQuery("#SpyPanel").outerHeight());
                jQuery("#CenterColumn").css('margin-top', jQuery("#SpyPanel").outerHeight());
                jQuery(".navigation_panel").css('height', jQuery(window).outerHeight() - jQuery("#SpyPanel").outerHeight());
                jQuery(".navigation_panel.active").mCustomScrollbar("update");
                stopScroll();
            }

        } else {
            jQuery("#SpyPanel").removeClass("fix");
            jQuery("#SideColumn").removeClass("fix");
            jQuery("#SideColumn").css('top', 0);
            jQuery("#CenterColumn").css('margin-top', 0);
            jQuery(".navigation_panel").css('height', 'auto');
            jQuery(".navigation_panel.active").mCustomScrollbar("disable");
        }


        if (jQuery("#zoom-gallery-outer").length != 0) {
            jQuery(".zoomContainer").css('z-index', 1500);
        } else {
            jQuery(".zoomContainer").css('z-index', 2002);
        }
    }}

function SetInit() {
    var windowWidth = window.innerWidth || document.documentElement.clientWidth;
    var windowHeight = window.innerHeight || document.documentElement.clientHeight;

    // megmenu set height
    jQuery("#megamenu li ul.shadow").mCustomScrollbar("destroy");
    jQuery('#megamenu li ul.shadow').css('height', 'auto');
    if (windowHeight-jQuery('#PageLogo').outerHeight() - jQuery('#SpyPanel').outerHeight() < jQuery('#megamenu li ul.shadow').outerHeight()){
        jQuery('#megamenu li ul.shadow').css('height', windowHeight-jQuery('#PageLogo').outerHeight() - jQuery('#SpyPanel').outerHeight());
        jQuery("#megamenu li ul.shadow").mCustomScrollbar({
            scrollButtons: {
                enable: false
            },
            scrollInertia: 50,
            advanced: {
                updateOnContentResize: true
            },
            theme: "dark-thick"
        });
    }


    // calculate bootstraps grid width 
    var col_width = jQuery('#test_col').outerWidth();
    var row_width_b = jQuery('#test_row').outerWidth();
    var row_width = Math.round(row_width_b / col_width) * col_width;
    if (row_width > row_width_b) {
        row_width = row_width_b;
    }
    // megamenu left
    jQuery("#megamenu > li > ul").css('left', -jQuery('#SideColumn').outerWidth());

    // set product width
    jQuery(".products .product").css('width', col_width - 0.1);
    jQuery(".products_scroll .product").css('width', col_width);
    jQuery(".products_scroll .product:last-child").css('width', col_width - 30);

    // delete elevateZoom
    jQuery.removeData(jQuery(".zoom"), 'elevateZoom');
    jQuery('.zoomContainer').each(function () {
        jQuery(this).remove();
    })
    jQuery('.zoomWindowContainer').each(function () {
        jQuery(this).remove();
    })


    if (windowWidth > 640) {

        jQuery(".products .product.product-2x").css('width', 2 * col_width - 0.1);
        // set #SideColumn width
        jQuery("#SideColumn").css('width', jQuery("#SideColumn").parent().width() + 30);
        // set #SpyPanel width
        jQuery("#SpyPanel").css('width', jQuery("#SpyPanel").parent(".row").css('width'));
        // set slider width on index page
        jQuery('.flexslider').css('width', row_width + 'px');
        jQuery('body.touchdevice .flexslider-product').css('width', row_width + 'px');



        // set #LeftNavigation height
        jQuery("#LeftNavigation").css('height', jQuery(document).height());
        // gallery + zoom
        jQuery('.zoom').each(function () {
            var img = new Image();
            var demo_container_width, demo_container_height;
            var current_zoom = jQuery(this);
            img.src = jQuery(this).attr("data-zoom-image");
            img.onload = function () {
                demo_container_width = this.width;
                demo_container_height = this.height;
                if (demo_container_width > row_width) {
                    demo_container_width = row_width;
                }
                if (demo_container_height > jQuery(window).outerHeight() - jQuery("#SpyPanel").height()) {
                    demo_container_height = jQuery(window).outerHeight() - jQuery("#SpyPanel").height();
                }
                posY = (jQuery(window).outerHeight() - jQuery("#SpyPanel").height() - demo_container_height) / 2 + 5;
                posX = (jQuery('#test_row').outerWidth() - demo_container_width) / 2 - 15;
                current_zoom.elevateZoom({
                    cursor: "crosshair",
                    zoomWindowPosition: "demo-container",
                    zoomWindowWidth: demo_container_width,
                    zoomWindowHeight: demo_container_height,
                    zoomWindowOffetx: posX,
                    zoomWindowOffety: posY,
                    borderSize: 0,
                    easing: true,
                    easingAmount: 4,
                    zoomWindowFadeIn: 500,
                    zoomWindowFadeOut: 50
                });
            }
        });
    }

    if (windowWidth < 767) {
        jQuery("#SpyPanel").css('width', '100%');
        jQuery("#SideColumn").css('width', 'auto');
        jQuery(".navigation_panel").mCustomScrollbar("disable");
        jQuery(".navigation_panel").css('height', 'auto');
        jQuery(".navigation_panel").css('width', 'auto');
        jQuery('.catalog').removeClass('closed');
    } else {
        jQuery('#collapsed-menu').css('display', 'block');
    }
    if (isTouchDevice()) {
        jQuery('.flexslider-product').flexslider({
            selector: ".products > .product",
            animation: "slide",
            prevText: "<i class='typcn typcn-chevron-left'></i>",
            nextText: "<i class='typcn typcn-chevron-right'></i>",
            animationLoop: false,
            slideshow: false,
            itemWidth: col_width,
            itemMargin: 0,
            minItems: 1,
            maxItems: 5,
            controlNav: false,
            touch: false
        });
    }
    if (jQuery("#isotope").length != 0) {
        jQuery("#isotope").isotope({
            masonry: {},
            getSortData : {
                Name : function ( $elem ) {
                    return $elem.find('.info a ').text();
                },
                Price : function ( $elem ) {
                    return parseFloat( $elem.find('.sort_price').text());
                },
                Position : function ( $elem ) {
                    return parseFloat( $elem.find('.sort_position').text());
                }
            }
        });
    }
};
jQuery(document).ready(function () {
    retinaProducts();

    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 150) {
            jQuery('#back-top').fadeIn();
        } else {
            jQuery('#back-top').fadeOut();
        }
    });
    jQuery('#back-top a').click(function() {
        jQuery('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });

    if (jQuery('.fancybox-media').length){
        jQuery('.fancybox-media')
            .attr('rel', 'media-gallery')
            .fancybox({
                openEffect : 'none',
                closeEffect : 'none',
                prevEffect : 'none',
                nextEffect : 'none',

                arrows : false,
                helpers : {
                    media : {},
                    buttons : {}
                }
            });
    }
    jQuery('ul.menu_row li.col li.collapse span.click').click(function() {
        if (jQuery(this).parent('li.collapse').hasClass('closed')){
            jQuery(this).next('ul').show(200);
            jQuery(this).parent('li.collapse').removeClass('closed');
        }
        else {
            jQuery(this).parent().find('ul').hide(200);
            jQuery(this).parent().find('ul li').addClass('closed');
            jQuery(this).parent('li.collapse').addClass('closed');
        }return false;
    });


    jQuery('ul.menu_row li.col li a').hover(function(){
            jQuery(this).find('.popup-product').stop(true,false).fadeIn();
        },
        function(){
            jQuery(this).find('.popup-product').stop(true,false).fadeOut();
        });


    jQuery("#megamenu").on({
        "mouseenter": function(){
            jQuery('#SpyPanel').addClass("upper");
        },
        "mouseleave": function(){
            jQuery('#SpyPanel').removeClass("upper");
        }
    });



    jQuery('#sort-by').change(function(){

        jQuery('#isotope').isotope({ sortBy : jQuery(this).val() });
    });

    jQuery('.product').each(function () {
	but_n = jQuery(this).find('.buttons').children().size();
	           switch (true) {
                 case (but_n == 1):
			   jQuery(this).find('.buttons').addClass ('full');
                    break;
               case (but_n == 2):
				jQuery(this).find('.buttons').addClass ('one-half');
                    break;
                case (but_n == 3):
				jQuery(this).find('.buttons').addClass ('one-third');
                    break;
                case (but_n == 4):
				jQuery(this).find('.buttons').addClass ('one-fourth');
                    break;
                case (but_n == 5):
				jQuery(this).find('.buttons').addClass ('one-fifth');
                    break;
                case (but_n == 6):
				jQuery(this).find('.buttons').addClass ('one-sixth');
                    break;
                default:
                    break;
            }
	});
    // footer links slide
    jQuery('#BottomLinksButton').click(function (e) {
        e.preventDefault();
        if (jQuery(this).hasClass("closed")) {
            jQuery(this).removeClass("closed");
            jQuery('#BottomLinks').show().css("height", "");
            var bottomlinksHeight = jQuery('#BottomLinks').outerHeight();
            jQuery('#BottomLinks').css("height", "0").stop(true, true).animate( { height: bottomlinksHeight},  { step: function () { jQuery(window).scrollTop(jQuery("body").height()); } }
            );
        } else {
            jQuery(this).addClass("closed");
            jQuery('#BottomLinks').stop(true, true).slideUp();
        }
    });

    var windowWidth = window.innerWidth || document.documentElement.clientWidth;
    if (isTouchDevice()) {
        jQuery('body').addClass('touchdevice');
    };
    // copy content from left clumn to center column (for mobile devices)
    jQuery('.navigation_panel').each(function () {
        if (jQuery(this).hasClass('move-xs')) {
            jQuery(this).clone().appendTo('#MoveFromNav');
            jQuery(this).removeClass('move-xs').addClass('hidden-xs');
        }
        jQuery('#MoveFromNav').find('.navigation_panel').each(function () {
            jQuery(this).removeClass('navigation_panel');
            jQuery(this).css('height', 'auto')
        })
        // close all left panels
        jQuery(this).addClass('closed');
        // open active panel
        jQuery('.navigation_button').each(function () {
            if (jQuery(this).hasClass('active')) {
                jQuery('#' + jQuery(this).get(0).id.replace('button', 'panel')).removeClass('closed').addClass('active');
            }
        });
    });
    SetInit();
    FixPosition(jQuery(window).scrollTop());
    // compared product delete button
    /*jQuery('.custom_product .image .delete').click(function () {
        jQuery(this).parent().parent().addClass('hide');
    });*/
    // search
    jQuery("#SpyPanel .searchBoxInput").focus(function () {
        jQuery('.searchBoxContainer').addClass("focus");

    }).blur(function () {
        jQuery('.searchBoxContainer').removeClass("focus");
    })

    jQuery('#SpyPanel .searchButtonClose').click(function () {
         jQuery(this).parent().find('.searchBoxInput').val("Search");
    });
    // customize selects
    jQuery('.selectpicker').selectpicker({});
    // quantity input
    jQuery('.qty_minus').click(function () {
        var jQueryinput = jQuery(this).parent().find('input');
        var count = parseInt(jQueryinput.val()) - 1;
        count = count < 1 ? 1 : count;
        jQueryinput.val(count);
        jQueryinput.change();
        return false;
    });
    jQuery('.qty_plus').click(function () {
        var jQueryinput = jQuery(this).parent().find('input');
        jQueryinput.val(parseInt(jQueryinput.val()) + 1);
        jQueryinput.change();
        return false;
    });
    // button Catalog for mobile devices
    jQuery(".btn-catalog").click(function () {
        if (jQuery('#collapsed-menu').hasClass('hidden-xs')) {
            jQuery('#collapsed-menu').css('display', 'none');
            jQuery('#collapsed-menu').removeClass('hidden-xs');
            jQuery("#collapsed-menu").slideToggle('slow');
        } else {
            jQuery("#collapsed-menu").slideToggle('slow');
        }

    });


    // initialize products scroll
    if (!isTouchDevice()) {
        var products_scroll_theme = "product-scroll";
        jQuery(".products_scroll").mCustomScrollbar({
            mouseWheel: false,
            scrollButtons: {
                enable: false
            },
            horizontalScroll: true,
            scrollInertia: 50,
            autoDraggerLength: false,
            advanced: {
                autoExpandHorizontalScroll: true,
                updateOnContentResize: false
            },
            theme: products_scroll_theme
        });
    }
    GalleryZoomScroll(windowWidth);
    // initialize left column scroll
    if (windowWidth > 767) {
        jQuery(".navigation_panel").mCustomScrollbar({
            scrollButtons: {
                enable: false
            },
            scrollInertia: 50,
            advanced: {
                updateOnContentResize: true
            },
            theme: "dark-thick"
        });
        stopScroll();
    }

    // function for left panel
    jQuery('.navigation_button').click(function () {
        jQuery('.navigation_panel').each(function () {
            jQuery(this).addClass('closed');
        });
        jQuery('.navigation_button').each(function () {
            jQuery(this).removeClass('active');
            jQuery('#' + jQuery(this).get(0).id.replace('button', 'panel')).removeClass('active');
        });
        jQuery(this).addClass('active');
        jQuery('#' + jQuery(this).get(0).id.replace('button', 'panel')).removeClass('closed');
        jQuery('#' + jQuery(this).get(0).id.replace('button', 'panel')).addClass('active');
        jQuery(".navigation_panel.active").mCustomScrollbar("update");
        stopScroll();
        SetInit()
    });
    // active accordion button 
    jQuery(".panel-heading").each(function () {
        if (!jQuery(this).hasClass("active")) {
            jQuery(this).children().find("a").addClass("collapsed")
        }
    });
    jQuery(".panel-heading").click(function () {
        if (jQuery(this).children().find("a.collapsed").length != 0) {
            jQuery(".panel-heading").each(function () {
                jQuery(this).removeClass('active');
            });
            jQuery(this).addClass('active');
        } else {
            jQuery(this).removeClass('active');
        }
    });


    // begin collapsed menu
    jQuery('label.tree-toggler.closed').each(function () {
        if (jQuery(this).parent().find('ul.nav-list').length != 0) {
            jQuery(this).append("<span class='collapse_button'>+</span>");
        }
    });

    jQuery('label.tree-toggler.opened').each(function () {
        if (jQuery(this).parent().find('ul.nav-list').length != 0) {
            jQuery(this).parent().find('>ul.nav-list').show();
            jQuery(this).append("<span class='collapse_button'>-</span>");
        }
    });

    jQuery('label.tree-toggler span.collapse_button').click(function () {
        if (!jQuery(this).parent().parent().hasClass('active')) {
            jQuery(this).html('&#8211;');
            jQuery(this).addClass('collapsed');
            jQuery(this).parent().parent().children('ul.nav-list').show(300);
            jQuery(this).parent().parent().addClass('active');
            // update scroll
            jQuery(".navigation_panel").mCustomScrollbar("update");
            stopScroll();
        } else {
            jQuery(this).html('+');
            jQuery(this).removeClass('collapsed');
            jQuery(this).parent().parent().find('ul.nav-list').hide(300);
            jQuery(this).parent().parent().removeClass('active');
            jQuery(this).parent().parent().find('li').removeClass('active');
            jQuery(this).parent().parent().find('span.collapse_button').html('+');
            // update scroll
            jQuery(".navigation_panel").mCustomScrollbar("update");
            stopScroll();
        }
    });
    //  end collapsed menu

});



jQuery(window).resize(function () {
    var windowWidth = window.innerWidth || document.documentElement.clientWidth;
    SetInit();
    FixPosition(jQuery(window).scrollTop());
    GalleryZoomScroll(windowWidth);

    if (windowWidth > 767) {
        // update products scroll
        jQuery(".products_scroll").mCustomScrollbar("update");
    }
    if (!jQuery('#BottomLinksButton').hasClass("closed")){
        jQuery('#BottomLinks').css("height", "auto" )};



});
// jQuery - Wait until images  are loaded
jQuery(window).load(function () {

    if (jQuery("#isotope").length != 0) {
        jQuery("#isotope").isotope({
            masonry: {},
            getSortData : {
                Name : function ( $elem ) {
                    return $elem.find('.info a ').text();
                },
                Price : function ( $elem ) {
                    return parseFloat( $elem.find('.sort_price').text());
                },
                Position : function ( $elem ) {
                    return parseFloat( $elem.find('.sort_price').text());
                }
            }
        });
    }
})