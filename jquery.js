// JavaScript Document

$(document).ready(function() {
	if(!$.browser.msie) { //Makes it so the following nav scroll effect won't work on IE browsers
		$(window).scroll(function() {
			var scrollTop = $(window).scrollTop();
			
			if(scrollTop >= 40) {
				$('.nav_bar').addClass('nav_bar_fixed');
				//$('.nav_bar_space').css("display", "block");
			}
			else if(scrollTop < 40) {
				$('.nav_bar').removeClass('nav_bar_fixed');
				//$('.nav_bar_space').css("display", "none");
			}
		});

		$(window).scroll(function() {
			var scrollTop = $(window).scrollTop();
			if(scrollTop >= 140) {
				$('.nav_bar').css("height", "50px");
				$('.nav_button').css("height", "50px");
				$('.nav_button').css("line-height", "50px");
				$('#logo').css("background-size", "112px 50px");
				$('#logo').css("width", "112px");
				$('#logo').css("height", "50px");
				$('#button_section').css("padding-left", "160px");
			}
			else if(scrollTop < 140) {
				$('.nav_bar').css("height", "100px");
				$('.nav_button').css("height", "100px");
				$('.nav_button').css("line-height", "100px");
				$('#logo').css("background-size", "225px 100px");
				$('#logo').css("width", "225px");
				$('#logo').css("height", "100px");
				$('#button_section').css("padding-left", "280px");
			}
		}); 
	}
});