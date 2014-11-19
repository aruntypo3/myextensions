function dbEntry( uid, pageId, title, image, ip_address, syslangUid){
    $.ajax({
	type: "POST",
	url: "?id="+pageId+"&tx_pitsbannerimages_pitsbannerimages[action]=show&tx_pitsbannerimages_pitsbannerimages[controller]=Bannermanagement&tx_pitsbannerimages_pitsbannerimages[title]="+title+"&tx_pitsbannerimages_pitsbannerimages[image]="+image+"&tx_pitsbannerimages_pitsbannerimages[ip_address]="+ip_address+"&tx_pitsbannerimages_pitsbannerimages[image_id]="+uid+"&L="+syslangUid,
	});
}