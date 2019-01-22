jQuery(document).ready(function($) {

/*------------------------------------------------
                PRELOADER
------------------------------------------------*/

 $('#loader').fadeOut();
 $('#loader-container').fadeOut();

/*------------------------------------------------
                STICKY HEADER AND MENU TOGGLE
------------------------------------------------*/
$(window).scroll(function() {
    if ($(this).scrollTop() > 1){  
        $('.sticky').addClass("nav-shrink");
    }
    else{
        $('.sticky').removeClass("nav-shrink");
    }
        
    $('.search-results article:not( .hentry )').addClass( 'hentry' );
});
    

$('.menu-toggle').click(function() {
    $('.nav-menu').slideToggle();
});

// Add dropdown toggle that displays child menu items.
var dropdownToggle = $( '<button />', { 'class': 'dropdown-toggle', 'aria-expanded': false });

$('.main-navigation').find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

$('.main-navigation button.dropdown-toggle').click(function() {
   $(this).toggleClass('active');
   $(this).parent().find('.sub-menu').first().toggle();
});

if( $(window).width() < 992) {
   $('.main-navigation #search').insertAfter('.main-navigation ul.menu li a#search-btn');
}
else {
   $('.main-navigation #search').insertAfter('.main-navigation ul.menu');
}
$(window).resize(function() {
   if( $(window).width() < 992) {
       $('.main-navigation #search').insertAfter('.main-navigation ul.menu li a#search-btn');
   }
   else {
       $('.main-navigation #search').insertAfter('.main-navigation ul.menu');
   }
});
/*------------------------------------------------
                SEARCH
------------------------------------------------*/

$('.main-navigation #search-btn').click(function() {   
    $('.main-navigation li').fadeOut();
    $('.main-navigation #search').fadeIn();
    $('#search input.search-field').focus();

});

$('.main-navigation .close-search').click(function() {   
    $('.main-navigation li').fadeIn();
    $('#search').fadeOut();
});

$('.cart-images li a').click(function(){
    $('.cart-images li').removeClass('active');
    $(this).parent().addClass('active');
})

$(document).keyup(function(e) {
    if (e.keyCode === 27) {
        $('.main-navigation .search').removeClass('search-open');
        $('.main-navigation #search').hide();
        $('.main-navigation li').fadeIn();
    }
});

$(document).click(function (e) {
    var container = $("#masthead");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $('.main-navigation .search').removeClass('search-open');
        $('.main-navigation #search').hide();
        $('.main-navigation li').fadeIn();
    }
});
/*------------------------------------------------
                BACK TO TOP
------------------------------------------------*/

 $(window).scroll(function(){
    if ($(this).scrollTop() > 1) {
    $('.backtotop').fadeIn();
    } else {
    $('.backtotop').fadeOut();
    }
    });
    $('.backtotop').click(function(){
    $('html, body').animate({scrollTop: '0px'}, 800);
    return false;
});

$(".woocommerce-products-header").remove();

/*------------------------------------------------
                END BACK TO TOP
------------------------------------------------*/

/*------------------------------------------------
                SLICK SLIDER
------------------------------------------------*/

var $ease = $('#main-slider').data('effect');

$("#main-slider").slick({
    cssEase: $ease
});

$(".regular").slick();

$(".shop-slider").slick();

$(".recipe-slider").slick();

$("#ingredients .entry-content").slick({
    responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

$(".gallery-slider").slick();

$("#slideshow .team-slider").slick();

$("#slideshow .slick-prev").insertBefore('#slideshow .slick-dots');
$("#slideshow .slick-next").insertAfter('#slideshow .slick-dots');

$("#slideshow .slick-dots").insertBefore('#slideshow .team-slider');

$('#our-team .featured-image').click(function() {
   $('#our-team .column-wrapper').hide();
   $('#slideshow').show();
   $("#slideshow .team-slider").slick('setPosition');

   var section = $('#our-team');

   $('html,body').animate({
       scrollTop: $(section).offset().top - 100},
   '800');
});

$('.icon-scroll').on('click', function() {
    $('html,body').animate({
        scrollTop: $('#primary, #shop-products, #contact-form, #recipe, #about-us, #portfolio-gallery, #reservation, #todays-menu').offset().top},
    '800');
});

$('.close-slideshow').click(function() {
    $('#slideshow').hide();
    $('#our-team .column-wrapper').show();
});

$(document).keyup(function(e) {
    if (e.keyCode === 27) {
      $('#slideshow').hide();
      $('#our-team .column-wrapper').show();
    }
});

var teamslide1 = $('#our-team .featured-image:nth-child(1)');
var teamslide2 = $('#our-team .featured-image:nth-child(2)');
var teamslide3 = $('#our-team .featured-image:nth-child(3)');
var teamslide4 = $('#our-team .featured-image:nth-child(4)');
var teamslide5 = $('#our-team .featured-image:nth-child(5)');

teamslide1.click(function() {
    $("#slideshow .team-slider .slider-item").removeClass('slick-active');
    $("#slideshow .team-slider .slider-item").removeClass('slick-current');
    $("#slideshow .team-slider .slider-item").css({'opacity':'0'});

    $("#slideshow .team-slider .slider-item:nth-child(1)").addClass('slick-active');
    $("#slideshow .team-slider .slider-item:nth-child(1)").addClass('slick-current');
    $("#slideshow .team-slider .slider-item.slick-current").css({'opacity':'1'});

});

teamslide2.click(function() {
    $("#slideshow .team-slider .slider-item").removeClass('slick-active');
    $("#slideshow .team-slider .slider-item").removeClass('slick-current');
    $("#slideshow .team-slider .slider-item").css({'opacity':'0'});

    $("#slideshow .team-slider .slider-item:nth-child(2)").addClass('slick-active');
    $("#slideshow .team-slider .slider-item:nth-child(2)").addClass('slick-current');
    $("#slideshow .team-slider .slider-item.slick-current").css({'opacity':'1'});

});

teamslide3.click(function() {
    $("#slideshow .team-slider .slider-item").removeClass('slick-active');
    $("#slideshow .team-slider .slider-item").removeClass('slick-current');
    $("#slideshow .team-slider .slider-item").css({'opacity':'0'});

    $("#slideshow .team-slider .slider-item:nth-child(3)").addClass('slick-active');
    $("#slideshow .team-slider .slider-item:nth-child(3)").addClass('slick-current');
    $("#slideshow .team-slider .slider-item.slick-current").css({'opacity':'1'});
});

teamslide4.click(function() {
    $("#slideshow .team-slider .slider-item").removeClass('slick-active');
    $("#slideshow .team-slider .slider-item").removeClass('slick-current');
    $("#slideshow .team-slider .slider-item").css({'opacity':'0'});

    $("#slideshow .team-slider .slider-item:nth-child(4)").addClass('slick-active');
    $("#slideshow .team-slider .slider-item:nth-child(4)").addClass('slick-current');
    $("#slideshow .team-slider .slider-item.slick-current").css({'opacity':'1'});
});

teamslide5.click(function() {
    $("#slideshow .team-slider .slider-item").removeClass('slick-active');
    $("#slideshow .team-slider .slider-item").removeClass('slick-current');
    $("#slideshow .team-slider .slider-item").css({'opacity':'0'});

    $("#slideshow .team-slider .slider-item:nth-child(5)").addClass('slick-active');
    $("#slideshow .team-slider .slider-item:nth-child(5)").addClass('slick-current');
    $("#slideshow .team-slider .slider-item.slick-current").css({'opacity':'1'});
});

/*------------------------------------------------
                SLIDER AND HEADER IMAGE DISABLED
------------------------------------------------*/
if( $('body.home.page section').hasClass('main-featured-slider') ) {
    $('body.home.page').addClass('slider-enabled');
}

else {
    $('body.home.page').addClass('slider-disabled');
}

/*------------------------------------------------
                    PARALLAX   
------------------------------------------------*/
$.stellar({
    horizontalScrolling: false,
    verticalOffset: 0
});
/*------------------------------------------------
                MAGNIFIC POPUP
------------------------------------------------*/

$('.gallery-popup').magnificPopup( {
    delegate:'.popup', type:'image', tLoading:'Loading image #%curr%...', 
    gallery: {
        enabled: true, navigateByImgClick: true, preload: [0, 1]
    }
    , image: {
        tError:'<a href="%url%">The image #%curr%</a> could not be loaded.', titleSrc:function(item) {
            return item.el.attr('title');
        }
    }
});

/*------------------------------------------------
              TABS
------------------------------------------------*/

$(".nav-tabs li a").click(function(event) {
    event.preventDefault();
    $(this).parent().addClass("active");
    $(this).parent().siblings().removeClass("active");
    var tab = $(this).attr("href");
    $(".tab-pane").not(tab).css("display", "none");
    $(tab).fadeIn();
});

/*--------------------------------------------------------
                SHOP CATEGORY
----------------------------------------------------------*/

$('.cart-images ul li.shop-sale-cat a').click( function(e) {
    e.preventDefault();
    var currentCategory = '.' + $(this).data('slug');
    $('#shop-sale-slide .shop-slider').slick('slickUnfilter');
    $('#shop-sale-slide .shop-slider').slick('slickFilter', currentCategory);
});


});

/*------------------------------------------------
            END JQUERY
------------------------------------------------*/
