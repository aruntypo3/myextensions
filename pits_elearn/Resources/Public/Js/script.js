/*jslint white: true, browser: true, undef: true, nomen: true, eqeqeq: true, plusplus: false, bitwise: true, regexp: true, strict: true, newcap: true, immed: true, maxerr: 14 */
/*global window: false, REDIPS: true */



//define redipsInit variable
var redipsInit;
var dragimageId ;

//redips initialization
redipsInit = function () {
	var rd = REDIPS.drag;	// reference to the REDIPS.drag class
	// DIV container initialization
	rd.init('drag1');
	// elements could be cloned with pressed SHIFT key (for demo)
	rd.clone_shiftKey = true;
	rd.dropMode = 'single';
	// row row_dropped
	rd.event.droppedBefore = function (){
		var objOld = rd.objOld,                // original object
        targetCell = rd.td.target,         // target cell
        targetRow = targetCell.parentNode, // target row
        i, objNew;                         // local variables
		var localId = targetCell.id ;
		var newId = localId.split("_");
		var newId_1 = newId[1];
		//alert(newId_1);
		var imageInSecondTD = $("#dropSecond_"+newId_1).find('img').length ;
		var imageInFirstTD = $("#drop_"+newId_1).find('img').length;
		//console.log($("#drop_"+newId_1));
		var oldDomId = objOld.id.split("_") ;
		var odlDomID_1 = oldDomId[3];
		dragimageId = imageInFirstTD;
		
		if( imageInSecondTD > 0  ){
			
			//console.log($("#dropSecond_"+newId_1).find("img").attr('src'));
			//console.log($("drag_image_path_"+odlDomID_1).val("234234432"));
			
			//console.log(document.getElementById("drag_image_path_"+odlDomID_1));
			
			
			//document.getElementById("drag_image_path_"+odlDomID_1).value = $("#dropSecond_"+newId_1).find("img").attr("src");
			
			//return false;
			//$("drag_image_path_"+odlDomID_1).val();
		
			
			/*console.log($("#dropSecond_"+odlDomID_1).find("img").attr("src"));
			alert(newId_1);
			console.log($("#dropSecond_"+newId_1).find("img").attr("src"));
			$("#dropSecond_"+odlDomID_1).find("img").attr("src");  */
			//$("#dropSecond_"+newId_1).html('');
			//return false;
		}
		//dragimageId =  odlDomID_1;
	}
	rd.event.dropped = function ( arg ) {
		var objOld = rd.objOld,                // original object
        targetCell = rd.td.target,         // target cell
        targetRow = targetCell.parentNode, // target row
        i, objNew;                         // local variables
		
		var localId = targetCell.id ;
		var newId = localId.split("_");
		var newId_1 = newId[1];
		var imageLocalId = $("#"+targetCell.id).find("img").attr("id");
		var newimageLocalId = imageLocalId.split("__");
		var newimageLocalId_1 = newimageLocalId[1];
		
		var oldDomId = objOld.id.split("_") ;
		var odlDomID_1 = oldDomId[3];
		
		var imageInSecondTD = $("#dropSecond_"+newId_1).find('img').length ;
		
		//alert(newId[0]);
		if( newId[0] != "dropSecond" ){
			$("#drag_image_path_"+newId_1).val($("#"+targetCell.id).find("img").attr("src"));
			var position_id = "postion_"+newId_1;
			document.getElementById(position_id).value = 1;
			var source = rd.td.source.id;
			var source = source.split("_") ;
			var source_1 = source[1];
			var imageInFirstTD = $("#drop_"+source_1).find('img').length;
			//document.getElementById("drag_"+source_1).value = '';
			//alert(newId_1); 
			//alert(source_1);
			document.getElementById("drag_"+newId_1).value = newimageLocalId_1;
			if(newId_1 != source_1 &&  imageInFirstTD == 0 ){
				document.getElementById("drag_"+source_1).value = '';
				document.getElementById("postion_"+source_1).value = 0;	
			}
		}else{
			console.log(rd.td.source);
			var source = rd.td.source.id;
			var source = source.split("_") ;
			var source_1 = source[1];
		
			var imageInFirstTD = $("#drop_"+source_1).find('img').length;
			var imageInSecondTD = $("#dropSecond_"+source_1).find('img').length ;
			if( imageInFirstTD == 0 ){
				$("#postion_"+source_1).val('');
				$("#drag_"+source_1).val('0');
			}
			
		}
		//alert(typeof($("#dropSecond_"+newId_1).find("img").attr('src')));
		if( typeof($("#dropSecond_"+newId_1).find("img").attr('src')) != "undefined"){
			//alert(odlDomID_1);
			//$("#drag_"+odlDomID_1).val('');
		}
		/*if( typeof($("#dropSecond_"+newId_1).find("img").attr('src')) != "undefined"){
			var fuckid = rd.td.source.id.split("_");
			var targetid = "drag_image_path_"+dragimageId;
			var position_id = "postion_"+dragimageId;
			document.getElementById(position_id).value = 0;
			document.getElementById(targetid).value = $("#dropSecond_"+newId_1).find("img").attr('src') ;
			$("#drag_"+newId_1).val('');
			
			if( $("#"+localId).hasClass("last") ){
				alert("LAST TD");
				var last_id = $(".first").attr("id").split("_");
				var toreplace_id = "drag_image_path_"+last_id[1];
				if( document.getElementById(toreplace_id).value == document.getElementById("drag_image_path_"+newId_1).value  ){
					document.getElementById(toreplace_id).value = $("#dropSecond_"+newId_1).find("img").attr("src");
					return;
				}else{
					var targetid = "drag_image_path_"+fuckid[1];
					document.getElementById(targetid).value = $("#dropSecond_"+newId_1).find("img").attr("src");
					alert(targetid);
				}
				
				//document.getElementBy(toreplace_id).value = 
				//return
			}
		}*/
		
		return;
		
		
		
		/*var domIdHtml = arg.id;
		
		var drop = domIdHtml.split("_");
		if( drop[0] == 'dropSecond'){
			var src = $('#'+arg.id).find('img').attr('id');
			var srcImage = $('#'+arg.id).find('img').attr('src');
			var dom_id = src.split("__");
			//console.log(dom_id);
			$("#postion_"+drop[1]).val("1");
			srcImage = $("#drag_image_container_"+drop[1]).find("img").attr("src") ;
			$('#'+arg.id).find('input.dragImg').val(dom_id[1]);
			//console.log(srcImage);$('#drag_image_path_'+drop[1]).val("");
			$('#drag_image_path_'+drop[1]).val(srcImage);
			var id_1 = $("#drag_image_container_"+drop[1]).find("img").attr("id") ;
			$('#drag_'+drop[1]).val("");
			$('#drag_'+drop[1]).val(id_1[1]);*/
			 
			 
			
			/*$(".dragImageSrc").each(function(index, value) {
		        var domId = $(this).attr("id") ;
		        var rightImageRecord = domId.split('_');		   
			    var dropImageId = '#dropSecond_'+rightImageRecord[3];
			    //console.log($(dropImageId).find("img").attr("src"));
			    var rightImageVal = $(this).val();	
			    var idrecord = domId.split("_");	
			    var leftImageId = "#dropSecond_"+idrecord[3];
			    var leftImageVal = $(leftImageId).find('img').attr("src");	
			    console.log(rightImageVal);
			    if ( leftImageVal != rightImageVal  ){		
			       $(this).val(leftImageVal);	
			    }
		   });*/
			
		/*}else {
			
			var src = $('#'+arg.id).find('img').attr('id');
			var srcImage = $('#'+arg.id).find('img').attr('src');
			var dom_id = src.split("__");
			//console.log(dom_id);
			$("#postion_"+drop[1]).val("1");
			srcImage = $("#drag_image_container_"+drop[1]).find("img").attr("src") ;
			//alert("#drag_image_container_"+drop[1]);
			//console.log($("#drag_image_container_"+drop[1]).find(".dragable_image"));
			//alert($("#drag_image_container_"+drop[1]).find(".dragable_image").attr("src"));
			var dropedID = $("#drag_image_container_"+drop[1]).find(".dragable_image").attr("id").split("__");
			//alert(dropedID);
			$('#drag_'+drop[1]).val("");
			$('#drag_'+drop[1]).val(dropedID[1]);
			$('#drag_image_path_'+drop[1]).val("");
			$('#drag_image_path_'+drop[1]).val($("#drag_image_container_"+drop[1]).find(".dragable_image").attr("src"));
			return false;
		}
		
		
		
		$(".dragImageSrc").each(function(index, value) {
	        var domId = $(this).attr("id") ;
	        var rightImageRecord = domId.split('_');		   
		    var dropImageId = '#dropSecond_'+rightImageRecord[3];
		    //console.log($(dropImageId).find("img").attr("src"));
		    var rightImageVal = $(this).val();	
		    var idrecord = domId.split("_");	
		    var leftImageId = "#dropSecond_"+idrecord[3];
		    var leftImageVal = $(leftImageId).find('img').attr("src");	
		    if ( leftImageVal != rightImageVal  ){		
		       $(this).val(leftImageVal);	
		    }
	   });*/
		
		

	};
	rd.event.relocateAfter  = function ( div, td ){
		//console.log (td );
	}
};


//add onload event listener
if (window.addEventListener) {
	window.addEventListener('load', redipsInit, false);
}
else if (window.attachEvent) {
	window.attachEvent('onload', redipsInit);
}