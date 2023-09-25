jQuery(document).ready(function() {

    jQuery(".read-more-li").click(function(e) {
        e.preventDefault();
        jQuery(this).parent().parent().toggleClass('clicked');
        jQuery(this).parent().parent().children(".view-more").slideToggle();
    });

    jQuery('.slide-benefit > .section_wrapper').slick({
        dots: true,
        prevArrow: jQuery('.arrows-bar .prev'),
        nextArrow: jQuery('.arrows-bar .next'),
        fade: true,
        cssEase: 'linear',
        adaptiveHeight: true,
        speed: 210,
        autoplay: true,
        autoplaySpeed: 3900,
        infinite: true,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              dots: false,
              arrows: true,
              prevArrow: '<div class="btn-left"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
              nextArrow: '<div class="btn-right"><i class="fa fa-angle-right" aria-hidden="true"></i></div>'
            }
          }
        ]

    });

/* 
    appendDots: $('element-to-append-dots-nav'), */


    jQuery('.slide-benefit .slick-track > .wrap').removeClass('mcb-wrap');

    jQuery('.video-overl .content_video').append('<div class="play-vid"></div>');

    jQuery('body').on('click', '.play-vid', function(e) {
        e.preventDefault();
        jQuery(this).parent().parent().addClass('clicked');
        var videoURL = jQuery('.video-overl .content_video iframe').prop('src');
        videoURL += "&autoplay=1";
        jQuery('.video-overl .content_video iframe').prop('src', videoURL);
    });
    jQuery('.slide-benefit .slick-dots').wrap('<div class="container"></div>');

    // Faq Questions
    jQuery(".faq-questions .mcb-wrap-inner .column h5").click(function(e) {
        var showElementDescription =
            jQuery(this).parents(".faq-questions .mcb-wrap-inner .column").find(".content-text");

        if (jQuery(showElementDescription).is(":visible")) {
            showElementDescription.hide("fast", "swing");
            jQuery(this).removeClass('active');
        } else {
            showElementDescription.show("fast", "swing");
            jQuery(this).addClass('active');
        }
    });

    if (jQuery('.form-schedule')[0]) {
        jQuery('#Subheader').addClass('small-heading');
    }
    jQuery('.form-schedule input, .form-schedule textarea').blur(function(e) {
        if (!this.value) {
            jQuery(this).parent().prev('label').addClass('down');
        }
    });
    jQuery('.form-schedule label').addClass('down');
    jQuery('.form-schedule input, .form-schedule textarea').focus(function(e) {
        if (!this.value) {
            jQuery(this).parent().prev('label').removeClass('down');
        }
    });
    // Contact form
    jQuery(".section-contact .row-form input, .section-contact .row-form textarea").focus(function(e) {
        e.preventDefault();
        jQuery(this).parent().parent().addClass('active-input');
        jQuery(".section-contact form").removeClass('active-input');
    });

    jQuery(".section-contact .row-form input, .section-contact .row-form textarea").focusout(function(e) {
        e.preventDefault();
        if (jQuery(this).val().length <= 0) {
            jQuery(this).parent().parent().removeClass('active-input');
        }
        jQuery(".section-contact form").removeClass('active-input');
    });


    /*  Secondary menu actions */
    jQuery('.second-bar-menu').parent().parent().attr('href', 'JavaScript:Void(0);');
    jQuery(jQuery('.second-bar-menu').parent().parent()).click(function(e) {
        jQuery('.menu-second').fadeIn();
    });
    jQuery('.responsive-menu-toggle').focus(function(e) {
        jQuery('.menu-second').fadeIn();
    });

    jQuery(".close-x").click(function(e) {
        jQuery('.menu-second').fadeOut();
    });

    /* Event on widows resize */
    jQuery(window).resize(function() {
        var width_x = jQuery(window).width();
        var element_parent = jQuery('.second-bar-menu').parent().parent().parent();
        var menu_in_secondary = '.menu-second .menu-secondary-menu-container #menu-main-menu';
        var menu_in_primary = '#Top_bar .menu_wrapper #menu-main-menu';
        if (width_x > 1239 && !jQuery(menu_in_primary)[0]) {
          //  jQuery(element_parent).show();
          //  jQuery(menu_in_secondary).prependTo('#Top_bar .menu_wrapper');
        }
        if (width_x < 1239 && !jQuery(menu_in_secondary)[0]) {
          //  jQuery(element_parent).hide();
         //   jQuery(menu_in_primary).prependTo('.menu-second .menu-secondary-menu-container');
        }
    });

    // Cta tbs anchor click
    jQuery('.header-go-cta ul li a').focus(function(event) {
        jQuery(".header-go-cta ul li a").removeClass('active');
        jQuery(this).addClass('active');
        var width_page = jQuery(window).width();
        jQuery(".header-go-cta ul li").removeClass('active-show');
        jQuery(this).parent("li").addClass('active-show');
        jQuery(".header-go-cta ul li").toggleClass("show-li");
        
        event.preventDefault();
        jQuery('html, body').stop().animate({
            scrollTop: jQuery(jQuery(this).attr('href')).offset().top - 140
        }, 900);
        return false;
    });
    
    jQuery(".up_down").on('click', 'i', function(event) {
        jQuery(".header-go-cta ul li").toggleClass("show-li");
        jQuery(".up_down i").toggleClass('active-i');
    })
    

    jQuery(document).on('click', '.header-go-cta a[href^="#"]', function(event) {
        event.preventDefault();
        jQuery('html, body').stop().animate({
            scrollTop: jQuery(jQuery(this).attr('href')).offset().top - 140
        }, 900);
        return false;
    });

    // Condition if prefoter has not class pre-footer
    if (!jQuery('.two-fifth.valign-top.bg-cover').parent().parent().hasClass('pre-footer')) {
        jQuery(jQuery('.two-fifth.valign-top.bg-cover').parent().parent()).addClass('pre-footer');
    }

    // Contact take
    jQuery("#wpcf7-f360-p135-o1 .row-form input, #wpcf7-f360-p135-o1 .row-form textarea").focus(function(e) {
        e.preventDefault();
        jQuery(this).parent().parent().addClass('active-input');
        jQuery("form.wpcf7-form").removeClass('active-input');

    });

    jQuery("#wpcf7-f360-p135-o1 .row-form input, #wpcf7-f360-p135-o1.row-form textarea").focusout(function(e) {
        e.preventDefault();
        if (jQuery(this).val().length <= 0) {
            jQuery(this).parent().parent().removeClass('active-input');
        }
        jQuery("form.wpcf7-form").removeClass('active-input');
    });

    // Show More options
    var contHide = 0;
    jQuery(".view-more-info").click(function(e) {
        e.preventDefault();
        if(contHide == 0){
            jQuery(".view-more-1").css('display','none');
            jQuery(".view-less-1").css('display','inline-block');
            jQuery('.table-base .box-hide').slideToggle();
            contHide = 1;
        }else{
            jQuery(".view-more-1").css('display','inline-block');
            jQuery(".view-less-1").css('display','none');
            jQuery('.table-base .box-hide').slideToggle();
            contHide = 0;
        }
       
    });

});