// Form Validation
function validateForm(){
	var flag = true;
	var formID = new Array("job_title", "contact_name", "email", "address", "zipcode", "ort");
	var formerrorID = new Array("job_title_error", "contact_name_error", "email_error", "address_error", "zipcode_error", "ort_error");
	for (i=0;i<formID.length;i++){
		document.getElementById(formerrorID[i]).innerHTML = '';
		if(document.getElementById(formID[i]).type == "text"){
			if(document.getElementById(formID[i]).value == ""){
				doSetDisplayBlock(document.getElementById(formID[i]).id); 
				document.getElementById(formerrorID[i]).innerHTML = errorText;
				flag = false;
			}else{
				document.getElementById(formerrorID[i]).innerHTML = '';
			}
		}
	}

	// Selectbox Validation
	if(document.getElementById('select_category').selectedIndex == "0"){
	   document.getElementById('category_error').innerHTML = selectboxError;
		doSetDisplayBlock( 'category' ); 
		flag = false;
	}else{
		document.getElementById('category_error').innerHTML = '';
	}
	
	// Shorttext Validation
	if(document.getElementById('short_text').value == ""){
	   document.getElementById('short_text_error').innerHTML = errorText;
		doSetDisplayBlock( 'short_text' ); 
		flag = false;
	}else{
		document.getElementById('short_text_error').innerHTML = '';
	}
	
	
	// Email Validation
	if(document.getElementById('email').value != ""){
		var emailid = document.getElementById('email').value;
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(!emailid.match(mailformat)){
			document.getElementById('email_error').innerHTML = invalidEmail;
			doSetDisplayBlock( 'email' );
			flag = false;
		}else{
			document.getElementById('email_error').innerHTML = '';
		}
	}

	// Phone number Validation
	if(document.getElementById('telephone').value != ""){
		var telephoneNum = document.getElementById('telephone').value;
		var phoneformat = /^[+ 0-9 ]+$/;
		if(!telephoneNum.match(phoneformat)){
			document.getElementById('telephone_error').innerHTML = invalidPhone;
			doSetDisplayBlock( 'telephone' );
			flag = false;
		}else{
			document.getElementById('telephone_error').innerHTML = '';
		}
	}
	
	// Checkbox Validation
	if(document.getElementById("agree_terms").checked == false){
	   document.getElementById('agree_terms_error').innerHTML = agree_terms_error;
	   doSetDisplayBlock( 'agree_terms' ); 
	   flag = false;
	}else{
	   document.getElementById('agree_terms_error').innerHTML = '';
	}
	
	
	return flag;
}

function doSetDisplayBlock(id) {
	document.getElementById(id+'_error').style.display = "block";
}

function charLimit(maxChar ,event ) {
		setTimeout(function() {
			charLimit( 600, event );
        }, 10);
		if (document.getElementById('short_text').value.length > maxChar  ){
			 	val = document.getElementById('short_text').value;
			 	val = val.substr(0,600);
				document.getElementById('short_text').value = val;
				return false;
			}
	}

function docharLimit(maxChar,event) {
	 if( (event.keyCode == '8') || (event.keyCode == '46') ||   event.keyCode == '65' ||   event.keyCode == '67' ||   event.keyCode == '88' ||   event.keyCode == '86'   ||   event.keyCode == '17'   ){
			return true;
		}
	 if ( event.keyCode != '17' &&  event.keyCode != '65'  && event.keyCode != '13' && (event.keyCode != '37')  &&   (event.keyCode != '38')  &&   (event.keyCode != '39')  &&   (event.keyCode != '40')) {
		 val = document.getElementById('short_text').value;
		 val = val.replace(/ +(?= )/g,'');
		 document.getElementById('short_text').value = val;
	 }
	
	if (document.getElementById('short_text').value.length > maxChar && (event.keyCode != '8') &&   (event.keyCode != '46')    ){
		 	val = document.getElementById('short_text').value;
		 	val = val.substr(0,600);
			document.getElementById('short_text').value = val;
			return false;
		}
}