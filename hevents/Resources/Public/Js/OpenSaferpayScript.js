function OpenSaferpayTerminal(url, obj, mode) {
	switch (mode) {
		case 'LINK':
			obj.href = "javascript:void(0);";
			window.location = (url += '&osfps=link');
			return false;
		case 'FORM':
			window.location = (url += '&osfps=form');
			break;
		case 'BUTTON':
			window.location = (url += '&osfps=button');
			break;
	}
}

function OpenSaferpayWindowJScript(strUrl) {
	window.location = (strUrl += '&osfps=windowjs');
}

function OpenSaferpaySameJScript(strUrl) {
	window.location = (strUrl += '&osfps=samejs');
}
