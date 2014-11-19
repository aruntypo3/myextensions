hevents.extend({
	filter: {
		init: function(){
			$('#city').change(function(){hevents.filter.submit()});
			$('#startdate').change(function(){hevents.filter.submit()});
			$('#enddate').change(function(){hevents.filter.submit()});
		},
		submit: function(){
			$('#filter').submit();
		}
	}
});

jQuery(document).ready(function(){
	hevents.filter.init();
});