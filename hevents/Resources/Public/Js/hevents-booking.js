jQuery(document).ready(function(){
	jQuery('#delevieraddress').change(function(){
		if(jQuery(this).is(':checked')){
			jQuery('#delevieraddress-container').show();
			jQuery('#deliverAddressSection').val(1);
		}else{
			jQuery('#delevieraddress-container').hide();
			jQuery('#deliverAddressSection').val(0);
		}
	}).change();
	
	var textboxes = $('#delevieraddress-container').find('input');
	textboxes.each(function() {
	    if( this.value.length != '' ){
	    	jQuery('#delevieraddress').val(1);
	    	jQuery('#delevieraddress').attr('checked', true);
	    	jQuery('#deliverAddressSection').val(1);
	    	jQuery('#delevieraddress-container').show();
	    }
	});
});