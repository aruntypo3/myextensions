function validateForm() {
	var status = true;
	
	// Product Form Validation
	var elementID = new Array("user_name", "user_firstname");
	var elementerrorID = new Array("username_error", "userfirstname_error");
	for (i=0;i<elementID.length;i++){
		document.getElementById(elementerrorID[i]).innerHTML = '';
		if(document.getElementById(elementID[i]).type == "text"){
			if(document.getElementById(elementID[i]).value == ""){
				document.getElementById(elementerrorID[i]).innerHTML = errorText;
				status = false;
			}else{
				document.getElementById(elementerrorID[i]).innerHTML = '';
			}
		}
	}
	// Radio Button Validation for Price
	var radio_buttons = document.getElementsByName('tx_tntblumenshop_tntblumenshop[price]');
	var checked = false;
	for(var i=0; i<radio_buttons.length; i++) {
		document.getElementById("price_error").innerHTML = '';
		if (radio_buttons[i].checked == true) {
			checked = true;
		}
		if ((radio_buttons[i].value == '') && (radio_buttons[i].checked == true)){
			document.getElementById("price_error").innerHTML = priceerrorText;
			checked = false;
		}else {
			document.getElementById("price_error").innerHTML = '';
		}
	}
	if( !checked ){
		document.getElementById("price_error").innerHTML = priceerrorText;
		status = false;
	}
	
	//Radio Button Validation for Price Extra
	var radio_priceextra = document.getElementsByName('tx_tntblumenshop_tntblumenshop[priceextra]');
	var checked_extra = false;
	for(var i=0; i<radio_priceextra.length; i++) {
		document.getElementById("priceextra_error").innerHTML = '';
		if (radio_priceextra[i].checked == true) {
			checked_extra = true;
		}
		if ((radio_priceextra[i].value == '') && (radio_priceextra[i].checked == true)){
			document.getElementById("priceextra_error").innerHTML = price_extraerrorText;
			checked_extra = false;
		}else {
			document.getElementById("priceextra_error").innerHTML = '';
		}
	}
	if( !checked_extra ){
		document.getElementById("priceextra_error").innerHTML = price_extraerrorText;
		status = false;
	}
	return status;
}


// Contact Form Validation
function validatecontactForm(){
	var flag = true;
	var contactformID = new Array("contact_name", "contact_firstname", "contact_strasse", "contact_telefon", "contact_email");
	var contactformerrorID = new Array("contact_name_error", "contact_firstname_error", "contact_strasse_error","contact_telefon_error", "contact_email_error");
	for (i=0;i<contactformID.length;i++){
		document.getElementById(contactformerrorID[i]).innerHTML = '';
		if(document.getElementById(contactformID[i]).type == "text"){
			if(document.getElementById(contactformID[i]).value == ""){
				doSetDisplayBlock(document.getElementById(contactformID[i]).id); 
				document.getElementById(contactformerrorID[i]).innerHTML = errorText;
				flag = false;
			}else{
				document.getElementById(contactformerrorID[i]).innerHTML = '';
			}
		}
	}
	
	// Validation for PLZ / Ort field
	if((document.getElementById('contact_ort1').value == "") || (document.getElementById('contact_ort2').value == "")){
		document.getElementById('contact_ort_error').innerHTML = errorText;
		doSetDisplayBlock( 'contact_ort' ); 
		flag = false;
	}else{
		document.getElementById('contact_ort_error').innerHTML = '';
	}
	
	
	// Selectbox Validation
	if(document.getElementById('paymentOptions').selectedIndex == "0"){
		document.getElementById('payment_method_error').innerHTML = selectboxError;
		doSetDisplayBlock( 'payment_method' ); 
		flag = false;
	}else{
		document.getElementById('payment_method_error').innerHTML = '';
	}
	
	
	// Email Validation
	if(document.getElementById('contact_email').value != ""){
		var emailid = document.getElementById('contact_email').value;
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(!emailid.match(mailformat)){
			document.getElementById('contact_email_error').innerHTML = invalidEmail;
			doSetDisplayBlock( 'contact_email' );
			flag = false;
		}else{
			document.getElementById('contact_email_error').innerHTML = '';
		}
	}
	
	// Phone number Validation
	if(document.getElementById('contact_telefon').value != ""){
		var telephoneNum = document.getElementById('contact_telefon').value;
		var phoneformat = /^[+ 0-9 ]+$/;
		if(!telephoneNum.match(phoneformat)){
			document.getElementById('contact_telefon_error').innerHTML = invalidPhone;
			doSetDisplayBlock( 'contact_telefon' );
			flag = false;
		}else{
			document.getElementById('contact_telefon_error').innerHTML = '';
		}
	}
	
	// Mobile number validation
	if(document.getElementById('contact_mobile').value != ""){
		var mobileNum = document.getElementById('contact_mobile').value;
		var phoneformat = /^[+ 0-9 ]+$/;
		if(!mobileNum.match(phoneformat)){
			document.getElementById('contact_mobile_error').innerHTML = invalidPhone;
			doSetDisplayBlock( 'contact_mobile' );
			flag = false;
		}else{
			document.getElementById('contact_mobile_error').innerHTML = '';
		}
	}
	
	return flag;
}

function doSetDisplayBlock(id) {
	document.getElementById(id+'_error').style.display = "block";
}

function charLimit(maxChar ,event ) {
		setTimeout(function() {
			charLimit( 119, event );
        }, 10);
		if (document.getElementById('text_cart').value.length > maxChar  ){
			 	val = document.getElementById('text_cart').value;
			 	val = val.substr(0,119);
				document.getElementById('text_cart').value = val;
				return false;
			}
	}

function docharLimit(maxChar,event) {
	 if( (event.keyCode == '8') || (event.keyCode == '46') ||   event.keyCode == '65' ||   event.keyCode == '67' ||   event.keyCode == '88' ||   event.keyCode == '86'   ||   event.keyCode == '17'   ){
			return true;
		}
	 if ( event.keyCode != '17' &&  event.keyCode != '65'  && event.keyCode != '13' && (event.keyCode != '37')  &&   (event.keyCode != '38')  &&   (event.keyCode != '39')  &&   (event.keyCode != '40')) {
		 val = document.getElementById('text_cart').value;
		 val = val.replace(/ +(?= )/g,'');
		 document.getElementById('text_cart').value = val;
	 }
	
	if (document.getElementById('text_cart').value.length > maxChar && (event.keyCode != '8') &&   (event.keyCode != '46')    ){
		 	val = document.getElementById('text_cart').value;
		 	val = val.substr(0,119);
			document.getElementById('text_cart').value = val;
			return false;
		}
	
	
}
