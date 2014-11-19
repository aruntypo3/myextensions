
function showDetails( uid, pageId, sysLangUid ){
	$('#loader').show();
	$('.alphadetails').css("opacity",".3");
	$.ajax({
		type: "POST",
		url: "?id="+pageId+"&tx_pitssupplier_pitssupplier[action]=show&tx_pitssupplier_pitssupplier[controller]=Pitssupplier&tx_pitssupplier_pitssupplier[supplier_uid]="+uid+"&L="+sysLangUid,
		success:function(data){
			$('#loader').hide();
			$('.alphadetails').css("opacity","1");
			$('#replacing_div').html(data);
		}	  		
	});
}

$(document).ready(function(){
	
	$('#search').bind("click",function(){
		jQuery(".alpha_atag").removeClass("active");
		var pageId = $('#pageid').val();
		var langUid = $('#languageUid').val();
		var currentUrl = $('#currentUrl').val();
		if(currentUrl!=window.location){
		      window.history.pushState({path:currentUrl},'',currentUrl);
		}
		searchData( pageId, langUid );
	});
	
	$("#keyword").keypress(function(e) {
	    if(e.which == 13) {
	    	jQuery(".alpha_atag").removeClass("active");
			var pageId = $('#pageid').val();
			var langUid = $('#languageUid').val();
			searchData( pageId, langUid );
	    }
	});
	
	$( "#keyword" ).focus(function() {
		var enterValue = $( "#keyword" ).val();
		if ( enterValue !== "" ) {
			$( "#keyword" ).val('');
		}
	});

	$( "#keyword" ).blur(function() {
		var enterValue = $( "#keyword" ).val();
		if ( enterValue !== "" ) {
			$( "#keyword" ).val(enterValue);
		}
	});
	
	
	$(".adetail").bind("click",function(){
		$('#loader').show();
		$(".alpha_atag").removeClass("active");
		$('#keyword').val('');
	    $(this).addClass('active');
		var pageId = $('#pageid').val();
		var langUid = $('#languageUid').val();
		var clickedId = $(this).attr('id');
		var string = clickedId.split("_"); 
		$('.alphadetails').css("opacity",".3");
		var currentUrl = $('#currentUrl').val();
		if(currentUrl!=window.location){
		      window.history.pushState({path:currentUrl},'',currentUrl);
		}

		$.ajax({
			type: "POST",
			url: "?id="+pageId+"&tx_pitssupplier_pitssupplier[action]=search&tx_pitssupplier_pitssupplier[controller]=Pitssupplier&L="+langUid,
			data: ({keyword : '', clickVal: string[2], pageid: pageId, languageUid: langUid}),
			success:function(data){
				$('#loader').hide();
				$('.alphadetails').css("opacity","1");
				$('#replacing_div').html(data);
			}	  		
		});
	});

	$("#supplier_backtoList").live("click",function(){
		$('#loader').show();
		$('.alphadetails').css("opacity",".3");
		var string = "";
		var keyValue = "";
		$( ".alphanumeric_listing li" ).each(function( index, element ) {
			if( $(this).find( "a" ).hasClass( "active" ) == true ){
				var clickedId = $(this).find( "a" ).attr('id').split("_");
				string = clickedId[2];
			}else{
				keyValue = document.getElementById('keyword').value;
			}
		});	
		var pageId = $('#pageid').val();
		var langUid = $('#languageUid').val();
		var currentUrl = $('#currentUrl').val();
		if(currentUrl!=window.location){
		      window.history.pushState({path:currentUrl},'',currentUrl);
		}
		
		$.ajax({
			type: "POST",
			url: "?id="+pageId+"&tx_pitssupplier_pitssupplier[action]=search&tx_pitssupplier_pitssupplier[controller]=Pitssupplier&L="+langUid,
			data: ({keyword : keyValue, clickVal: string, pageid: pageId, languageUid: langUid}),
			success:function(data){
				$('#loader').hide();
				$('.alphadetails').css("opacity","1");
				$('#replacing_div').html(data);
			}	  		
		});
	});

	
});

function searchData( pageId, langUid ){
	$('#loader').show();
	var data = $('#searchForm').serialize() ; 
	$('.alphadetails').css("opacity",".3");
	
	$.ajax({
		type: "POST",
		url: "?id="+pageId+"&tx_pitssupplier_pitssupplier[action]=search&tx_pitssupplier_pitssupplier[controller]=Pitssupplier&L="+langUid,
		data: data,
		success:function(data){
			$('#loader').hide();
			$('.alphadetails').css("opacity","1");
			$('#replacing_div').html(data);
		}	  		
	});
}