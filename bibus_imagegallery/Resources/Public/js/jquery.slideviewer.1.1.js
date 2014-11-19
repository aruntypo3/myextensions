
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Julian Kleinhans <jk@web-factory.de>
*  (c) 2008 Erik Frister <efrister@web-factory.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Original script
 * http://www.gcmingati.net/wordpress/wp-content/lab/jquery/imagestrip/imageslide-plugin.html
 * 
 */



/*jQuery(function(){
   jQuery("div.svw").prepend("<img src='/typo3conf/ext/mfc_damgallerie/res/icons/ajax-loader.gif' class='ldrgif' alt='loading...'/ >"); 
});
*/

jQuery.fn.slideView = function(settings) {
    var id = settings;
   // alert(id);
	 settings = jQuery.extend({
     easeFunc: "easeInOutExpo",
     easeTime: 750,
     toolTip: false
  }, settings);
	return this.each(function(){		
		
		var container = jQuery(this);
		container.find("img.ldrgif").remove(); // removes the preloader gif
		container.removeClass("svw").addClass("stripViewer");	
		//var pictWidth = container.find("li").find("img").width();
		//var pictHeight = container.find("li").find("img").height();
		var pictWidth = 211;
		var pictHeight = 191;
		var pictEls = container.find("li").size();
		var stripViewerWidth = pictWidth*pictEls;
		container.find("ul").css("width" , stripViewerWidth); //assegnamo la larghezza alla lista UL	
		container.css("width" , pictWidth);
		//container.css("height" , pictHeight);
		var currentPicIndex = 0;
		 var pre;
                pre = '.img_prev';
		jQuery(pre).bind("click", function(){
			var currentLeft = jQuery(this).parent().parent().prev().css('left');
			currentLeft = parseInt(currentLeft.substr(0, currentLeft.length - 2));
			
			if(currentLeft % pictWidth != 0) return;
			
			var cnt = pictWidth;
			var left = currentLeft + cnt;
			
			if(currentPicIndex == 0) {
				return;
			}
			
			jQuery(this).parent().parent().prev().animate({ left: left}, settings.easeTime, settings.easeFunc);
			currentPicIndex --;
			return false;
		});
		var next;
                next = '.img_next';
		jQuery(next).bind("click", function(){
			var currentLeft = jQuery(this).parent().parent().prev().css('left');
			currentLeft = parseInt(currentLeft.substr(0, currentLeft.length - 2));
			
			if(currentLeft % pictWidth != 0) return;
			
			var cnt = - (pictWidth);
			var left = currentLeft + cnt;
			
			if(currentPicIndex + 1 == pictEls) {
				return;
			}
			jQuery(this).parent().parent().prev().animate({ left: left}, settings.easeTime, settings.easeFunc);
			currentPicIndex ++;
			return false;			
			
		});
                 var light;
                light = '.img_lightbox';
		jQuery(light).bind("click", function(){
			var currentLeft = jQuery(this).parent().parent().prev().css('left');
			currentLeft = parseInt(currentLeft.substr(0, currentLeft.length - 2));			
			var index = (currentLeft/pictWidth)*(-1);
			var curEl = jQuery(this).parent().parent().prev().find('li a').get(index);
			
			jQuery(curEl).click();
			
		});
  });	
};