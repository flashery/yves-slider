/*
 *A slider plugin
 *Written by Yves Gonzaga
 */

var imgURL  = '';
var arrayURL = jQuery('#yves-slider').find('img');

jQuery(function() {
	init();
	hoverIMG();
	hoverLI();
	clickLI();
    setInterval( "slideSwitch()", 5000 );
});

function init(){
	jQuery('#nav-slider li.inactive').css({
		opacity: 0.5
	});
	jQuery('#nav-slider').css({
		opacity: 0.0
	});
}

function slideSwitch() {
	
    /*
    var jQueryactive = jQuery('#yves-slider img.active');

    jQueryactive.length == 0 ? jQueryactive = jQuery('#yves-slider img:last') : null;

    var jQuerynext =  jQueryactive.next().length ? jQueryactive.next() : jQuery('#yves-slider img:first');//Checking if images is more than 1

    //jQueryactive.addClass('last-active');
jQuerynext.css({opacity: 0.0})
        .addClass('active')
		.stop()
        .animate({opacity: 1.0}, 800, function() {
            jQueryactive.removeClass('active last-active');
    });*/
	
	var jQueryactive = jQuery('#yves-slider img.active');
	
	jQueryactive.length == 0 ? jQueryactive = jQuery('#yves-slider img:last') : null;
	
	var jQuerynext =  jQueryactive.next().length ? jQueryactive.next() : jQuery('#yves-slider img:first');
		
	jQuerynext.slideDown('slow', function(){
		jQuerynext.addClass('active')
		jQueryactive.removeClass('active last-active');
	});
	//$(this).hide("slide", { direction: "down" }, 1000);
}

function hoverIMG(){
		jQuery('#yves-slider').hover(
		
		function(){ //First function in hover effect
			jQuery('#nav-slider')
			.stop()
			.animate({opacity: 1}, 'fast');
		
	}, function(){	//Another function inside hover effect
			jQuery('#nav-slider')
			.stop()
			.animate({opacity: 0.0}, 'slow');
	});
}

function hoverLI(){
		jQuery('#nav-slider li').hover(
		
		function(){ //First function in hover effect
		
		if(jQuery(this).hasClass("inactive")){
			jQuery(this)
			.stop()
			.animate({opacity: 1}, 'fast');
			
			jQuery(this).css({background: '#FF9'}, 'fast');
		}
		
	}, function(){	//Another function inside hover effect

		if(jQuery(this).hasClass("inactive")){
			jQuery(this)
			.stop()
			.animate({opacity: 0.5}, 'slow');
		}
		jQuery(this).css({background: '#073242'}, 'slow');
	});
}

function clickLI(url){
	
	var jQueryIMGactive = jQuery('#yves-slider img.active');
	
	jQuery('#nav-slider li').click(function(){ 	//Getting where the event is occuring
		if(jQuery(this).hasClass("inactive")){ 	//Check if class of the LI that is being clicked is inactive
			jQuery('#nav-slider li.active').stop().animate({opacity: 0.5}, 'slow'); //Set the active class opacity to 0.5
			jQuery('#nav-slider li.active').removeClass('active').addClass("inactive");//Then change its class into inactive
			jQuery(this).removeClass('inactive').addClass('active'); //The LI that's being clicked will change the class to active
		}
	});
	jQuery('#nav-slider li').click(function(){ 	//Getting where the event is occuring
		if(jQuery('#yves-slider img').hasClass("inactive")){ 	//Check if class of the LI that is being clicked is inactive
			jQuery('#nav-slider li.active').stop().animate({opacity: 0.5}, 'slow'); //Set the active class opacity to 0.5
			jQuery('#nav-slider li.active').removeClass('active').addClass("inactive");//Then change its class into inactive
			jQuery(this).removeClass('inactive').addClass('active'); //The LI that's being clicked will change the class to active
		}
	});
	
}
