define(['libOwlCarousel', 'initBxSlider'], (param1, bxSliderObject) ->
	"use strict"
	st =
		carousel : '.carrousel-one,.carrousel-two,.carrousel-three'

	dom = {}

	catchDom = ->
		dom.carousel = $(st.carousel)
		return
	catchDom()

	functions =
		initCarousel: () ->
			window.slideTopHome= bxSliderObject.init $('.bxslider'),
				'controls': false
				'infiniteLoop': true
				'mode': 'horizontal'
				'auto': true
				'adaptiveHeight': true
				'pager': false
			window.slide = dom.carousel.owlCarousel(
				items : 6
				itemsCustom : false
				itemsDesktop : [1075,5]
				itemsDesktopSmall : [980,3]
				itemsTablet: [768,2]
				itemsTabletSmall: false
				itemsMobile : [479,1]
				singleItem : false
				itemsScaleUp : false
				navigation : true
				rewindNav : true
			)
			return
	functions.initCarousel()
	return
)
