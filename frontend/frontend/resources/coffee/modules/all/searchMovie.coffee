define ['libUnderscore'], () ->
	timer = 0
	xhr = {readyState: 0}
	st =
		body: 'body'
		ctnLoader: '.box_search'
		inputSearch: 'input.js-search, input.js-search_movie'
		tplLoadSearch: '.tplLoadSeach'
		tplSearchMovies: '.tplSearchMovies'
		tplEmtySearch: '.tplEmtySearch'
	dom = {}
	memoizeLastValue= ''
	timer = null
	instTimeout= null
	xhrSearch= null
	catchDom = (st) ->
		dom.body= $(st.body)
		dom.ctnLoader = $(st.ctnLoader)
		dom.inputSearch = $(st.inputSearch)
		dom.tplLoadSearch= _.template $(st.tplLoadSearch).html()
		dom.tplSearchMovies= _.template $(st.tplSearchMovies).html()
		dom.tplEmtySearch= _.template $(st.tplEmtySearch).html()
		return
	suscribeEvents = ->
		dom.inputSearch.val('')
		dom.inputSearch.on 'keyup', events.evtSearch
		$('.close_search').on 'click', functions.clearSearch
		# $(window).resize functions.resizeWindow
		return
	events =
		evtSearch: ()->
			searchValue= $.trim $(this).val()
			if searchValue.length >= 2
				if searchValue isnt memoizeLastValue
					memoizeLastValue= searchValue
					if instTimeout
						clearTimeout instTimeout
					if xhrSearch
						xhrSearch.abort()
					instTimeout= setTimeout ()->
						functions.searchMovie(searchValue)
					, 400
			else
				functions.clearSearch()
			return false
	functions=
		# resizeWindow: ()->
		# 	sizeWind = $(window).width()
		# 	if sizeWind < 769
		# 		$('.container').show()
		# 	else
		# 		$('.container').hide()
		# 	return
		clearSearch: (ev)->
			memoizeLastValue= ''
			if instTimeout
				clearTimeout instTimeout
			if xhrSearch
				xhrSearch.abort()
			if typeof ev isnt 'undefined'
				dom.inputSearch.val('')
			$('.modal_search').removeClass('open_search')
			$('.close_search').removeClass('activated_close')
			$('.modal_search').html('')
			dom.body.removeClass 'fixsearch'
			$('.container').show()
			if typeof window.slideTopHome isnt 'undefined'
				window.slideTopHome.startAuto()
		searchMovie : (memoizeLastValue)->
			console.log memoizeLastValue
			xhrSearch = $.ajax
				method: "GET"
				url: '/webservice/movie/search'
				dataType: "JSON"
				data:
					"movie": memoizeLastValue
				beforeSend: ()->
					if typeof window.slideTopHome isnt 'undefined'
						window.slideTopHome.stopAuto()
					$('.container').hide()
					dom.body.addClass 'fixsearch'
					$('.modal_search').html dom.tplLoadSearch()
					$('.modal_search').addClass('open_search')
					$('.close_search').addClass('activated_close')
					return
				success: (response)->
					html= dom.tplEmtySearch()
					if response.status is 1
						html = dom.tplSearchMovies
							result: response.data
					$('.modal_search').html html
					return
			return
	catchDom(st)
	suscribeEvents()
	return
