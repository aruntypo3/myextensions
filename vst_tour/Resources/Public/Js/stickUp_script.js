// page init
jQuery(function(){
	initStickyNavigation();
	initStickyNavigationClass();
});

//sticky menu
function initStickyNavigation() {
	jQuery(function($) {
		$(document).ready( function() {
		  $('.sub-navigation').stickUp();
		});
	});
}

//Active Class
function initStickyNavigationClass() {
	$(".tx-vst-tour .list-unstyled li a").click(function() {
		$(this).parent().addClass('active').siblings().removeClass('active');
		var activeVal = $(this).parent().parent().find('li:first a').text();
		var activeValLink = $(this).parent().parent().find('li:first a').attr('href');
		$(".tx-vst-tour .mobileMenu a.activateMenu").text(activeVal);
		$(".tx-vst-tour .mobileMenu a.activateMenu").attr('href', activeValLink);
    });
}