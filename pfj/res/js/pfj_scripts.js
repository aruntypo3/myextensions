
$(document).ready(function(){ 
   /*$('#orderTable').dataTable( {
        "aaSorting": [[ 4, "desc" ]]
    } );*/
    // Add to Cart
    $(".addtocart img").click(function() {
        var productIDValSplitter = (this.id).split("_");
        var productIDVal = productIDValSplitter[1];
        $.ajax({
            type: "POST",
            url: "http://pfj.com.au/?eID=makeProducts",
            data: {
                productID: productIDVal,
                action: "addToBasket"
            },
            success: function(Response){
                $('#item_count').html(Response);
                $.jGrowl(Response+' Item(s) added to the cart', {
                    life: 1500
                });
            }
        });
    });

    // Delete each item seperately
    $(".remove_item").click(function() {
        var itemIDValSplitter = (this.id).split("_");
        var itemIDVal = itemIDValSplitter[1];
        $('#table_'+itemIDVal).fadeOut();
        var sum = 0;
        var i = 0;
        $("#ajax_loader").show();
        $.ajax({
            type: "POST",
            url: "http://pfj.com.au/?eID=makeProducts",
            data: {
                itemID: itemIDVal,
                action: "deleteFromBasket"
            },
            success: function(Response){
                obj = JSON.parse(Response);
                $('#item_count').html(obj['itemCount']);
                $('.total_price').html(obj['totalPrice']);
                $("#ajax_loader").hide();
                $('.carttable').each( function(index, value) {
                    if ($(this).is(':visible') == true) {
                        i = i + 1;
                    };
                });
                if (i <= 0) {
                    $('.totalpricerow').fadeOut();
                    $('.cart_buttons').fadeOut();
                    $('.no_cartitems').show();
                }
            }
        });
    });

    // On change price updation
    $( ".quantity" ).keyup(function() {
        var productIdSplitter = ($(this).attr('id')).split("_");
        var productId = productIdSplitter[1];
        var price = $('#priceVal_'+productId).val();
        var intPrice = price.replace(/[^\d\.]/g, '');
        var quantity = $(this).val();
        var totalPrice = quantity * intPrice ;
        $('#price_'+productId).html("$"+totalPrice.toFixed( 2 ));
        var formValue = $('#cartsubmitform').serialize();
        $.ajax({
            type: "POST",
            url: "http://pfj.com.au/?eID=makeProducts&action=qtyChange",
            data: formValue,
            success: function(Response){
                $('.total_price').html(Response);
            }
        });
    });

    // Clear All
    $('#clearall').click(function() {
        $('.carttable').fadeOut();
        $('.totalpricerow').fadeOut();
        $('.cart_buttons').fadeOut();
        $('.no_cartitems').show();
        $("#ajax_loader").show();
        $.ajax({
            type: "POST",
            url: "http://pfj.com.au/?eID=makeProducts",
            data: {
                action: "clearAll"
            },
            success: function(Response){
                $('#item_count').html(Response);
                $("#ajax_loader").hide();
            }
        });
    });

    // Checkout
    $('#checkout').click(function() {
        $("#ajax_loader").show();
        $('#cartsubmitform').fadeOut();
        $.ajax({
            type: "POST",
            url: "http://pfj.com.au/?eID=makeProducts",
            data: {
                action: "checkOut"
            },
            success: function(Response){
                $('#cart_preview').html(Response);
                $("#cart_preview").show();
                $('#commentbox').show()
                $("#ajax_loader").hide();
            }
        });
    });

    $("#backto_cart").live("click", function(){
        $('#commentbox').hide()
        $("#cart_preview").hide();
        $("#cartsubmitform").show();

    });

    $("#orderItems").live("click", function(){
        $("#ajax_loader").show();
        $('#cart_preview').fadeOut();
        var commentData = $("#comment").val();
        $("#commentbox").hide();     
        $.ajax({
            type: "POST",
            url: "http://pfj.com.au/?eID=makeProducts",
            data: {
                action: "placeOrder",
                comment:commentData
            },
            success: function(Response){
                obj = JSON.parse(Response);
                $('#order_placed').html(obj[0]);
                $('#item_count').html(obj[1]);
                $("#ajax_loader").hide();
                $("#commentbox").hide();
                $('#order_placed').show();
            }
        });
    });

    initialize();
});

//GoogleMap Function
var geocoder;
var map;
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-37.934, 145.037);
    var mapOptions = {
        zoom: 7,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    codeAddress();
}

function codeAddress() {
    var address = $('#address_block').text();
    geocoder.geocode( {
        'address': address
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
            });
      
            var infowindow = new google.maps.InfoWindow({
                content: address,
                maxWidth: 150
            });
            infowindow.open(map,marker);
    
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}
function textLimit(field, maxlen) {
 //document.getElementById('counter').innerHTML = counter ;
    if (field.value.length >=maxlen){
        document.getElementById('max_error').innerHTML = 'Character Limit Reached!';
        if (field.value.length >= maxlen)
            field.value = field.value.substring(0, maxlen);
    }else{
        //counter = field.value.length+'/'+maxlen
        document.getElementById('max_error').innerHTML = '';
        //document.getElementById('counter').innerHTML = counter ;
    }
}
function getOrderDetails(dateValue,obj) {

      $("#orderView_"+dateValue).toggle( "slow", function() { 
             if(obj.className =='orderLink'){
                  $(obj).addClass('active');
                  $('#arrow_img_'+dateValue).attr('src','typo3conf/ext/pfj/res/images/down.png');
                }else{
                  $(obj).attr('class','orderLink');
                  $('#arrow_img_'+dateValue).attr('src','typo3conf/ext/pfj/res/images/right.png');              
                }
      });
}
google.maps.event.addDomListener(window, 'load', initialize);
