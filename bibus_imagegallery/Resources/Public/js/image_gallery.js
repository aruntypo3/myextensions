$( document ).ready(function() {
	$("div.innerGallery").removeClass("initGallery");
    $("div.smallGallery").slideView();
	$(".smallGallery ul li a").lightBox({
    	imageLoading: "typo3conf/ext/bibus_imagegallery/Resources/Public/Icons/lightbox-ico-loading.gif",
    	imageBtnPrev: "typo3conf/ext/bibus_imagegallery/Resources/Public/Icons/lightbox-btn-prev.gif",
    	imageBtnNext: "typo3conf/ext/bibus_imagegallery/Resources/Public/Icons/lightbox-btn-next.gif",
    	imageBtnClose: "typo3conf/ext/bibus_imagegallery/Resources/Public/Icons/lightbox-btn-close.gif",
    	imageBlank: "typo3conf/ext/bibus_imagegallery/Resources/Public/Icons/lightbox-blank.gif"
	});
});