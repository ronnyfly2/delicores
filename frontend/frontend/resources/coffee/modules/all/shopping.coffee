###
# @module :  shopping
# @author : Manuel Del Pozo
# @description : This module implement a slider of the User's shopping list
###

define ['libUnderscore', 'initBxSlider'], (underscore, bxSliderObject) ->
	'user strict'

	slide = undefined
	st =
		ticketsItems: '.Tickets-items'
		ticketsDetail: '.Tickets-detail'
		tplTicketsDetail: '.tplTicketsDetail'
		tplTicket: '.tplTicket'
		inpSearch: '.Tickets-search-box'
		resultSearch: '.resultSearch'
		cleanerSearch: '.Tickets-search-cleaner'
	dom = {}
	type = 'selected'
	start = false
	resetStyles = () ->
		$items = dom.ticketsDetail.find('.Slider-item')
		maxHeight = 0
		[].forEach.call $items, (item) ->
			height = $(item).height()
			if ( maxHeight < height )
				maxHeight = height
			return
		$items.height maxHeight
		return
	catchDom = (st) ->
		Object.keys(st).forEach (item, idx, obj) ->
			dom[item] = $ st[item]
			return
		return
	renderTickets = (data) ->
		html = _.template(dom.tplTicketsDetail.html())( items: data )
		ticketsHTML = _.template(dom.tplTicket.html())( tickets: data )
		dom.ticketsDetail.html(html)
		dom.ticketsItems.html(ticketsHTML)
		afterCatchDom()
		dom.tickets.eq(0)
			.addClass type

		slide = bxSliderObject.init $('.bxslider'),
			'controls': data.length > 1 ? true : false
			'infiniteLoop': true
			'mode': 'horizontal'
			'adaptiveHeight': true
			'pager': false
			'touchEnabled': true
			'prevSelector': $ '.Slider-arrow-left span'
			'nextSelector': $ '.Slider-arrow-right span'
			'onSlideBefore': (obj, old, current) ->
				dom.tickets.removeClass(type)
				dom.tickets.eq(current).addClass(type)
				return
			'onSliderLoad': () ->
				resetStyles()
				return
		dom.tickets.on 'click', events.selectTicket
		return
	afterCatchDom = () ->
		dom.tickets = $ '.Ticket'
		return
	suscribeEvents = ()->
		dom.inpSearch.on 'keyup', _.debounce(events.searchTicket, 600)
		dom.cleanerSearch.on 'click', events.cleanerSearch
		return
	events =
		cleanerSearch: (e) ->
			dom.inpSearch.val('').trigger('keyup')
			$( this ).hide()
			return
		selectTicket: (e) ->
			slide.goToSlide parseInt $( this ).data('index'), 10
			return
		searchTicket: (e) ->
			el = $ this
			searchText = el.val()
				.toLowerCase()
				.trim()
			len = searchText.length
			dom.resultSearch.hide()
			if len > 2
				options = listDetail.filter (item, idx, obj) ->
					if item.infoCine.name_movie isnt null
						title = item.infoCine.name_movie.toLowerCase()
						return title.indexOf(searchText) isnt -1
					else
						return false
				if options.length
					renderTickets(options)
				else
					renderTickets(options)
					dom.ticketsItems.html('<div class="Ticket selected"></div><div class="Ticket">no se encontraron tickets con '+searchText+'</div>')
				dom.cleanerSearch.show()
			else
				dom.cleanerSearch.hide()
				renderTickets(listDetail)
			return
	catchDom(st)
	renderTickets(listDetail)
	suscribeEvents()
	return
