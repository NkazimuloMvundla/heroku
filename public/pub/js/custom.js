define([
  "jquery",
],
function($) {
  "use strict";
  jQuery(document).ready(function(){
  	if($('body').hasClass('catalog-category-view') == true|| $('body').hasClass('blog-index-index') == true){
  		var cat_name = $('body .page-title-wrapper>h1>span').text();
  		$(".level-top>span:contains('"+cat_name+"')").filter(function() {
            if(($(this).text() === cat_name)=== true){$(this).addClass('active-page');}
        });
  	}
  	else if($('body').hasClass('cms-home') == true){
  		$(".level-top>span:contains('Home')").addClass('active-page');
  	}
  	$(document).ready(function() {
        $("#spinner").fadeOut("slow");
    });
  	function searchtoggle(){if($(window).width()<980){
  		$(".block-search-inner .block-title").click(function(){
  		$(".block-search .block-content").toggle(0);
  		$(".block-search-inner .block-title").toggleClass('activated');
  		});
  	}}
  	$(".header-center .action.nav-toggle").prependTo(".tm_header.container-width");
  	$( document ).ready(function() {accountdash();searchtoggle();});
    $( window ).resize(function() {accountdash();});

  	function accountdash(){
        if((($(window).width()>767 === true) && (($(window).width()<980) === true))){
        $(".account .block-collapsible-nav .title").click(function(){
            $(".block-collapsible-nav .content").toggle();
        });}
        else{
            $(".account .block-collapsible-nav .title").removeClass("active");
            $(".account .block-collapsible-nav .block-collapsible-nav-content").removeClass("active");
            $(".account .block-collapsible-nav .block-collapsible-nav-content").removeAttr("style");
        }
    }

    jQuery('.account #maincontent .page-title-wrapper').insertAfter('.breadcumb_inner');


    $('.custommenu .menu-title').click(function() {
        $('.custommenu #mainmenu').slideToggle('slow');
        $('.custommenu .menu-title').toggleClass('active');
    });

    $(".cms-home .page.messages").prependTo(".mainSlider .container-width");

  });

    require(['jquery', 'owlcarousel','fancybox','parallax', 'jstree', 'flexslider',], function($) {
    jQuery(document).ready(function() {

     	jQuery(".lightbox").fancybox({
            'frameWidth' : 890,
        	'frameHeight' : 630,
            openEffect  : 'fade',
            closeEffect : 'fade',
            helpers: {
            	title: null
    		}
        });
        jQuery(".headerlinks_inner").click(function(){
            jQuery(".header_customlink ul").slideToggle('slow');
            jQuery(".navigation.custommenu").parent().find('#mainmenu').removeAttr('style');
            jQuery(".tm_headerlinks").removeAttr('style');
            jQuery(".tm_headerlinks_inner").removeClass('active');
        });


        $("body").append("<a class='top_button' title='Back To Top' href=''></a>");
        $(window).scroll(function () {
            if ($(this).scrollTop() > 70) {
                $('.top_button').fadeIn();
            } else {
                $('.top_button').fadeOut();
            }
        });

        // scroll body to 0px on click
        $('.top_button,top_button_bottom').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        jQuery('#testimonial-carousel').owlCarousel({
            items: 6,
            nav: true,
            autoplay:false,
            loop: true,
            responsive: {
            0: {
                items: 1
            },
                    480: {
                items: 1
            },
                    768: {
                items: 1
            },
                    1024: {
                items: 1
            },
                     1600 : {
                items: 1
            }
            }
        });

        jQuery('#cat-featured').owlCarousel({
            items: 5,
            nav: true,
            autoplay:false,
            loop: false,
            responsive: {
            0: {
                items: 1
            },
                    480: {
                items: 2
            },
                    641: {
                items: 3
            },
                    768: {
                items: 3
            },
                    1024: {
                items: 4
            },
                     1600 : {
                items: 5
            }
            }
        });

         var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
        if(!isMobile) {
            if(jQuery(".parallex").length){  jQuery(".parallex").sitManParallex({  invert: false });};
        }else{
            jQuery(".parallex").sitManParallex({  invert: true });
        }

        jQuery("#brand-carousel").owlCarousel({
            nav: true,
            loop: true,
            autoplay:false,
            items: 7,
            autoplaySpeed:1000,
            autoplayTimeout:1000,
            responsive: {
            0: {
            items: 1
            },
                480: {
            items: 3
            },
                768: {
            items: 4
            },
                1024: {
            items: 6
            }
            },
            navText: [
              "<i class='icon-chevron-left icon-white'><</i>",
              "<i class='icon-chevron-right icon-white'>></i>"
             ]
        });

        jQuery("#blog-carousel").owlCarousel({
            nav: true,
            loop: false,
            items: 10,
            responsive: {
            0: {
            items: 1
            },
                480: {
            items: 1
            },
                641: {
            items: 1
            },
                768: {
            items: 1
            },
                1024: {
            items: 1
            },
                1201: {
            items: 1
            }
            },
            navText: [
              "<i class='icon-chevron-left icon-white'><</i>",
              "<i class='icon-chevron-right icon-white'>></i>"
             ]
        });
        jQuery('.products-carousel .owl-carousel').owlCarousel({
            items: 4,
        	nav: true,
            responsive: {
                0: {
                    items: 2
                },
                        480: {
                    items: 3
                },
                        768: {
                    items: 3
                },
                        1024: {
                    items: 4
                },
                        1201: {
                    items: 5
                }
                },
            navText: [
              "<i class='icon-chevron-left icon-white'><</i>",
              "<i class='icon-chevron-right icon-white'>></i>"
             ]
        });
        jQuery('.flexslider').flexslider({
            animation: "fade",
            controlNav: false,
            pauseOnHover:true
        });


        jQuery("#category-treeview").treeview({
            animated: "slow",
            collapsed: true,
            unique: true
        });

        function productListAutoSet(){
            jQuery('.widget-product-carousel').owlCarousel({
                items: 5,
                nav: true,
                responsive: {
                0: {
                    items: 2
                },
                        480: {
                    items: 2
                },
                        641: {
                    items: 3
                },
                        768: {
                    items: 4
                },
                        1024: {
                    items: 4
                },
                        1201: {
                    items: 5
                }
                },
                navText: [
                "<i class='icon-chevron-left icon-white'><</i>",
                "<i class='icon-chevron-right icon-white'>></i>"
                ]
            });
        }
        jQuery(document).ready(function(){productListAutoSet();});
        jQuery(window).resize(function() {productListAutoSet();});


        jQuery(".tab_product:not(:first)").hide();
        jQuery(".tab_product:first").show();

        //when we click one of the tabs
        jQuery(".tabbernav_product  li  a").click(function(){

            //get the ID of the element we need to show
            var stringref = jQuery(this).attr("href").split('#')[1];
            //hide the tabs that doesn't match the ID
            jQuery('.tab_product:not(#'+stringref+')').hide();
             //fix
            if (jQuery.browser.msie && jQuery.browser.version.substr(0,3) == "6.0") {
             	jQuery('.tab_product#' + stringref).show();
            }
            else{
                //display our tab fading it in
                jQuery('.tab_product#' + stringref).fadeIn();
            }
            jQuery(".tabbernav_product a").removeClass("selected");
            jQuery(this).addClass("selected");

            var $owl = jQuery('#'+stringref+' .widget-product-carousel');
            $owl.trigger('destroy.owl.carousel');
            $owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');
            productListAutoSet();
            return false;
        });

    }); // Require Ends here

    function mobileHeaderLink(){
        jQuery(".tm_headerlinkmenu" ).addClass('toggle');
        jQuery(".tm_headerlinkmenu .headertoggle_img").click(function(){
            jQuery(this).parent().toggleClass('active').parent().find('.tm_headerlinks').slideToggle(0);
            jQuery(".header_customlink").parent().find('ul').removeAttr('style');
            jQuery(".navigation.custommenu").parent().find('#mainmenu').removeAttr('style');
        });
    }
    jQuery(document).ready(function(){mobileHeaderLink();});


    function footerToggleMenu(){
        if (jQuery(window).width() < 980)
        {
            jQuery(".page-footer .footer-area .mobile_togglemenu").remove();
            jQuery(".page-footer .footer-area h6").append( "<a class='mobile_togglemenu'>&nbsp;</a>" );
            jQuery(".page-footer .footer-area h6").addClass('toggle');
            jQuery(".page-footer .footer-area .mobile_togglemenu").click(function(){
                jQuery(this).parent().toggleClass('active').parent().find('ul').toggle('slow');
                jQuery(this).closest(".footer-staticlink1").find('.social-icons>ul').toggle('slow')
            });
        }else{
            jQuery(".page-footer .footer-area h6").parent().find('ul').removeAttr('style');
            jQuery(".page-footer .footer-area  h6").removeClass('active');
            jQuery(".page-footer .footer-area  h6").removeClass('toggle');
            jQuery(".page-footer .mobile_togglemenu").remove();
        }
    }
    jQuery(document).ready(function(){footerToggleMenu();});
    jQuery(window).resize(function(){footerToggleMenu();});

    function sidebarToggle(){
        if (jQuery(window).width() < 980){
            jQuery(".sidebar .block .mobile_togglemenu").remove();
            jQuery(".sidebar .block .block-title").append( "<a class='mobile_togglemenu'>&nbsp;</a>" );
            jQuery(".sidebar .block .block-title").addClass('toggle');
            jQuery(".sidebar .block .mobile_togglemenu").click(function(){
                jQuery(this).parent().toggleClass('active').parent().find('.block-content').slideToggle('slow');
            });
        }else{
            jQuery(".sidebar .block .block-title").parent().find('.block-content').removeAttr('style');
            jQuery(".sidebar .block .block-title").removeClass('active');
            jQuery(".sidebar .block .block-title").removeClass('toggle');
            jQuery(".sidebar .block .mobile_togglemenu").remove();
        }
    }
    jQuery(window).resize(function(){sidebarToggle();});
    jQuery(document).ready(function(){sidebarToggle();});


    /* Home Page Menu */
     	jQuery(function($){
      	if ($(window).width()>1550){
     		var max_elem = 9;
     	}else if($(window).width()>1201){
     	var max_elem = 8;
     	}else if($(window).width()>1023){
      	var max_elem = 8;
      	}else if($(window).width()>979){
      	var max_elem = 7;
      	}else if($(window).width()>767){
      	var max_elem = 6;
      	}
        console.log(max_elem);
     	var items = $('.Slider-menu-CMS ul.slider-menu > li');
     	var surplus = items.slice(max_elem, items.length);
     	surplus.wrapAll('<li class="level-top hidden_menu menu"><div class="category-wrapper"><ul>');
     	$('.hidden_menu').prepend('<div class="parentMenu"><a href="" class="level-top"><span>view more</span></a></div>');
     });

    function top_banner(){
     	if(jQuery('body').hasClass('cms-home')){
            jQuery('.header-top-banner').show();
        }
        jQuery(".close-btn").on("click", function() {
            jQuery(this).fadeOut(100);
            jQuery('.header-top-banner').slideUp(1000);
        });
    }
    jQuery(document).ready(function(){top_banner();});


    $(window).scroll(function(){
        var scroll = $(window).scrollTop();
        //console.log(scroll);
        if (jQuery(window).width() > 979){
            if(scroll>=200){
            	$(".page-header").addClass("fixed");
            	$(".header.content").addClass("fixed-header-style");
            }
            else{
            	$(".page-header").removeClass("fixed");
            	$(".header.content").removeClass("fixed-header-style");
            }
            //console.log(scroll);
            // Do something
        }
        else{
            jQuery(".page-header").removeClass('fixed');
            jQuery(".header.content").removeClass("fixed-header-style");
        }
    });

});
  return; //return is optional I kept it to prevent unnecessery error occurance in future.
});//Define Ends here and So does Custom.js.