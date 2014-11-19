var sysLangUid = 0
$(document).ready(function() {
    sysLangUid =$('#sys_lang_id').val();
    $('.green-box').hide();
    $("#ansimage").live("click" , function (){
        var imageSrc = $(this).attr("href") ;
        jQuery.slimbox(imageSrc, "");
        return false;
    });
    //Added by siva on 16/10/2013 Start
    /*$(".image-holder").find("img").live("click" , function (){
        var imageSrc = $(this).attr("src") ;
        jQuery.slimbox(imageSrc, "" , { initialWidth : 350 , initialHeight : 350 } );
        return false;
    }); 
    */
    
    $(".image-holder").find("img").live("click" , function (){
        var imageSrc = jQuery(this).parent().find('.question_image').attr("src")
        jQuery.slimbox(imageSrc, "" , { initialWidth : 350 , initialHeight : 350 } );
        return false;
    });
    
    //Added by siva on 16/10/2013 end

    $('.qsolution').hide();
    $('.title-ans').hide();
    $('#questionsForm').each (function(){
        this.reset();
    });
    themaValue = $('.select-thema').val();
    domLenghth = $('.select-thema').length;
    page_id =  $('.thema_page_id').val();
    if(themaValue != '' && themaValue != 0 && domLenghth != 0 ){
        doGetValue(themaValue,page_id);

    }
    $('#show_sol').click(function(){
        $( '.solutions_class' ).css( "background", "#cbefc0" );
        $('.ask_again').hide();
        $("#showSolutionStatus").val(1);
        $('.proceed_next').show();
    });
    
});
function doGetValue(themaValue,pageId){
    $.ajax({
        type: "POST",
        cache: false,
        url: "?id="+pageId+"&tx_pitselearn_pitselearn[action]=ajaxChapters&tx_pitselearn_pitselearn[controller]=Elearning&tx_pitselearn_pitselearn[themaValue]="+themaValue+"&L="+sysLangUid,
        success: function (data) {
            $('.online-form').find('#id-chapters_div').html(data);
            $('.online-form-last').find('#id-chapters_div').html(data);
        }
    })


}

function freetextAnswer(pageId, type)
{
	if( type != 'previous_quest' && type != 'next_quest'){
		$("#dd_error").hide();
		if ($("#quest_type").length > 0 ) {
		if( $("#quest_type").val() == "dragdrop" ){
			var is_empty = false;
			$(".dragImg").each(function( index , value) {
				if($(this).val() == '' || $(this).val() ==  0){
					is_empty = true;
				}
			});
		}
		}
		if( is_empty ){
			$("#dd_error").show();
			return false;
		}
		
		$('.wrong_img').hide();
	    $('.right_img').hide();
	}
	
	var formData = $("#questionsForm").serialize();
    $.ajax({
        type: "GET",
        cache: false,
        url: "?id="+pageId+"&tx_pitselearn_pitselearn[action]=detail&tx_pitselearn_pitselearn[controller]=Elearning&tx_pitselearn_pitselearn[submit]=submit&tx_pitselearn_pitselearn[type]="+type+"&no_cache=1"+"&L="+sysLangUid,
        data: formData,
        success: function (Response) {
            obj = JSON.parse( Response );
       
            if(obj['proceed_next'] == 1 ){
                //location.reload(true);
                window.location.reload(true);
                $('#show_sol').attr( 'disabled' );
                return ;
            }
            if(obj['previousQuest'] == 1 ){
                //location.reload(true);
                window.location.reload(true);
                $('#show_sol').attr( 'disabled' );
                return ;
            }
			
            if( obj['ansStatus'] == 1 &&  obj['errortext'] == '' ) {
                $('.right_img').show();
                $('.wrong_img').hide();
                $('#error_text').html('');
                $('.ask_again').hide();
                $('.proceed_next').show();
                $('#show_sol').removeAttr("disabled");
                $( '#show_sol' ).css( "background", "#A10631" );
                $( '#show_sol' ).css( "color", "#FFFFFF" );
            }else if ( obj['ansStatus'] == 0 &&  obj['errortext'] == '' ) {
                $('.wrong_img').show();
                $('.right_img').hide();
                $('#error_text').html('');
                $('#show_sol').removeAttr("disabled");
                $('.ask_again input').val("Antwort nochmals prüfen");
                $('.ask_again').show();
                $('.proceed_next').hide();
                $( '#show_sol' ).css( "background", "#A10631" );
                $( '#show_sol' ).css( "color", "#FFFFFF" );
            }else {
                $('#error_text').html(obj['errortext']);
                $('.wrong_img').hide();
                $('.right_img').hide();
                $('#show_sol').attr( 'disabled' );
                $('.ask_again').show();
                $('.proceed_next').hide();
            }
        }
    });
	
}

function doShowAnswer(pageId,qId, qtype){
    $.ajax({
        type: "GET",
        cache: false,
        url: "?id="+pageId+"&tx_pitselearn_pitselearn[action]=showResult&tx_pitselearn_pitselearn[controller]=Elearning&tx_pitselearn_pitselearn[qType]="+qtype+"&tx_pitselearn_pitselearn[qId]="+qId+"&L="+sysLangUid,
        success: function (data) {
    		$('#show_sol').hide();
            if(qtype == 'dragdrop'){
                obj = JSON.parse( data );
                $.each(obj,function(index,value){
                    var uid = value.uid;
                    var imageName = value.dragdrop_answer_img ;
                    var image = "<img width='290' height= '160'src='"+imageName+"'>";
                    $( "table" ).find( "#dropSecond_"+value.uid ).html(image);
                     $("#dropSecond_"+value.uid).removeClass( "empty_container" ).addClass( "only" );
                    $('.green-box').show();

                });
            }else if(qtype == 'freetext'){
                $('.qsolution').html(data);
                $('.title-ans').show();
                $('.qsolution').show();
            }
        }
    })
}

// Added by Arun on 18-11-2013
function repeatQuestionaire( pageId, sysLangUid )  {
	var formVal = $("#questionsFormlast").serialize();


        //added by abin on 19-nov
  var chapterVal = $("#id-chapters_div").find("select").val();
  if(chapterVal != 0 ){
	$.ajax({
        type: "GET",
        cache: false,
        url: "?id="+pageId+"&tx_pitselearn_pitselearn[action]=resultRender&tx_pitselearn_pitselearn[controller]=Elearning&tx_pitselearn_pitselearn[submit]=submit"+"&L="+sysLangUid,
        data: formVal,
        success: function (data) {
        	 window.location.reload(data);
             return ;
        }
	});
        }
} 