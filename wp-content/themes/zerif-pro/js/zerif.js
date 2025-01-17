	jQuery.urlParam = function (_1, _2) {
		var _3 = new RegExp("[\\?&]" + _1 + "=([^&#]*)").exec(_2);
		if (!_3) {
			return 0;
		}
		return _3[1] || 0;
	};


jQuery(document).ready(function(){
	
/*	jQuery('.hideonclick').bind('click', function(){ 
		jQuery(this).hide();
	});*/
		jQuery('.hideonclick').click(function(){ 
		jQuery(this).hide();
	});
	
	jQuery( '#desctop-primary-menu-button' ).click( function() {	
		var target = jQuery(this).data('target');
		jQuery(target).toggleClass('open');
		jQuery(this).hide('fast');
		return false;
	});
	
	jQuery( '#closemenu' ).click( function() {	
		var target = jQuery(this).data('target');
		jQuery(target).toggleClass('open');
		jQuery('#desctop-primary-menu-button').show('fast');
		return false;
	});
	
/*	jQuery('#menu-main a').bind('click', function(){
		jQuery('#desctop-primary-menu').removeClass('open');
		jQuery('#desctop-primary-menu-button').show('fast');
		return false;
	});*/
	
/*	jQuery( '.toggle' ).click( function() {	
		var target = jQuery(this).data('target');
		jQuery(target).toggleClass('open');
		return false;
	})*/
/*------------Colorbox---------------*/
	if (typeof (jQuery.colorbox) === "function" && screen.width > 480) {
		
 		jQuery(".overlay a, a.overlay").colorbox({
				 iframe: true,
				 
/*				  iframe: function () {
					  var iframe = jQuery.urlParam("iframe", jQuery(this).attr("href"))
					  return iframe ? true : false;
				  },*/
				 href:function () {
					  var href = jQuery(this).attr("href")+'?ajax=1';
					 if (href.indexOf('?') > 0){
						href = href + '&ajax=1';
					 }else{
					    href = href + '?ajax=1';
						 
					 }
					 //console.log(href);
					  return href;
				  },
				  title:' ',
				  resize:false,
				  notshowbtns: true, 
				  scrolling: false,
				  opacity:0.7,
				  speed:200,
				  innerHeight: function () {
					  var height =  jQuery.urlParam("height", jQuery(this).attr("href"));
					  var winheight = jQuery(window).height();
					  if (winheight < 1000)
						  winheight = '340px';
					  else
						  winheight = '45%';
				  	  return height ? height : winheight;
				  },
				  innerWidth: function () {
  					  var width =  jQuery.urlParam("width", jQuery(this).attr("href"));
					  var winwidth = jQuery(window).width();
					  if (winwidth > 1024)
						  winwidth ='900px';
					  else
						  winwidth = '80%';
					  return width ? width : winwidth;
				  },
				  onOpen: function(){
					  activeScroll = true;
				  },
				  onClosed: function(){
					  activeScroll = false;
				  }
			  });			
	}

});

/* LOADER */
jQuery(document).ready(function(){
	
	var zerif_frame = jQuery('iframe.zerif_google_map');
	var zerif_frameSrc = new Array();

    if( zerif_frame.length ){
		jQuery.each( zerif_frame, function(i, f){
			zerif_frameSrc[i] = jQuery(f).attr('src');
            /*remove the src attribute so window will ignore these iframes*/
            jQuery(f).attr('src', '');
        }); 
	}
	
	function zerif_display_iframe_map() {
		if( zerif_frame.length ){
			jQuery.each( zerif_frame, function(a, x){
				/*put the src attribute value back*/
				jQuery(x).attr('src', zerif_frameSrc[a]);
			});
		}	
	}
	
	jQuery(".status").fadeOut();
	jQuery(".preloader").delay(1000).fadeOut("slow");
	setTimeout(zerif_display_iframe_map, 500);


  jQuery( '.zerif-with-modal' ).click( function() {
    jQuery( 'html' ).css( 'overflow', 'hidden' );
    jQuery( this ).parent().find( '.zerif-modal-wrap' ).css( 'display', 'block' );
  } );
  jQuery( '.zerif-close-modal, .zerif-close-modal-button' ).click( function() {
    jQuery( 'html' ).css( 'overflow-y', 'scroll' );
    jQuery( '.zerif-modal-wrap' ).css( 'display', 'none' );
  } );


});

/** BACKGROUND SLIDER ***/
jQuery(document).ready(function(){
	if ( jQuery('.fadein-slider .slide-item').length > 1 ) {
		jQuery('.fadein-slider .slide-item:gt(0)').hide();
		setInterval(function(){
			jQuery('.fadein-slider :first-child').fadeOut(2000).next('.slide-item').fadeIn(2000).end().appendTo('.fadein-slider');
		}, 10000);
	}
});


/* RESPONSIVE BACKGROUND ON MOBILE */
var portraitViewInit = 0, // Initial viewport orientation: Default Landscape
    resize = false;
jQuery( document ).ready( zerif_bg_responsive );
jQuery( window ).resize( zerif_bg_responsive );
function zerif_bg_responsive() {
  if( jQuery( '#mobile-bg-responsive' ).length > 0 && jQuery( 'body.custom-background' ).length > 0 && isMobile.any() ) {
    // There is background image
    var windowWidth   = window.innerWidth;
    var windowHeight  = window.innerHeight;
    // Check if orientation is Portrait or Landscape: Default is Landscape
    portraitView = 0;
    if( windowHeight >= windowWidth ) {
      portraitView = 1;
    }
    if( isMobile.iOS() ) {
      windowHeight+=100;
    }
    if( portraitViewInit != portraitView ) {
      var bgHelper = jQuery( '.zerif-mobile-bg-helper-bg' );
      if( !resize ) {
        var imgURL = jQuery( 'body.custom-background' ).css( 'background-image' );
        jQuery( '.zerif-mobile-bg-helper-bg-inside' ).css( { 
          'background-image': imgURL,
        } ).addClass( 'zerif-mobile-h-inside' );
        jQuery( '.zerif-mobile-bg-helper-wrap-all' ).addClass( 'zerif-mobile-h-all' );
        jQuery( '.zerif-mobile-bg-helper-content' ).addClass( 'zerif-mobile-h-content' );
        bgHelper.css( {
          'width':      windowWidth,
          'height':     windowHeight
        } ).addClass( 'zerif-mobile-h-bg' );
        portraitViewInit = portraitView;
        resize = true;
      } else {
        // Resize window
        bgHelper.css( {
          'width':      windowWidth,
          'height':     windowHeight
        } );
        portraitViewInit = portraitView;
      }
    }
  }
}


/*** DROPDOWN FOR MOBILE MENU */
var zerif_callback_mobile_dropdown = function () {

  if( jQuery( '.wr-megamenu-container' ).length <= 0 ) {
    var navLi = jQuery('#site-navigation li');
    navLi.each(function(){
        if ( jQuery(this).find('ul').length > 0 && !jQuery(this).hasClass('has_children') ){
            jQuery(this).addClass('has_children');
            jQuery(this).find('a').first().after('<p class="dropdownmenu"></p>');
        }
    });
    jQuery('.dropdownmenu').click(function(){
        if( jQuery(this).parent('li').hasClass('this-open') ){
            jQuery(this).parent('li').removeClass('this-open');
        }else{
            jQuery(this).parent('li').addClass('this-open');
        }
    });

    navLi.find('a').click(function(){
    	jQuery('.navbar-toggle').addClass('collapsed');
       	jQuery('.collapse').removeClass('in'); 
    });
  }

};
jQuery(document).ready(zerif_callback_mobile_dropdown);


/* show/hide reCaptcha */
/*jQuery(document).ready(function() {

  var thisOpen = false;
  jQuery('.contact-form .form-control').each(function(){
    if ( (typeof jQuery(this).val() != 'undefined') && (jQuery(this).val().length > 0) ){
      thisOpen = true;
      jQuery('.zerif-g-recaptcha').css('display','block').delay(1000).css('opacity','1');
      return false;
    }
  });
  if ( thisOpen == false && (typeof jQuery('.contact-form textarea').val() != 'undefined') && (jQuery('.contact-form textarea').val().length > 0) ) {
    thisOpen = true;
    jQuery('.zerif-g-recaptcha').css('display','block').delay(1000).css('opacity','1');
  }
  jQuery('.contact-form input, .contact-form textarea').focus(function(){
    if ( !jQuery('.zerif-g-recaptcha').hasClass('recaptcha-display') ) {
        jQuery('.zerif-g-recaptcha').css('display','block').delay(1000).css('opacity','1');
    }
  });

});*/

/* Bootstrap Fix */
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
	
	var msViewportStyle = document.createElement('style')

	msViewportStyle.appendChild(

		document.createTextNode(

			'@-ms-viewport{width:auto!important}'

		)

	)

	document.querySelector('head').appendChild(msViewportStyle);

}

jQuery(document).ready(function() {
	
	/* PARALLAX */
	var jQuerywindow = jQuery(window);

	jQuery('div[data-type="background"], header[data-type="background"], section[data-type="background"]').each(function(){

		var jQuerybgobj = jQuery(this);

		jQuery(window).scroll(function() {

			var yPos = -(jQuerywindow.scrollTop() / jQuerybgobj.data('speed'));

			var coords = '50% '+ yPos + 'px';

			jQuerybgobj.css({ 

				backgroundPosition: coords 

			});

		});

	});
	
});


/*=================================
===  SMOOTH SCROLL             ====
=================================== */

jQuery(document).ready(function(){
  jQuery('#site-navigation a[href*="#"]:not([href="#"]), header.header a[href*="#"]:not([href="#"])').bind('click',function () {
    var headerHeight;
    var hash    = this.hash;
    var idName  = hash.substring(1);    // get id name
    var alink   = this;                 // this button pressed
    // check if there is a section that had same id as the button pressed
    if ( jQuery('section [id*=' + idName + ']').length > 0 && jQuery(window).width() >= 751 ){
      jQuery('.current').removeClass('current');
      jQuery(alink).parent('li').addClass('current');
    }else{
      jQuery('.current').removeClass('current');
    }
    if ( jQuery(window).width() >= 751 ) {
      headerHeight = jQuery('#main-nav').height();
    } else {
      headerHeight = 0;
    }
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = jQuery(this.hash);
      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        jQuery('html,body').animate({
          scrollTop: target.offset().top - headerHeight + 5
        }, 1200);
        return false;
      }
    }
  });
});

jQuery(document).ready(function(){
    var headerHeight;
    jQuery('.current').removeClass('current');
    jQuery('#site-navigation a[href$="' + window.location.hash + '"]').parent('li').addClass('current');
    if ( jQuery(window).width() >= 751 ) {
      headerHeight = jQuery('#main-nav').height();
    } else {
      headerHeight = 0;
    }
    if (location.pathname.replace(/^\//,'') == window.location.pathname.replace(/^\//,'') && location.hostname == window.location.hostname) {
      var target = jQuery(window.location.hash);
      if (target.length) {
        jQuery('html,body').animate({
          scrollTop: target.offset().top - headerHeight + 5
        }, 1200);
        return false;
      }
    }
});

/* TOP NAVIGATION MENU SELECTED ITEMS */
//function zerif_scrolled() {
//    
//      if ( jQuery(window).width() >= 751 ) {
//          var zerif_scrollTop = jQuery(window).scrollTop();       // cursor position
//          var headerHeight = jQuery('#main-nav').outerHeight();   // header height
//          var isInOneSection = 'no';                              // used for checking if the cursor is in one section or not
//          // for all sections check if the cursor is inside a section
//          jQuery("section, header").each( function() {
//            var thisID = '#' + jQuery(this).attr('id');           // section id
//            var zerif_offset = jQuery(this).offset().top;         // distance between top and our section
//            var thisHeight  = jQuery(this).outerHeight();         // section height
//            var thisBegin   = zerif_offset - headerHeight;                      // where the section begins
//            var thisEnd     = zerif_offset + thisHeight - headerHeight;         // where the section ends  
//            // if position of the cursor is inside of the this section
//            if ( zerif_scrollTop >= thisBegin && zerif_scrollTop <= thisEnd ) {
//              isInOneSection = 'yes';
//              jQuery('.current').removeClass('current');
//              jQuery('#site-navigation a[href$="' + thisID + '"]').parent('li').addClass('current');    // find the menu button with the same ID section
//              return false;
//            }
//            if (isInOneSection == 'no') {
//              jQuery('.current').removeClass('current');
//            }
//          });
//      }
//}
//jQuery(window).on('scroll',zerif_scrolled);



jQuery(window).load(function() {
	
	/* SUBSCRIBE  */
	jQuery("form :input").each(function(index, elem) {
	
		var eId = jQuery(elem).attr("class");
	
		if( (eId == "sib-email-area") || (eId == "sib-NAME-area") ) {
		
			var label = null;
			if (eId && (label = jQuery(elem).parents("form").find("label."+eId)).length == 1) {
				jQuery(elem).attr("placeholder", jQuery(label).html());
				jQuery(label).remove();
			}
		}
	});
});	


/* TOP NAVIGATION MENU SELECTED ITEMS */
jQuery(window).scroll(function(){
	
	var zerif_scrollTop = jQuery(window).scrollTop();
	var zerif_windowHeight = jQuery(window).height();
	
	jQuery("section").each( function() {
		
		var zerif_offset = jQuery(this).offset();
		
		if (zerif_scrollTop <= zerif_offset.top && (jQuery(this).height() + zerif_offset.top) < (zerif_scrollTop + zerif_windowHeight) ) {
				
			jQuery('ul.nav > li a').each( function() {
				jQuery(this).removeClass('nav-active');
			});
			
			var zerif_current_id_visible = jQuery(this).attr('id');
			
			jQuery('ul.nav > li a').each( function() {
				if( jQuery(this).attr('href') ) {
					if( jQuery(this).attr('href').indexOf(zerif_current_id_visible) >= 0 ) {
						jQuery('ul.nav > li a').each( function() {
							jQuery(this).removeClass('nav-active');
						});
						jQuery(this).addClass('nav-active');
					}
				}	
				
			});
		}
		
	});

});


/* SETS THE HEIGHT OF THE HEADER */
jQuery(window).load(function(){
  setminHeightHeader();
});
jQuery(window).resize(function() {
  setminHeightHeader();
});
function setminHeightHeader() {
  if ( jQuery('#main-nav').css('min-height') != 75 || jQuery('.header').css('min-height') != 75 ) {
    jQuery('#main-nav').css('min-height',75);
    jQuery('.header').css('min-height',75);
  }
  if ( jQuery(window).width() > 750 ) {
      var minHeight = parseInt( jQuery('#main-nav').height() );
      jQuery('#main-nav').css('min-height',minHeight);
      jQuery('.header').css('min-height',minHeight);
  }
	if ( jQuery(window).width() < 768 ) {
		jQuery('#desctop-primary-menu').removeClass('open');
	}
}
/* - */


/* STICKY FOOTER */
jQuery(window).load(function(){
  fixFooterBottom();
});
jQuery(window).resize(function() {
  fixFooterBottom();
});

function fixFooterBottom(){

	var header      = jQuery('header.header');
	var footer      = jQuery('footer#footer');
	var content     = jQuery('.site-content > .container');

	content.css('min-height', '1px');

	var headerHeight  = header.outerHeight();
	var footerHeight  = footer.outerHeight();
	var contentHeight = content.outerHeight();
	var windowHeight  = jQuery(window).height();

	var totalHeight = headerHeight + footerHeight + contentHeight;

	if (totalHeight<windowHeight){
	  content.css('min-height', windowHeight - headerHeight - footerHeight );
	}else{
	  content.css('min-height','1px');
	}
}


/*** CENTERED MENU */
var zerif_callback_menu_align = function () {

	var headerWrap 		= jQuery('.header');
	var navWrap 		= jQuery('#site-navigation');
	var logoWrap 		= jQuery('.responsive-logo');
	var containerWrap 	= jQuery('.container');
	var classToAdd		= 'menu-align-center';

	if ( headerWrap.hasClass(classToAdd) ) 
	{
        headerWrap.removeClass(classToAdd);
	}
    var logoWidth 		= logoWrap.outerWidth();
    var menuWidth 		= navWrap.outerWidth();
    var containerWidth 	= containerWrap.width();

    if ( menuWidth + logoWidth > containerWidth ) {
        headerWrap.addClass(classToAdd);
    }
    else
    {
        if ( headerWrap.hasClass(classToAdd) )
        {
            headerWrap.removeClass(classToAdd);
        }
    }
}
jQuery(window).load(zerif_callback_menu_align);
jQuery(window).resize(zerif_callback_menu_align);

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

/* Rollover on mobile devices */
if( isMobile.any() ) {

  /* Our team section */
    jQuery('.team-member').on('click', function(){
        jQuery('.team-member-open').removeClass('team-member-open');
        jQuery(this).addClass('team-member-open');
        event.stopPropagation();
    });    
    jQuery("html").click(function() {
      jQuery('.team-member-open').removeClass('team-member-open');
  });
  
  /* Portfolio section */
  jQuery(document).ready(function(){
      jQuery('.cbp-rfgrid li').prepend('<p class="cbp-rfgrid-tr"></p>');
  });
    jQuery('.cbp-rfgrid li').on('click', function(){
        if ( !jQuery(this).hasClass('cbp-rfgrid-open') ){
            jQuery('.cbp-rfgrid-tr').css('display','block');
            jQuery('.cbp-rfgrid-open').removeClass('cbp-rfgrid-open');
            
            jQuery(this).addClass('cbp-rfgrid-open');
            jQuery(this).find('.cbp-rfgrid-tr').css('display','none');
            event.stopPropagation();            
        }
    });
    jQuery("html").click(function() {
        jQuery('.cbp-rfgrid-tr').css('display','block');
        jQuery('.cbp-rfgrid-open').removeClass('cbp-rfgrid-open');
  });
    
}

/* latest news */
jQuery(window).load(function(){

  if( jQuery( '#carousel-homepage-latestnews').length > 0 && isMobile.any() ) {
    if( jQuery( '#carousel-homepage-latestnews div.item' ).length < 2 ) {
      jQuery( '#carousel-homepage-latestnews > a' ).css('display','none');
    }
    var maxheight = 0;
    jQuery( '#carousel-homepage-latestnews div.item' ).each(function(){
      if( jQuery(this).height() > maxheight ) {
        maxheight = jQuery(this).height();
      }
    });
    jQuery( '#carousel-homepage-history div.item' ).height(maxheight);
  }

	if( jQuery( '#carousel-homepage-history').length > 0 && isMobile.any() ) {
    if( jQuery( '#carousel-homepage-history div.item' ).length < 2 ) {
      jQuery( '#carousel-homepage-history > a' ).css('display','none');
    }
    var maxheight = 0;
    jQuery( '#carousel-homepage-history div.item' ).each(function(){
      if( jQuery(this).height() > maxheight ) {
        maxheight = jQuery(this).height();
      }
    });
    jQuery( '#carousel-homepage-history div.item' ).height(maxheight);
  }

   

	
});

/*----Caruserl History*--------*/
jQuery(document).ready(function(){
 //jQuery('#carousel-homepage-history').carousel({interval: false});
	
	jQuery('#carousel-homepage-history').carousel({
  		interval: false,
  		wrap: false
	});
	
	jQuery('#carousel-homepage-history').on('slid.bs.carousel', '', function() {
  		var $this = jQuery(this);

  		$this.children('.carousel-control').show();

		  if(jQuery('.carousel-inner .item:first').hasClass('active')) {
			$this.children('.left.carousel-control').hide();
		  } else if(jQuery('.carousel-inner .item:last').hasClass('active')) {
			$this.children('.right.carousel-control').hide();
		  }

});
	
});

/* testimonial Masonry style */
var window_width_old;
var exist_class = false;
jQuery(document).ready(function(){
  if( jQuery('.testimonial-masonry').length>0 ){
    exist_class = true;
    window_width_old = jQuery('.container').outerWidth();
    if( window_width_old < 970 ) {
        jQuery('.testimonial-masonry').zerifgridpinterest({columns: 1,selector: '.feedback-box'});
    } else {
        jQuery('.testimonial-masonry').zerifgridpinterest({columns: 3,selector: '.feedback-box'});
    }
  }
});

jQuery(window).resize(function() {
    if( window_width_old != jQuery('.container').outerWidth() && exist_class === true ){
        window_width_old = jQuery('.container').outerWidth();
        if( window_width_old < 970 ) {
            jQuery('.testimonial-masonry').zerifgridpinterest({columns: 1,selector: '.feedback-box'});
        } else {
            jQuery('.testimonial-masonry').zerifgridpinterest({columns: 3,selector: '.feedback-box'});
        }
    }
});


(function ($, window, document, undefined) {
    var defaults = {
            columns:                3,
            selector:               'div',
            excludeParentClass:     '',
        };
    function ZerifGridPinterest(element, options) {
        this.element    = element;
        this.options    = $.extend({}, defaults, options);
        this.defaults   = defaults;
        this.init();
    }
    ZerifGridPinterest.prototype.init = function () {
        var self            = this,
            $container      = $(this.element);
            $select_options = $(this.element).children();
        self.make_magic( $container, $select_options );
    };
    ZerifGridPinterest.prototype.make_magic = function (container) {
        var self            = this;
            $container      = $(container),
            columns_height  = [],
            prefix          = 'zerif',
            unique_class    = prefix + '_grid_' + self.make_unique();
            local_class     = prefix + '_grid';
        var classname;
        var substr_index    = this.element.className.indexOf(prefix+'_grid_');
        if( substr_index>-1 ) {
            classname = this.element.className.substr( 0, this.element.className.length-unique_class.length-local_class.length-2 );
        } else {
            classname = this.element.className;
        }
        var my_id;
        if( this.element.id == '' ) {
            my_id = prefix+'_id_' + self.make_unique();
        } else {
            my_id = this.element.id;
        }
        $container.after('<div id="' + my_id + '" class="' + classname + ' ' + local_class + ' ' + unique_class + '"></div>');
        var i;
        for(i=1; i<=this.options.columns; i++){
            columns_height.push(0);
            var first_cols = '';
            var last_cols = '';
            if( i%self.options.columns == 1 ) { first_cols = prefix + '_grid_first'; }
            if( i%self.options.columns == 0 ) { first_cols = prefix + '_grid_last'; }
            $('.'+unique_class).append('<div class="' + prefix + '_grid_col_' + this.options.columns +' ' + prefix + '_grid_column_' + i +' ' + first_cols + ' ' + last_cols + '"></div>');
        }
        if( this.element.className.indexOf(local_class)<0 ){
            $container.children(this.options.selector).each(function(index){
                var min = Math.min.apply(null,columns_height);
                var this_index = columns_height.indexOf(min)+1;
                $(this).attr(prefix+'grid-attr','this-'+index).appendTo('.'+unique_class +' .' + prefix + '_grid_column_'+this_index);
                columns_height[this_index-1] = $('.'+unique_class +' .' + prefix + '_grid_column_'+this_index).height();
            });
        } else {
            var no_boxes = $container.find(this.options.selector).length;
            var i;
            for( i=0; i<no_boxes; i++ ){
                var min = Math.min.apply(null,columns_height);
                var this_index = columns_height.indexOf(min)+1;
                $('#'+this.element.id).find('['+prefix+'grid-attr="this-'+i+'"]').appendTo('.'+unique_class +' .' + prefix + '_grid_column_'+this_index);
                columns_height[this_index-1] = $('.'+unique_class +' .' + prefix + '_grid_column_'+this_index).height();
            }
        }
        $container.remove();
    }
    ZerifGridPinterest.prototype.make_unique = function () {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for( var i=0; i<10; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }
    $.fn.zerifgridpinterest = function (options) {
        return this.each(function () {
            var value = '';
            if (!$.data(this, value)) {
                $.data(this, value, new ZerifGridPinterest(this, options) );
            }
        });
    }
})(jQuery);
/* Header section */
jQuery(window).load(zerif_parallax_effect);
jQuery(window).resize(zerif_parallax_effect);

function zerif_parallax_effect(){

    if( jQuery('#parallax_move').length>0 ) {
      var scene = document.getElementById('parallax_move');
      var window_width = jQuery(window).outerWidth();
      jQuery('#parallax_move').css({
        'width':            window_width + 120,
        'margin-left':      -60,
        'margin-top':       -60,
        'position':         'absolute',
      });
      var h = jQuery('header#home').outerHeight();
      jQuery('#parallax_move').children().each(function(){
        jQuery(this).css({
            'height': h+100,
        });
      });
      if( !isMobile.any() ) {
        var parallax = new Parallax(scene);
      } else {
        jQuery('#parallax_move').css({
          'z-index': '0',
        });
        jQuery('#parallax_move .layer').css({
          'position': 'absolute',
          'top': '0',
          'left': '0',
          'z-index': '1',
        });
      }
    }

}


/* Menu levels */
jQuery( document ).ready( function() {
  jQuery( '#site-navigation' ).zerifsubmenuorientation();
	
	/*------------validate---------------*/
	var validate = function(elements) {
		var isValid = true;
		for(var i= 0; i<elements.length; i++) {
	    var el = jQuery(elements[i]);
	    var val = el.val();
//	    el.parent().removeClass('has-errros').removeClass('has-success');
    	if (el.hasClass('vemail') && el.attr('type') == 'email'){
			var Regex =/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!Regex.test(val)){
				el.addClass('invalid');
				isValid = false;
			} 
		}
    	if (el.hasClass('vrequire') && (val.length === 0 || val == el.attr('alt'))){
	    // el.addClass('has-errros');
	     isValid = false;
	    }
	   }
	    return isValid;
	};	
	
	jQuery('#searchform').bind('submit', function(){
		isValid = validate(['#s']);
			if (isValid){
				jQuery('#s').parent().removeClass('has-error' )	;		
			}else{
				jQuery('#s').parent().addClass('has-error' );	
				return false;
			}
	})
	
	jQuery('#s').keypress(function(eventObject){
		if (eventObject.which == '13'){
			isValid = validate(['#s']);
			if (isValid){
				jQuery(this).parent().removeClass('has-error' )	;		
			}else{
				jQuery(this).parent().addClass('has-error' );	
				return false;
			}
			}
	});
	
	
} );
;(function ($, window) {
    var defaults = {
        // 'true'   -> if there is a big submenu all submenu will be aligned to the right
        // 'false'  -> Only big submenu will be aligned to the right
        allItems: false,
      };
    function ZerifSubmenuOrientation(element, options) {
      this.element  = element;
      this.options  = $.extend({}, defaults, options);
      this.defaults = defaults;
      this.init();
    }
    ZerifSubmenuOrientation.prototype.init = function () {
      var self            = this,
          $container      = $(this.element),
          $select_options = $(this.element).children();
      var resize_finish;
      if( self.options.allItems !== true ) {
        $(window).resize(function() {
            clearTimeout(resize_finish);
            resize_finish = setTimeout( function () {
                self.make_magic($container, $select_options);
            }, 11);
        });
      }
      self.make_magic($container, $select_options);
      if( self.options.allItems !== true ) {
        setTimeout(function() {
            $(window).resize();
        }, 500);
      }
    };
    ZerifSubmenuOrientation.prototype.make_magic = function (container, select_options) {
      var self            = this,
          $container      = $(container),
          $select_options = $(select_options);
      var itemWrap;
      if( $container[0].tagName == 'UL' ) {
        itemWrap = $container[0];
      } else {
        itemWrap = $container.find( 'ul' )[0];
      }
      var windowsWidth = window.innerWidth;
	  if( typeof itemWrap != 'undefined' ) {
		
		var itemId = '#' + itemWrap.id;
	  
		  $( itemId ).children( 'li' ).each( function() {
			if ( this.id == '' ) { return; }
			var max_deep = self.max_deep( '#'+this.id );
			var offsetLeft        = $( "#"+this.id ).offset().left;
			var submenuWidthItem  = $( "#"+this.id ).find( 'ul' ).width();
			var submenuTotalWidth = max_deep * submenuWidthItem;
			if( submenuTotalWidth > 0 && windowsWidth < offsetLeft + submenuTotalWidth ) {
			  if( self.options.allItems === true ) {
				$( '#'+itemWrap.id ).addClass( 'menu-item-open-left-all' );
				return false;
			  }
			  $( '#'+this.id ).addClass( 'menu-item-open-left' );
			} else if( $( '#'+this.id ).hasClass( 'menu-item-open-left' ) ) {
			  $( '#'+this.id ).removeClass( 'menu-item-open-left' );
			}
		  } );
	  }  
    };
    ZerifSubmenuOrientation.prototype.max_deep = function ( item ) {
      var maxDepth      = -1, 
          currentDepth  = -1;
      $( item + " li:not(:has(ul))").each(function() {
        currentDepth = $(this).parents("ul").length;
        if (currentDepth > maxDepth) {
           maxDepth = currentDepth;
        }
      });
      return maxDepth - 1;
    }
    $.fn.zerifsubmenuorientation = function (options) {
      return this.each(function () {
        var value = '';
          if (!$.data(this, value)) {
              $.data(this, value, new ZerifSubmenuOrientation(this, options) );
          }
      });
    }
})(jQuery,window);



/************************************/
/*********Accessibility Menu*********/
/************************************/
(function( $ ) { 'use strict';
    // make dropdowns functional on focus
    $( '.primary-menu' ).find( 'a' ).on( 'focus blur', function() {
        $( this ).parents( 'ul, li' ).toggleClass( 'acc-focus' );
    } );

    $(".primary-menu ul").find('.dropdownmenu').remove();


    // menu navigation with arrow keys
    $('.menu-item a').on('keydown', function(e) {

        // left key
        if(e.which === 37) {
            e.preventDefault();
            $(this).parent().prev().children('a').focus();
        }
        // right key
        else if(e.which === 39) {
            e.preventDefault();
            $(this).parent().next().children('a').focus();
        }
        // down key
        else if(e.which === 40) {
            e.preventDefault();
            if($(this).next().length){
                $(this).next().next().find('li:first-child a').first().focus();
            }
            else {
                $(this).parent().next().children('a').focus();
            }
        }
        // up key
        else if(e.which === 38) {
            e.preventDefault();
            if($(this).parent().prev().length){
                $(this).parent().prev().children('a').focus();
            }
            else {
                $(this).parents('ul').first().prev().prev().focus();
            }
        }

    });

    $('.navbar-toggle').click(function(){

        $('.primary-menu').slideToggle('slow', function() {
           $(this).toggleClass('zerif-hide-on-mobile', $(this).is(':visible'));
        });
        $(this).removeAttr('style');
    });

    $('.primary-menu ul li.menu-item-has-children').children('a').after('<button class="dropdownmenu dropdown-toggle"><span class="screen-reader-text">Submenu</span></button>');
    $('.primary-menu ul li.menu-item-has-children .dropdownmenu').click( function() {
        $(this).parent().find('.sub-menu').slideToggle();
    });


    $('.primary-menu ul li.page_item_has_children').children('a').after('<button class="dropdownmenu dropdown-toggle"><span class="screen-reader-text">Submenu</span></button>');
    $('.primary-menu ul li.page_item_has_children .dropdownmenu').click( function() {
        $(this).parent().find('.sub-menu').slideToggle();
    });
} )( jQuery );

/*------------------Portfolio show all---------------*/
jQuery(document).ready(function(){
	jQuery('#view-all-button').bind('click', function(){
		
		var $href = jQuery(this).attr('href');
		var $first = $href.substr(0, 1);
		console.log($href);
		if($first == '#'){
			jQuery($href).removeClass('short_portfolio');
			jQuery(this).hide('fast');
			return false;
		}
	})
});