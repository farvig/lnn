// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

(function( $ ){
// Toogle sub nav on nmobile
$(function() {
    $('.toggle-mobile-nav').on('click',function(e){
        e.preventDefault();
        $('.page-content').toggleClass('is-slided');
    });
});


( function( $ ) {
  $(document).ready(function(){
    $('.teacher-groups-nav a').on('click',function(){
      switch_tabs($(this));
      return false;
    });
    switch_tabs($('.teacher-groups-nav a:first-child'));      
  });// end document.ready
  
  function switch_tabs(obj){
    $('.teacher-group-item').hide();
    $('.teacher-groups-nav a').removeClass("selected-view");
    var id = obj.attr("rel");
   
    $('#'+id).show();
    obj.addClass("selected-view");
  }
} )(jQuery);


//Cookie script
$(function(){

    function getCookie(w){cName = "";pCOOKIES = new Array();pCOOKIES = document.cookie.split('; ');for(bb = 0; bb < pCOOKIES.length; bb++){NmeVal  = new Array();NmeVal  = pCOOKIES[bb].split('=');if(NmeVal[0] == w){cName = unescape(NmeVal[1]);}}return cName;}
    

    var cookieDomainName = window.location.host;
    var isSet = getCookie('ivpCookieScript');
        
    if(isSet == ""){$('.cookie-container').fadeIn('fast');}

    $('.accept-cookies').on('click', function(ca){ ca.preventDefault(); acceptCookie();});
    $('.decline-cookies').on('click', function(cd){ cd.preventDefault(); declineCookie();});

        
    $('.cookie-text-inner-container .cookie-close-btn').on('click',function(e){
        e.preventDefault();
        $('.cookie-text-container').fadeOut();
    });
        
    $('.toggle-cookie-text').on('click',function(e){
        e.preventDefault();
        $('.cookie-text-container').fadeIn();
    });


    function acceptCookie(){
      setCookie('ivpCookieScript','accepted', 90);
      $('.cookie-text-container').fadeOut();
    }

    function declineCookie(){
      setCookie('ivpCookieScript','declined', 1);
      $('.cookie-text-container').fadeOut();
    }

    
    function setCookie(name, value, expires){var today = new Date();var expr = new Date(today.getTime() + expires * 24 * 60 * 60 * 5000);document.cookie = ""+name+"="+value+"; path=/; expires="+expr.toGMTString();+";";}

    function clearCookie(d,b,c){try{if(function(h){var e=document.cookie.split(";"),a="",f="",g="";for(i=0;i<e.length;i++){a=e[i].split("=");f=a[0].replace(/^\s+|\s+$/g,"");if(f==h){if(a.length>1)g=unescape(a[1].replace(/^\s+|\s+$/g,""));return g}}return null}(d)){b=b||document.domain;c=c||"/";document.cookie=d+"=; expires="+new Date+"; domain="+b+"; path="+c}}catch(j){}};      
});
} )( jQuery );

/*global jQuery */
/*jshint browser:true */
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

(function( $ ){

  "use strict";

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null,
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement('div');
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        "iframe[src*='player.vimeo.com']",
        "iframe[src*='youtube.com']",
        "iframe[src*='youtube-nocookie.com']",
        "iframe[src*='kickstarter.com'][src*='video.html']",
        "object",
        "embed"
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not("object object"); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + Math.floor(Math.random()*999999);
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );


(function( $ ){
// Target your .container, .wrapper, .post, etc.
    $(".page-content p").fitVids();

} )( jQuery );

(function( $ ){
  $('.js-mobile-nav').on('click',function(e){
    e.preventDefault();
    $('.site-nav > ul').slideToggle();
  });
} )( jQuery );

// Live search lists
(function( $ ){
  $('.js-live-search').keyup(function() {
    var f = $(this).val();
    var regex = new RegExp(f, 'gi');

    $('.js-live-search-item').fadeOut()
        .each(function() {
          if($(this).html().match(regex)) {
            $(this).stop().show().css("display","");
        }
    });
  });
} )( jQuery );


// Check if passwords match
(function( $ ){
  $( ".password-input" ).keyup(function() {
    var pass1 = $('#pass1').attr('value');
    var pass2 = $('#pass2').attr('value');
    if( pass1 !== '' && pass2 !== '' && pass1 !== pass2){
      $( ".password-input" ).addClass('error');
    }else{
      $( ".password-input" ).removeClass('error');
    }
  });
} )( jQuery );

// autogenerate username
function randomString(len, charSet) {
    charSet = charSet || '0123456789';
    var randomString = '';
    for (var i = 0; i < len; i++) {
      var randomPoz = Math.floor(Math.random() * charSet.length);
      randomString += charSet.substring(randomPoz,randomPoz+1);
    }
    return randomString;
}

(function( $ ){
  var username = "";
  $( "#rcp_user_email" ).keyup(function() {
    var userid = randomString(9);
    $('#rcp_user_login').attr('value',userid);
  });
} )( jQuery );
