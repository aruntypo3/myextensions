function validateForm() {
	var status = true;
	
	// Product Form Validation
	var elementID = new Array("amount", "email", "name", "forename", "adress", "zip", "city", "country");
	var elementerrorID = new Array("amount_span", "email_span", "name_span", "forename_span", "address_span", "zip_span", "city_span", "country_span");
	for (i=0;i<elementID.length;i++){
		if(document.getElementById(elementID[i]).type == "text" || document.getElementById(elementID[i]).type == "select-one" ){
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
	
	// Amount Validation
	var amountValue = document.getElementById('amount').value;
	var availSeats = document.getElementById('remainSeats').value;
	
	if( parseInt(amountValue) > parseInt(availSeats) ){
		var spanElement = document.getElementById('amountexceed_span');
		var spanID = spanElement.id.split("_");
		document.getElementById(spanID[0]+'_div').style.display="block";
		status = false;
	}else{
		var spanElement = document.getElementById('amountexceed_span');
		var spanID = spanElement.id.split("_");
		document.getElementById(spanID[0]+'_div').style.display="none";
	}
	
	// Amount Empty Check
	if( parseInt(amountValue) == 0 ){
		var spanElement = document.getElementById('amountempty_span');
		var spanID = spanElement.id.split("_");
		document.getElementById(spanID[0]+'_div').style.display="block";
		status = false;
	}else{
		var spanElement = document.getElementById('amountempty_span');
		var spanID = spanElement.id.split("_");
		document.getElementById(spanID[0]+'_div').style.display="none";
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
	
	var deliverAddress = document.getElementById('deliverAddressSection').value;
	if( deliverAddress == 1 ){
		// Product Form Validation
		document.getElementById('deliverErrorBlock').style.display="block";
		var delementID = new Array("dname", "dforename", "daddress", "dzip", "dcity", "dcountry");
		var delementerrorID = new Array("dname_span", "dforename_span", "daddress_span", "dzip_span", "dcity_span", "dcountry_span");
		for (i=0;i<delementID.length;i++){
			if(document.getElementById(delementID[i]).type == "text" || document.getElementById(delementID[i]).type == "select-one" ){
				if(document.getElementById(delementID[i]).value == ""){
					var spanElement = document.getElementById(delementerrorID[i]);
					var spanID = spanElement.id.split("_");
					document.getElementById(spanID[0]+'_div').style.display="block";
					status = false;
				}else{
					var spanElement = document.getElementById(delementerrorID[i]);
					var spanID = spanElement.id.split("_");
					document.getElementById(spanID[0]+'_div').style.display="none";
				}
			}
		}
	}else{
		document.getElementById('deliverErrorBlock').style.display="none";
	}
	
	return status;
}	
	