define [], () ->
	st =
		tab : '.tabs > ul > li'
		slcTab: '#slc-mtabs'
		containers : '.tabs_content > .content_caroussel'
	dom = {}
	firstTab = 'tab_one'
	catchDom = ->
		dom.tab = $(st.tab)
		dom.containers = $(st.containers)
		dom.slcTab= $(st.slcTab)
		return
	suscribeEvents = ->
		dom.tab.on 'click', events.changeTab
		dom.slcTab.on 'change', events.slcChangeTab
		return
	events =
		changeTab: ()->
			$this = $(this)
			target = $this.data('tab')
			if target is undefined
				target = firstTab
			elTarget= $('.'+target)
			if !$this.hasClass 'active'
				dom.tab.removeClass('active')
				$("li[data-tab="+target+"]").addClass('active')
				dom.containers.removeClass('is_active')
				elTarget.addClass('is_active')
				dom.slcTab.find('option[data-tab="'+target+'"]')[0].selected = true
			return
		slcChangeTab: (event, flag)->
			$this= $(this)
			target= $this.find('option:selected').data('tab')
			$('.movies .tabs li[data-tab="'+target+'"]').trigger 'click'
			return
	catchDom()
	suscribeEvents()
	events.changeTab()
	return
