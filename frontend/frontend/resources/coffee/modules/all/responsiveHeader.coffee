define([], () ->
	st =
		lnkMenu: '.menu-movil .lnk-mmenu'
		ctnMenu: '.menu-movil'
		menu: '.ctn-mmovil'
	dom = {}
	timeHWin= null
	catchDom = ->
		dom.lnkMenu = $(st.lnkMenu)
		dom.ctnMenu	= $(st.ctnMenu)
		dom.menu= $(st.menu)
		dom.win= $(window)
		return
	suscribeEvents = ->
		dom.lnkMenu.on 'click', events.openMenu
		dom.win.on 'resize', events.resize
		dom.win.trigger 'resize'
		return
	events =
		openMenu : () ->
			if dom.ctnMenu.hasClass('open')
				dom.ctnMenu.removeClass('open')
			else
				dom.ctnMenu.addClass('open')
			return
		resize: ()->
			hWin= dom.win.height()
			if timeHWin
				clearTimeout timeHWin
				timeHWin= null
			timeHWin= setTimeout ()->
				dom.menu.css 'height',hWin
				return
			, 600
			return
	catchDom()
	suscribeEvents()
	return
)
