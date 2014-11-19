hevents.extend({
	slider: {
		slider: null,
		
		init: function(items){
			this.slider = $('.slider-container').bxSlider({displaySlideQty: items});
			$('.bx-next').html('<span class="icon-next">'+$('.bx-next').html()+'<span>');
			$('.bx-prev').html('<span class="icon-prev">'+$('.bx-prev').html()+'<span>');
		},
		
		initThums: function(imagesId, thumbsId, mode){
			if(!mode) mode = 'fade';
			this.slider = $('#'+imagesId).bxSlider({controls: false, mode:mode});
			
			$('#'+thumbsId+' a').click(function(e){
				hevents.slider.slider.goToSlide($('#'+thumbsId+' a').index(this));
				$('#'+thumbsId+' a').removeClass('pager-active');
				$(this).addClass('pager-active');
				e.preventDefault();
			});
			
			$('#'+thumbsId+' a:first').addClass('pager-active');
		},
		
		initThumsAuto: function(imagesId, thumbsId, mode){
			if(!mode) mode = 'horizontal';
			this.slider = $('#'+imagesId).bxSlider({
				controls: false, 
				mode:mode, 
				auto: true,
				onNextSlide: function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject){
					hevents.slider.current++;
					var index = $('#'+thumbsId+' .pager-active').removeClass('pager-active').index() + 1;
					if(index > $('#'+thumbsId+' a:last').index()) index=0;
					//$('#'+thumbsId+' a').removeClass('pager-active');
					$('#'+thumbsId+' a').eq(index).addClass('pager-active');
				}
			});
			
			
			$('#'+thumbsId+' a').click(function(e){
				hevents.slider.slider.goToSlide($('#'+thumbsId+' a').index(this));
				$('#'+thumbsId+' a').removeClass('pager-active');
				$(this).addClass('pager-active');
				e.preventDefault();
			});
			
			$('#'+thumbsId+' a:first').addClass('pager-active');
		} 
	}
});