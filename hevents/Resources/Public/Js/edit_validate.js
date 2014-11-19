function validateForm() {
	var status = true;
	
	// Product Form Validation
	var elementID = new Array("email", "name", "forename", "adress", "zip", "city", "country");
	var elementerrorID = new Array("email_span", "name_span", "forename_span", "address_span", "zip_span", "city_span", "country_span");
	for (i=0;i<elementID.length;i++){
		if(document.getElementById(elementID[i]).type == "text"){
			if(document.getElementById(elementID[i]).value == ""){
				var spanElement = document.getElementById(elementerrorID[i]);
				var spanID = spanElement.id.split("_");
				document.getElementById(spanID[0]+'_div').style.display="block";
				status = false;
			}else{
				var spanElement = document.getElementById(elementerrorID[i]);
				var spanID = spanElement.id.split("_");
				document.getElementById(spanID[0]+'_div').style.display="none";
			}
		}
	}
	
	// Email Validation
	if(document.getElementById('email').value != ""){
		var emailid = document.getElementById('email').value;
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(!emailid.match(mailformat)){
			var spanElement = document.getElementById('email_span');
			var spanID = spanElement.id.split("_");
			document.getElementById(spanID[0]+'_div').style.display="block";
			status = false;
		}else{
			var spanElement = document.getElementById('email_span');
			var spanID = spanElement.id.split("_");
			document.getElementById(spanID[0]+'_div').style.display="none";
		}
	}
	
	return status;
}	
	