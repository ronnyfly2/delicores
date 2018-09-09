define(['loadmap'], () ->
	console.log "maps..."
	st =
		map : '#map'
	dom = {}
	catchDom = ->		
		return
	catchDom()
	functions =
		initMap: () ->

			$('.google-map').lazyLoadGoogleMaps callback: (container, map) ->
				$container = $(container)
				center = new (google.maps.LatLng)($container.attr('data-lat'), $container.attr('data-lng'))
				map.setOptions
					zoom: 15
					center: center
				new (google.maps.Marker)(
					position: center
					map: map
					animation: google.maps.Animation.DROP
					icon: '../client/img/icon_map.png'
					)			
				google.maps.event.addListenerOnce map, 'idle', ->
					$container.addClass 'is-loaded'
					return
				return
			return
	functions.initMap()
	return
)
