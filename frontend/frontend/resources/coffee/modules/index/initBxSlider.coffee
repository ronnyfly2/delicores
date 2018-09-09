define(['libBxSlider'], () ->
	"use strict"
	initBxSlider = (selector, opts) ->
		slide = selector.bxSlider(opts or {})
		do ->
			$(window).resize ()->
				slide.reloadSlider()
				return
			return
		return slide

	return {
		init: initBxSlider
	}

)
