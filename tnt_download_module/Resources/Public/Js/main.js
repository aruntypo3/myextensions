/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var sortQuery = '';
var order = 0;
var sortObj = '';
$(document).ready(function() {

    //selction trigger

    var getDocumnet = 0;

    //doGetValue();
    //load(1);
    $("#thema_selector").change(function() {
        getDocumnet = 0;
        $("body").find("#thema_subcat").val('');
        doGetValue();
    });
    /*$('#thema_subcat').live('change', function() {
        getDocumnet = 1;
        doGetValue();
    });*/
    $("#filter_text").keyup(function() {
        getDocumnet = 1;
        doGetValue();
    });

    function doGetValue() {
        pageId = $('#page_id').val();
        pageLanguage = $('#page_lang').val();
        themaValue = $("#thema_selector").val();
        themaSubCat = $("#thema_subcat").val();
        if (themaSubCat === undefined) {
            themaSubCat = '';

        }

        filterText = $("#filter_text").val();
        if (themaValue.length > 0 || filterText.length > 0) {
            if (getDocumnet == 0) {
                $.ajax({
                    type: "GET",
                    url: "?id=" + pageId + "&L=" + pageLanguage + "&tx_tntdownloadmodule_tntdownloadmodule[type]=1&tx_tntdownloadmodule_tntdownloadmodule[action]=show&tx_tntdownloadmodule_tntdownloadmodule[controller]=DownloadModule&tx_tntdownloadmodule_tntdownloadmodule[cat_id]=" + themaValue,
                    success: function(data) {
                        $('#step2').html(data);
                    }
                });
            }
            load(1);

        } else {
            load(1);
            $('#step2').html('');
        }
    }

});
function load(page) {
    $('.ajaxLoadingIndicator').show();
    pageLanguage = $('#page_lang').val();
    pageId = $('#page_id').val();
    themaValue = $("#thema_selector").val();
    themaSubCat = $("#thema_subcat").val();

    if (themaSubCat === undefined) {
        themaSubCat = '';

    }
    filterText = $("#filter_text").val();
            ajaxLink = "?id=" + pageId + "&L=" + pageLanguage + "&tx_tntdownloadmodule_tntdownloadmodule[sort]=" + sortQuery + "&tx_tntdownloadmodule_tntdownloadmodule[currentPage]=" + page + "&tx_tntdownloadmodule_tntdownloadmodule[type]=2&tx_tntdownloadmodule_tntdownloadmodule[action]=show&tx_tntdownloadmodule_tntdownloadmodule[controller]=DownloadModule&tx_tntdownloadmodule_tntdownloadmodule[cat_id]=" + themaValue + "&tx_tntdownloadmodule_tntdownloadmodule[subcat_id]=" + themaSubCat + "&tx_tntdownloadmodule_tntdownloadmodule[filterText]=" + filterText,
            //permaLink = "?id=" + pageId + "&L=" + pageLanguage + "&tx_tntdownloadmodule_tntdownloadmodule[sort]=" + sortQuery + "&tx_tntdownloadmodule_tntdownloadmodule[currentPage]=" + page + "&tx_tntdownloadmodule_tntdownloadmodule[action]=permalink&tx_tntdownloadmodule_tntdownloadmodule[controller]=DownloadModule&tx_tntdownloadmodule_tntdownloadmodule[cat_id]=" + themaValue + "&tx_tntdownloadmodule_tntdownloadmodule[subcat_id]=" + themaSubCat + "&tx_tntdownloadmodule_tntdownloadmodule[filterText]=" + filterText,
            $.ajax({
                type: "GET",
                url: ajaxLink,
                success: function(data) {
                    $('.ajaxLoadingIndicator').hide();
                    $('#documnets').html(data);
                    $('#permaLink').attr('href', $('body').find('#permalink').val());
                    $('body').find('#'+sortObj.id).removeClass('no_sort').addClass('')
                    if (order == 0) {
                        $('body').find('#'+sortObj.id).removeClass('sort_down').addClass('sort_up')
                        
                    } else {
                        $('body').find('#'+sortObj.id).removeClass('sort_up').addClass('sort_down')
                    }
                }
            });
}

function resetData(type) {

    if (type == 1) {

        $("body").find("#step2").html('');
        $("body").find("#documnets").html('');
        $("body").find("#thema_selector").attr('selectedIndex', 0);


    } else {

        $("body").find("#filter_text").val('');
        load(1);
    }

}
function sortData(field, obj) {
    page = 1;
    if (order == 0) {
        sortOrder = 'ASC'
        order = 1;
    } else {
        sortOrder = 'DESC'
        order = 0;
    }
    sortQuery = field + ' ' + sortOrder;
    sortObj = obj;
    load(1);

}  