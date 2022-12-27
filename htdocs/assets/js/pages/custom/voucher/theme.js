/**
 * Stock Coupon - Responsive Coupons, Deal and Promo Template  
 *
 * This file contains all theme JS functions
 *
 * @package 
--------------------------------------------------------------
				   Contents
--------------------------------------------------------------
 * 01 - Clipboard
 * 06 - Click To Select Text

--------------------------------------------------------------*/

(function($) {
  "use strict";

// Clipboard
	$('.coupon-cpy-btn .btn').tooltip({
		 trigger: 'click',
		 placement: 'bottom'
	});
	function setTooltip(btn, message) {
	  $(btn).tooltip('hide')
	    .attr('data-original-title', message)
	    .tooltip('show');
	}
	function hideTooltip(btn) {
	  setTimeout(function() {
	    $(btn).tooltip('hide');
	  }, 1000);
	}
	var clipboard = new ClipboardJS('.coupon-cpy-btn .btn');
	clipboard.on('success', function(e) {
	  	setTooltip(e.trigger, 'Berhasil Disalin!');
	  	hideTooltip(e.trigger);
	});
	clipboard.on('error', function(e) {
	  	setTooltip(e.trigger, 'Press CTRL + C');
	  	hideTooltip(e.trigger);
	});

// Click To Select Text
	$(".coupon-code").on('mouseup', function() { 
	    var sel, range;
	    var el = $(this)[0];
	    if (window.getSelection && document.createRange) { //Browser compatibility
	      sel = window.getSelection();
	      if(sel.toString() == ''){ //no text selection
	         window.setTimeout(function(){
	            range = document.createRange(); //range object
	            range.selectNodeContents(el); //sets Range
	            sel.removeAllRanges(); //remove all ranges from selection
	            sel.addRange(range);//add Range to a Selection.
	        },1);
	      }
	    }else if (document.selection) { //older ie
	        sel = document.selection.createRange();
	        if(sel.text == ''){ //no text selection
	            range = document.body.createTextRange();//Creates TextRange object
	            range.moveToElementText(el);//sets Range
	            range.select(); //make selection.
	        }
	    }
	});

})(jQuery);