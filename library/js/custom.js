// as the page loads, call these scripts
const bootstrap = require('bootstrap');

jQuery(document).ready(function($) {

  var templateUrl = url.templateUrl;
  // var offsetHeight = 114;
  // if ($('#wpadminbar')) {
  //   offsetHeight = offsetHeight + 32; 
  // }

  $('.video-img a,a.play-button').attr('data-lity', '');


  // if (window.matchMedia("(min-width: 1024px)").matches) {
  //   $('#navigation a').removeClass('dropdown-toggle').removeAttr('data-toggle');
  // }

  if (window.matchMedia("(max-width: 767px)").matches || $('.side-navbar')) {
    $('.dropdown-toggle').dropdown();
  } else {
    $('#navigation a').removeClass('dropdown-toggle').removeAttr('data-toggle');
  }
  // $('.sidebar-nav .dropdown-toggle').dropdown();

  $('.addHover').hover(function(){
   $(this).addClass('hover');
  },function(){
    $(this).removeClass('hover');
  });


  var bodyWidth = $(".js-force-full-width").parent().width();
  //get the window's width
  var windowWidth =$(window).width();

  //set the full width div's width to the body's width, which is always full screen width
  $(".js-force-full-width").css({"width": $("body").width() + "px"});
  //set all full width div's children's width to 100%
  $(".js-force-full-width.stretch-container").children().css({"width":"100%"});

  //setting margin for aligning full width div to the left
  //only needed when content area width is smaller than screen width
  if(windowWidth>bodyWidth){
    var marginLeft = -(windowWidth - bodyWidth)/2;

    $(".js-force-full-width").css({"margin-left": marginLeft+"px"});
  }

  // handling changing screen size
  $(window).resize( function(){
      $(".js-force-full-width").css({"width": $("body").width() + "px"});
      if(windowWidth>bodyWidth){
          $(".js-force-full-width").css({"margin-left": (-($(window).width() - $(".js-force-full-width").parent().width())/2)+"px"});
      } else{
          $(".js-force-full-width").css({"margin-left": "0px"});
      }
  });

  var container = $('.faqs');

  $('.filter a').on('click', function(e){
    $(container).fadeOut(350);
    $('.filter a').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
    var selected_taxonomy = $(this).data('filter');
    if(selected_taxonomy == 'all') {
      selected_taxonomy = '';
    }  
    $.ajax({
      url : fs_vars.fs_ajax_url,
      type : 'post',
      data : {
        action: 'filter_posts', // function to execute
        fs_nonce: fs_vars.fs_nonce, // wp_nonce
        taxonomy: selected_taxonomy, // selected tag
      },
      success : function( response ) {
        if( response ) {
            // Display posts on page
            $(container).html( response );
            // Restore div visibility
            $(container).parent().css('height', 'auto');
            $(container).fadeIn(350);
        };
      }
    });   

  }); 
  // Expanding Bootstrap Menu
  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });
    
    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  }); 

  // default boostrap structure
  $('label input[type="checkbox"]').click(function () {
    $(this).parent().toggleClass('checked');
  });

  // Expanding Search bar
  var searchIcon = $('.searchbox-icon');
  var toggleIcon = $('.searchbox-icon,.fa-remove');

  var inputBox = $('.searchbox-input');
  var removeIcon = $('.fa-remove');
  var searchBox = $('.searchbox');
  var isOpen = false;
  toggleIcon.click(function(){
     event.preventDefault();
    
      if(isOpen == false){
        searchBox.addClass('searchbox-open');
        inputBox.focus();
        isOpen = true;
        // searchIcon.toggle();
      } else { 
        searchBox.removeClass('searchbox-open');
        inputBox.focusout();
        isOpen = false;
        // searchIcon.toggle();      
      }
  }); 
  
  // Animated Scroll to event Add id to target
  var urlHash = window.location.href.split("#")[1];
  // console.log('urlHash ' + urlHash);
  var regex = /(gallery\[rel)/g;

  if (typeof urlHash != 'undefined' && urlHash != '' && !urlHash.match(regex)) {
    if ($('.' + urlHash + ', #' + urlHash +',[name='+urlHash+']').length) {
      var target = $('.' + urlHash + ', #' + urlHash +',[name='+urlHash+']');
    }

    if (typeof target != 'undefined' && $(target)) {
      $('html,body').animate({
          scrollTop: target.first().offset().top -100
      }, 1000);
    }


  }


  var navOffset = 60;
  $(".widget_nav_menu li.scroll a").on('click', function(event) {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      // var target = document.getElementById(this.hash);
      // check if the target exists first
      if (typeof target != 'undefined' && target != '') {
        if (target.length) {
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        }
        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top - navOffset
          }, 1000);
          return false;
          // return window.history.pushState(null, null, target);  
        }
      }
    }

  });

}); //End Jquery

// function buttonUp(){
//     var inputVal = $('.searchbox-input').val();
//     inputVal = $.trim(inputVal).length;
//     if( inputVal !== 0){
//         $('.searchbox-icon').css('display','none');
//     } else {
//         $('.searchbox-input').val('');
//         searchIcon.toggle();
//     }
// }


