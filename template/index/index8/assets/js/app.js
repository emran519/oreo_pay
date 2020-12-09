var Marco = {
	// Declarer DOM variables here
	dom   : {
		_window 			: $(window) ,
		pageParent 		: $('html, body'), 
		btnNav  			: $('#btn-nav'),
		siteNav  		: $('#site-nav'),
		heroSlider 		: $('#hero-slider'),
		fullSlider 		: $('#full-slider'),
		isDropDown 		: $('.is-dropdown'),
		pageParent 		: $('html, body'), 
		preLoader 		: $('#loading'),
		funinfoSec 		: $('.section-funinfo'),
		progressBars 	: $('#progress-bars'),
		mapId 			: $('#site-map'),
	},
	// Global Variable
	vars  : {
		isDevice 		: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
		isMobileView 	: ( $(window).width() <= 530 )? true : false,
		isTabletView 	: ( $(window).width() <= 768 )? true : false,
	},
	// Initialize all JS function and Plug Ins
	init : function(){
		// Global Object  _this return the parent object DentalCare
		_this = this ;
		// Show the loading page 
		_this.showPreloader();
	  	// Initialize WOW Plug in
		_this.wowInit() ;

		// Wait until all images are loaded 
		_this.dom.pageParent.imagesLoaded(function(){
			// Hide the preloader page
		  	_this.hidePreloader() ;
			// Call all funtions events
			_this.events() ;
			// Function to center content in Home Slider
			_this.homeSlide();
			// Initialize all swiper sliders
			_this.swiperSliders();
			// Function to make all images in slider responsive
			_this.homeSlideImages();
			// Initialize Isotop to filter portfolio items
			_this.homePortfolio();
			// Initialize Masonry plug in for random grid
			_this.siteMasonry();
			// Call scroll events
			_this.siteScrollEvents();
			// Page team responsive background
			_this.teamSkillsBack() ;
			// Initialize Google Map
			_this.googleMap();
		}) ;

		_this.flexslider() ;
	},

	events : function(){
		// show menu for small screen
		_this.dom.btnNav.on('click', _this.showMobileMenu);
		_this.dom._window.on('resize', _this.homeSlide);
		_this.dom._window.on('scroll',_this.siteScrollEvents) ;
		// Mobile events
		if(_this.vars.isDevice || _this.vars.isTabletView){
			_this.dom.isDropDown.on('click','a',_this.dropDownMobileMenu);
		}
	},
	flexslider : function(){
		$('.flexslider').flexslider({
			animation: "fade" , 
			controlNav : false ,
			prevText : '<i class="fa fa-angle-left"></i>',
			nextText : '<i class="fa fa-angle-right"></i>',
			start : function(slider){
				$(slider.containerSelector).find('li').addClass('slide-animate');
				_this.dom.fullSlider.find("img").each(function(){
					var $this = $(this);
					var _img = $this.attr('src') ;
					$(this).parent('li').css('background-image','url('+_img+')');
				});	
			},

			before: function(slider){
				$(slider.containerSelector).find(".slide-animate").each(function(){
					$(this).removeClass("slide-animate");
				});
			},

			after: function(slider){
				$(slider).find(".flex-active-slide").addClass("slide-animate");
			}
 
		});
	},
	teamSkillsBack : function(){
		var _skillsSec = $('.skills-img') ;
		var _skillsImg = _skillsSec.data('team-pic');
		_skillsSec.css('background-image','url('+ _skillsImg +')');
	},
 
	googleMap : function() {
		if(!_this.dom.mapId.length)
			return false ;

		google.maps.event.addDomListener(window, 'load', init);
        
            function init() {
                var mapOptions = {
                    zoom: 11,
                    center: new google.maps.LatLng(40.6700, -73.9400), // New York
                    styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
                };
                var mapElement = document.getElementById('site-map');
                var map = new google.maps.Map(mapElement, mapOptions);
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(40.6700, -73.9400),
                    map: map,
                    title: 'Marco'
                });
            }
    },
	showPreloader : function(){
		_this.dom.pageParent.scrollTop(0) ;
		_this.dom.pageParent.css('overflow','hidden') ;
		_this.dom.preLoader.show() ;
	},

	hidePreloader : function(){
		_this.dom.pageParent.removeAttr('style') ;
		_this.dom.pageParent.fadeIn();
		_this.dom.preLoader.fadeOut();
	},

	siteScrollEvents : function(){
		var _viewPort = $(window).scrollTop() + $(window).height() - 100 ;

		// countTo : init
		if(_this.dom.funinfoSec.length) {

			if( _viewPort > _this.dom.funinfoSec.find('.count-amount').offset().top){
				if(!_this.dom.funinfoSec.hasClass('animated')){
					$('.count-amount').countTo({speed: 5000,});
				}
				_this.dom.funinfoSec.addClass('animated') ;
			}
		}
		// Progress Bars : init
		if(_this.dom.progressBars.length) {

			if(_viewPort > _this.dom.progressBars.offset().top){

				if(!_this.dom.progressBars.hasClass('animated')){
					_this.dom.progressBars.find('.progress').each(function(){
						var $this = $(this) ;
						var _per = $this.data('percentage') + '%' ;
						var _el  = $('<span class="progress-per"></span>').text(_per) ;
						$this.append(_el);
						$this.animate({'width':_per} , 1500 );
					})
				}

				_this.dom.progressBars.addClass('animated') ;
			}
		}
	},

	showMobileMenu : function(e){
		var $this = $(this) ;
		e.preventDefault();
		
		if($this.hasClass('open')){
			$this.removeClass('open');
			_this.dom.siteNav.slideToggle();
		}else{
			$this.addClass('open');
			_this.dom.siteNav.slideToggle();
		}
	},

	dropDownMobileMenu : function(e){
		var $this = $(this);
		e.preventDefault();
		if($this.hasClass('drop-active')){
			$this.removeClass('drop-active');
		}else{
			$this.addClass('drop-active') ;
		}
		$this.siblings("ul").slideToggle() ;
	},

	swiperSliders : function(){
		var homeSlide = new Swiper ('#hero-slider', {
		    loop: true,
		    autoplay : 3000,
		    speed : 1800,
		    nextButton: '.swiper-button-next',
		    prevButton: '.swiper-button-prev',
		    effect : 'fade',
	  	})   
	  	var aboutSlide = new Swiper ('#about-slider', {
		    loop: true,
		    autoplay : 2000,
		    speed : 3000,
		    effect : 'fade' ,
	  	}) 	

	  	var portfolioSlide = new Swiper ('#single-por-slider', {
		    // Optional parameters
		    loop: true,
		    autoplay : 2000,
	  	}) 

	  	var aboutSlide = new Swiper ('#about-carousel', {
		    // Optional parameters
		    loop: true,
		    autoplay : 1000,
		    speed : 3000,
		    slidesPerView: 6,
		    breakpoints: {
			    // when window width is <= 320px
			    320: {
			      slidesPerView: 1,
			    },
			    // when window width is <= 480px
			    480: {
			      slidesPerView: 2,
			    },
			    // when window width is <= 640px
			    640: {
			      slidesPerView: 3, 
		    	},
		    	840: {
			      slidesPerView: 4, 
		    	}
		    }

	  	})   
	  	var testimonialsSlide = new Swiper ('#testimonials-slider', {
		    paginationClickable:true,
		    pagination: '.swiper-pagination',
 
	  	})    
	},

	homeSlide : function(){
		

		if($(window).width() >= 768 && $(window).height() >= 480){
			_this.dom.fullSlider.css('height' , $(window).height());
		}else{
			_this.dom.fullSlider.removeAttr("style");
		} 
	},

	homeSlideImages : function(){
		_this.dom.heroSlider.find('.swiper-slide').each(function(){
			var $this = $(this) ;
			var _imgLink = $this.data('slide-image');
			$this.css('background-image','url("'+_imgLink+'")');
		})
	},

	homePortfolio : function(){
		var filterBtns = $('.filter-button') ;
		var _homePortfolio = $('#home-portfolio').isotope({
		  itemSelector: '.col-md-4',
		  percentPosition: true,
		  masonry: {
		    columnWidth: '.col-md-4'
		  }
		});

		filterBtns.on( 'click', 'span', function() {
			$(this).addClass('active').siblings('span').removeClass('active');
			var filterValue = $(this).attr('data-filter');
			
			_homePortfolio.isotope({ filter: filterValue });
			_portfolio2.isotope({ filter: filterValue });
			_portfolio3.isotope({ filter: filterValue });
		});

		var _portfolio2 = $('#portfolio2').isotope({
		  itemSelector: '.col-md-3',
		  percentPosition: true,
		  masonry: {
		    columnWidth: '.col-md-3'
		  }
		});
 
		var _portfolio3 = $('#portfolio3').isotope({
		  itemSelector: '.col-md-6',
		  percentPosition: true,
		  masonry: {
		    columnWidth: '.col-md-6'
		  }
		});

 
	},

	siteMasonry : function(){
		var $coldMd6 = $('#masonry-blog').isotope({
		  itemSelector: '.col-md-6',
		  masonry: {
		    columnWidth: '.col-md-6'
		  }
		});

		var $colMd4 = $('#masonry-blog2').isotope({
		  itemSelector: '.col-md-4',
		  masonry: {
		    columnWidth: '.col-md-4'
		  }
		});
	},

	wowInit : function(){
		wow = new WOW({
              	boxClass:     'animate',      // default
              	animateClass: 'animated', // default
              	offset:       100,          // default
              	mobile:       false,       // default
              	live:         false        // default
        });
        wow.init();
	},

 

}
$(document).ready(function() {
	Marco.init() ;
});

