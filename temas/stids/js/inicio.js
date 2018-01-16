$(document).ready(function(e) {
	$('#header_outer').scrollToFixed();
	$('.res-nav_click').click(function(){
		$('.main-nav').slideToggle();
		return false    	
	});
});

wow = new WOW({
	animateClass: 'animated',
	offset:       100
});

wow.init();

$(window).load(function(){
	
	$('a').bind('click',function(event){
		var $anchor = $(this);
		
		$('html, body').stop().animate({
			scrollTop: $($anchor.attr('href')).offset().top - 91
		}, 1500,'easeInOutExpo');
		event.preventDefault();
	});
})

	jQuery(document).ready(function($){     
	// Portfolio Isotope
	var container = $('#portfolio-wrap');	


	container.isotope({
		animationEngine : 'best-available',
		animationOptions: {
			duration: 200,
			queue: false
		},
		layoutMode: 'fitRows'
	});	

	$('#filters a').click(function(){
		$('#filters a').removeClass('active');
		$(this).addClass('active');
		var selector = $(this).attr('data-filter');
		container.isotope({ filter: selector });
		setProjects();		
		return false;
	});
	
	
	function splitColumns() { 
		var winWidth = $(window).width(), 
			columnNumb = 1;			
		
		if (winWidth > 1024) {
			columnNumb = 4;
		} else if (winWidth > 900) {
			columnNumb = 2;
		} else if (winWidth > 479) {
			columnNumb = 2;
		} else if (winWidth < 479) {
			columnNumb = 1;
		}
		
		return columnNumb;
	}		
	
	function setColumns() { 
		var winWidth = $(window).width(), 
			columnNumb = splitColumns(), 
			postWidth = Math.floor(winWidth / columnNumb);
		
		container.find('.portfolio-item').each(function () { 
			$(this).css( { 
				width : postWidth + 'px' 
			});
		});
	}		
	
	function setProjects() { 
		setColumns();
		container.isotope('reLayout');
	}		
	
	container.imagesLoaded(function () { 
		setColumns();
	});
	

	$(window).bind('resize', function () { 
		setProjects();			
	});

});

$( window ).load(function() {
	jQuery('#all').click();
	return false;
});