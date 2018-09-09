define [], () ->
	st =
		listLnk: '.list_subsidiaries li'
		ctnDetail: '.content_subsidiaries_details'
		bodyTop: 'html, body'
	dom = {}
	flagEventResize= true
	lastTarget= null
	currentWidth= 0
	hHeader= 69
	catchDom = ->
		dom.listLnk= $(st.listLnk)
		dom.ctnDetail= $(st.ctnDetail)
		dom.bodyTop= $(st.bodyTop)
		dom.win= $(window)
		return
	suscribeEvents = ->
		dom.win.on 'resize', events.resize
		dom.win.trigger 'resize'
		dom.listLnk.on 'clickTab', events.dispatchTab
		return
	events =
		dispatchTab: ()->
			if !flagEventResize
				$this= $(this)
				idDetail= $this.data 'id'
				target= dom.ctnDetail.clone()
				target.hide()
				if lastTarget
					functions.clearDetail()
					lastTarget= null
				$this.after target
				fixHtop= $this.offset().top - hHeader
				dom.bodyTop.scrollTop fixHtop
				lat= if $.trim($this.data('lat')) isnt "" then $this.data('lat') else -12.0980071
				lng= if $.trim($this.data('lng')) isnt "" then $this.data('lng') else -77.0441266
				functions.showDetail target,lat, lng
			return
		resize: ()->
			wWin= dom.win.width()
			if currentWidth != wWin
				currentWidth= wWin
				if currentWidth > 765
					functions.clearDetail()
					flagEventResize= true
				else
					if flagEventResize
						flagEventResize= false
						$(st.listLnk + '.current_item').trigger 'clickTab'
			return
	functions=
		clearDetail: ()->
			$('.list_subsidiaries .content_subsidiaries_details').remove()
			return
		showDetail: (target, lat, lng)->
			target.slideDown 400,()->
				lastTarget= target
				if window.alpha.action is 'getNuestrosCines'
					functions.getMapBox(lat, lng)
				return
			return
		getMapBox:(lat, lng)->
			elMap= $('.list_subsidiaries .content_subsidiaries_details').find("#map")
			elMap.html ""
			map = new google.maps.Map elMap[0],{
				zoom: 17
				center: {
					lat: lat
					lng: lng
				}
			}
			functions.getMarker(map, lat, lng)
			return
		getMarker:(map, lat, lng)->
			locationMarker = new google.maps.Marker {
				zoom: st.zoomMap
				position: {
					lat: lat
					lng: lng
				}
				map : map
				icon: '/img/pin.png'
				shadow: '/img/pin.png'
			}
			return
	catchDom()
	suscribeEvents()
	return
