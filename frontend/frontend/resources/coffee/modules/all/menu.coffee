define([], () ->
	st =
		menu : '.menu'
	dom = {}
	catchDom = ->
		dom.menu = $(st.menu)
		return
	suscribeEvents = ->
		dom.menu.on 'click', events.menu
		return
	events =
		menu : ()->
			if $('.l-site').hasClass('is-open')
				$('.menu').removeClass 'is-active'
				$('.l-site').removeClass 'is-open'
			else
				$('.menu').addClass 'is-active'
				$('.l-site').addClass 'is-open'
				$('.l-nav').css 'display','block'
			return
	catchDom()
	suscribeEvents()
	return
)
