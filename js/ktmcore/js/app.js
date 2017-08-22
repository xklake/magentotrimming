jQuery(document).ready(function($) {
    jQuery('.ktm-container').addClass('loaded');
	var PointerManager = {
    MOUSE_POINTER_TYPE: 'mouse',
    TOUCH_POINTER_TYPE: 'touch',
    POINTER_EVENT_TIMEOUT_MS: 500,
    standardTouch: false,
    touchDetectionEvent: null,
    lastTouchType: null,
    pointerTimeout: null,
    pointerEventLock: false,
    getPointerEventsSupported: function() {
        return this.standardTouch;
    },
    getPointerEventsInputTypes: function() {
        if (window.navigator.pointerEnabled) { //IE 11+
            //return string values from http://msdn.microsoft.com/en-us/library/windows/apps/hh466130.aspx
            return {
                MOUSE: 'mouse',
                TOUCH: 'touch',
                PEN: 'pen'
            };
        } else if (window.navigator.msPointerEnabled) { //IE 10
            //return numeric values from http://msdn.microsoft.com/en-us/library/windows/apps/hh466130.aspx
            return {
                MOUSE: 0x00000004,
                TOUCH: 0x00000002,
                PEN: 0x00000003
            };
        } else { //other browsers don't support pointer events
            return {}; //return empty object
        }
    },
    /**
     * If called before init(), get best guess of input pointer type
     * using Modernizr test.
     * If called after init(), get current pointer in use.
     */
    getPointer: function() {
        // On iOS devices, always default to touch, as this.lastTouchType will intermittently return 'mouse' if
        // multiple touches are triggered in rapid succession in Safari on iOS
        if (Modernizr.ios) {
            return this.TOUCH_POINTER_TYPE;
        }
        if (this.lastTouchType) {
            return this.lastTouchType;
        }
        return Modernizr.touch ? this.TOUCH_POINTER_TYPE : this.MOUSE_POINTER_TYPE;
    },
    setPointerEventLock: function() {
        this.pointerEventLock = true;
    },
    clearPointerEventLock: function() {
        this.pointerEventLock = false;
    },
    setPointerEventLockTimeout: function() {
        var that = this;
        if (this.pointerTimeout) {
            clearTimeout(this.pointerTimeout);
        }
        this.setPointerEventLock();
        this.pointerTimeout = setTimeout(function() {
            that.clearPointerEventLock();
        }, this.POINTER_EVENT_TIMEOUT_MS);
    },
    triggerMouseEvent: function(originalEvent) {
        if (this.lastTouchType == this.MOUSE_POINTER_TYPE) {
            return; //prevent duplicate events
        }
        this.lastTouchType = this.MOUSE_POINTER_TYPE;
        $ktm(window).trigger('mouse-detected', originalEvent);
    },
    triggerTouchEvent: function(originalEvent) {
        if (this.lastTouchType == this.TOUCH_POINTER_TYPE) {
            return; //prevent duplicate events
        }
        this.lastTouchType = this.TOUCH_POINTER_TYPE;
        $ktm(window).trigger('touch-detected', originalEvent);
    },
    initEnv: function() {
        if (window.navigator.pointerEnabled) {
            this.standardTouch = true;
            this.touchDetectionEvent = 'pointermove';
        } else if (window.navigator.msPointerEnabled) {
            this.standardTouch = true;
            this.touchDetectionEvent = 'MSPointerMove';
        } else {
            this.touchDetectionEvent = 'touchstart';
        }
    },
    wirePointerDetection: function() {
        var that = this;
        if (this.standardTouch) { //standard-based touch events. Wire only one event.
            //detect pointer event
            $ktm(window).on(this.touchDetectionEvent, function(e) {
                switch (e.originalEvent.pointerType) {
                    case that.getPointerEventsInputTypes().MOUSE:
                        that.triggerMouseEvent(e);
                        break;
                    case that.getPointerEventsInputTypes().TOUCH:
                    case that.getPointerEventsInputTypes().PEN:
                        // intentionally group pen and touch together
                        that.triggerTouchEvent(e);
                        break;
                }
            });
        } else { //non-standard touch events. Wire touch and mouse competing events.
            //detect first touch
            $ktm(window).on(this.touchDetectionEvent, function(e) {
                if (that.pointerEventLock) {
                    return;
                }
                that.setPointerEventLockTimeout();
                that.triggerTouchEvent(e);
            });
            //detect mouse usage
            $ktm(document).on('mouseover', function(e) {
                if (that.pointerEventLock) {
                    return;
                }
                that.setPointerEventLockTimeout();
                that.triggerMouseEvent(e);
            });
        }
    },
    init: function() {
        this.initEnv();
        this.wirePointerDetection();
    }
};
PointerManager.init();
// Bootstrap prototype magento
(function() {
    var isBootstrapEvent = false;
    if (window.jQuery) {
        var all = jQuery('*');
        jQuery.each(['hide.bs.dropdown', 'hide.bs.collapse', 'hide.bs.modal', 'hide.bs.tooltip', 'hide.bs.popover'], function(index, eventName) {
            all.on(eventName, function(event) {
                isBootstrapEvent = true;
            });
        });
    }
    var originalHide = Element.hide;
    Element.addMethods({
        hide: function(element) {
            if (isBootstrapEvent) {
                isBootstrapEvent = false;
                return element;
            }
            return originalHide(element);
        }
    });
})();

    $('.ktm-navigation-vertical .block-title').on('click', function(e) {
        $('.ktm-main-menu-vertical').slideToggle(400);
    });

    // button show hide menu mobile
    $('.btn-nav').on('click', function(event) {
        event.preventDefault();
        $('.overlay-contentscale').addClass('open');
        $('.ktm-wrapper').addClass('overlay-open');
    });
    $('.overlay-close').on('click', function(event) {
        event.preventDefault();
        $('.overlay-contentscale').removeClass('open');
        $('.btn-nav').removeClass('active');
        $('.ktm-wrapper').removeClass('overlay-open');
    });

    // map
    // Disable scroll zooming and bind back the click event
    var onMapMouseleaveHandler = function (event) {
      var that = $(this);

      that.on('click', onMapClickHandler);
      that.off('mouseleave', onMapMouseleaveHandler);
      that.find('iframe').css("pointer-events", "none");
    }

    var onMapClickHandler = function (event) {
      var that = $(this);

      // Disable the click handler until the user leaves the map area
      that.off('click', onMapClickHandler);

      // Enable scrolling zoom
      that.find('iframe').css("pointer-events", "auto");

      // Handle the mouse leave event
      that.on('mouseleave', onMapMouseleaveHandler);
    }

    // Enable map zooming with mouse scroll when the user clicks the map
    $('.map-box').on('click', onMapClickHandler);

    
    // 
	$(".mobile-collapsible").each (function() {
		
		$(this).find(".text-block:visible").prev().addClass('on');
		$(this).find(".text-block:hidden").prev().addClass('off');
		$(this).find(".title-block").click(function(){
			if($(window).width()<=768) {
				$(this).next().slideToggle('fast');
				if ($(this).hasClass("on")) {
					$(this).removeClass("on").addClass("off");
				}	else  {
					$(this).removeClass("off").addClass("on");
				}
			}
		});
		
	});
		
	if($(window).width()<=991) {
		if ($(".masonry.active") && $(".view-mode .grid") === true) {
			$(".view-mode .grid")[0].click();
		}
	}
	
	$(".col-left.sidebar").on ("click","dt",function(){
		$(this).next().slideToggle(100);
	})
	$(".col-left.sidebar").on ("click",".block-nav .block-title",function(){
		$(this).next().slideToggle(100);
	})
	
	
});

(function($) {
   function fixHeightSpecial(){
	   if($(window).width()>=768){
		   r = $(".last-right-special").height();
			l = $(".grid-left-special").height() - 30;
			e = $(".last-right-special .product-hover").height();
			h = l-r;
			$(".last-right-special .product-hover").height(e+h);
	   }
	};
	function resizeMobMenu(){
		if($(".btn-group-right > div").length ==5 && $(window).width()<=480) {
			$(".btn-group-right > div").css("width","20%");
		}
	}
	$(window).load(function(){
		fixHeightSpecial();
		resizeMobMenu();
	});
	
    $(window).resize(function(){
		fixHeightSpecial();
		resizeMobMenu();
    });
	
})(jQuery);

	
	

	
// ==============================================
// PDP - image zoom - needs to be available outside document.ready scope
// ==============================================

var ProductMediaManager = {
    IMAGE_ZOOM_THRESHOLD: 20,
    imageWrapper: null,

    destroyZoom: function() {
        $ktm('.zoomContainer').remove();
        $ktm('.product-image-gallery .gallery-image').removeData('elevateZoom');
    },

    createZoom: function(image) {
        // Destroy since zoom shouldn't be enabled under certain conditions
        ProductMediaManager.destroyZoom();

        // if(
        //     // Don't use zoom on devices where touch has been used
        //     PointerManager.getPointer() == PointerManager.TOUCH_POINTER_TYPE
        //     // Don't use zoom when screen is small, or else zoom window shows outside body
        //     || Modernizr.mq("screen and (max-width:" + bp.medium + "px)")
        // ) {
        //     return; // zoom not enabled
        // }

        if (Modernizr.mq("screen and (max-width:767px)")) {
            return; // zoom not enabled
            image.preventDefault();
        }

        if(image.length <= 0) { //no image found
            return;
        }

        if(image[0].naturalWidth && image[0].naturalHeight) {
            var widthDiff = image[0].naturalWidth - image.width() - ProductMediaManager.IMAGE_ZOOM_THRESHOLD;
            var heightDiff = image[0].naturalHeight - image.height() - ProductMediaManager.IMAGE_ZOOM_THRESHOLD;

            if(widthDiff < 0 && heightDiff < 0) {
                //image not big enough

                image.parents('.product-image').removeClass('zoom-available');
                ProductMediaManager.destroyZoom();
                return;
            } else {
                image.parents('.product-image').addClass('zoom-available');
            }
        }

        image.elevateZoom(configzoom);
    },

    swapImage: function(targetImage) {
        targetImage = $ktm(targetImage);
        targetImage.addClass('gallery-image');

        ProductMediaManager.destroyZoom();

        var imageGallery = $ktm('.product-image-gallery');
        
        if(targetImage[0].complete) { //image already loaded -- swap immediately

            imageGallery.find('.gallery-image').removeClass('visible');

            //move target image to correct place, in case it's necessary
            imageGallery.append(targetImage);

            //reveal new image
            targetImage.addClass('visible');

            //wire zoom on new image
            ProductMediaManager.createZoom(targetImage);

        } else { //need to wait for image to load

            //add spinner
            imageGallery.addClass('loading');
            
            //move target image to correct place, in case it's necessary
            imageGallery.append(targetImage);

            //wait until image is loaded
            imagesLoaded(targetImage, function() {
                //remove spinner
                imageGallery.removeClass('loading');

                //hide old image
                imageGallery.find('.gallery-image').removeClass('visible');

                //reveal new image
                targetImage.addClass('visible');

                //wire zoom on new image
                ProductMediaManager.createZoom(targetImage);
            });

        }
    },

    wireThumbnails: function() {
        //trigger image change event on thumbnail click
        $ktm('.product-image-thumbs .thumb-link').click(function(e) {
            e.preventDefault();
            var jlink = $ktm(this);
            var target = $ktm('#image-' + jlink.data('image-index'));

            ProductMediaManager.swapImage(target);
        });
    },

    initZoom: function() {
        ProductMediaManager.createZoom($ktm(".gallery-image.visible")); //set zoom on first image
    },

    init: function() {
        ProductMediaManager.imageWrapper = $ktm('.product-img-box');

        // Re-initialize zoom on viewport size change since resizing causes problems with zoom and since smaller
        // viewport sizes shouldn't have zoom

        $ktm(window).resize(function(event) {
            ProductMediaManager.initZoom();
        });

        ProductMediaManager.initZoom();

        ProductMediaManager.wireThumbnails();

        $ktm(document).trigger('product-media-loaded', ProductMediaManager);
    }
};

$ktm(document).ready(function() {
    ProductMediaManager.init();
});
