(function(){define(["libOwlCarousel","initBxSlider"],function(e,i){"use strict";var t,l,s,o;o={carousel:".carrousel-one,.carrousel-two,.carrousel-three"};l={};t=function(){l.carousel=$(o.carousel)};t();s={initCarousel:function(){window.slideTopHome=i.init($(".bxslider"),{controls:false,infiniteLoop:true,mode:"horizontal",auto:true,adaptiveHeight:true,pager:false});window.slide=l.carousel.owlCarousel({items:6,itemsCustom:false,itemsDesktop:[1075,5],itemsDesktopSmall:[980,3],itemsTablet:[768,2],itemsTabletSmall:false,itemsMobile:[479,1],singleItem:false,itemsScaleUp:false,navigation:true,rewindNav:true})}};s.initCarousel()})}).call(this);