define ['priceCombo','libUnderscore','libFancyBox'], (priceCombo) ->
	st =
		ctnListCbo : '.list-cboresumen'
		lnkAddCbo : '.combo_resume .btn_add'
		lnkDeleteCbo : '.lnkCboDelete'
		tplCombos : '#tplCombos'
		tplCombo : '#tplCombo'
		itemsCombos: '.modal_combo .box_combo'
		ctnLoaderCombo: '.combo_resume'
	dom = {}
	jsonListCombo= listCombos
	catchDom = ->
		dom.ctnListCbo = $(st.ctnListCbo)
		dom.lnkAddCbo= $(st.lnkAddCbo)
		dom.tplCombos= _.template $(st.tplCombos).html().replace(/[\n\r]/g, "")
		dom.tplCombo= _.template $(st.tplCombo).html()
		dom.ctnLoaderCombo = $(dom.ctnLoaderCombo)
		return
	suscribeEvents = ->
		dom.lnkAddCbo.on "click", events.openModal
		dom.ctnListCbo.on "click",st.lnkDeleteCbo, events.deleteCbo
		return
	events =
		openModal : ()->
			$this= $(this)
			elCtnCombos= $ dom.tplCombos
				'combos': jsonListCombo				
			elCtnCombos.find('.btn-addcbo').on "click", events.addCbo
			$.fancybox
				content: $(".modal_combo").html elCtnCombos
				autoSize: true
				autoResize: true
				autoWidth: true
				beforeShow: ->
					utils.loader $('.box_resume'), true
					return
				afterLoad: ()->
					priceCombo.init()
					return
				beforeClose: ->
					utils.loader $('.box_resume'), false
					return
				'padding': 0
				'autoScale': false
				'wrapCSS': 'fancy_combo'
				'transitionIn': 'none'
				'transitionOut': 'none'
				'title': @title
				'width': '80%'
				'height': 'auto'
				helpers:
					overlay:
						closeClick: false
						css:
							'background-color': 'rgba(255,255,255,0.9)'
			return
		addCbo: ()->
			flagSep= true
			data= ''
			idsCbo= []
			$(st.itemsCombos+'.add_border').each ()->
				$this= $(this)
				idCbo= $this.data 'id'
				cantCbo= $.trim $this.find('.cant_combo').val()
				cantCbo= if cantCbo is '' or cantCbo is '0' then 1 else cantCbo
				sep= '||'
				if flagSep
					sep= ''
					flagSep= false
				data= data + sep + idCbo + '-' + cantCbo
				idsCbo.push idCbo
				return
			if data isnt ''
				ctnLoader= $('.modal_combo')
				utils.loader ctnLoader,true
				$('.btn-addcbo').attr('disabled',true)
				$.ajax
					'url': window.alpha.baseUrl+'webservice/cart/add-combo'
					'data':
						'dataCombo': data
					'before': ()->
						utils.loader ctnLoader,true
					'success': (json)->
						if parseFloat(json.status) is 1
							utils.loader ctnLoader,false
							jsonListCombo= json.data
							functions.addCombos data
							$.fancybox.close()
							functions.calculatePrice()
							functions.calculateTotalPrices()
						return
		deleteCbo : ()->
			$this= $(this)
			target= $this.parents('.box_item_combo_resume')
			parent= $this.parents('.cant')
			idCbo= parent.data 'id'
			utils.loader target, true
			$.ajax
				'url': window.alpha.baseUrl+'webservice/cart/delete-combo'
				'data':
					'id': idCbo
				'success': (json)->
					utils.loader target, false
					if parseFloat(json.status) is 1
						jsonListCombo= json.data
						target.remove()
						functions.manageDisplayCbo()
						functions.calculatePrice()
						functions.calculateTotalPrices()
					return
			return
	functions=
		calculatePrice: ()->
			price = 0
			len = 0
			total = 0
			[].forEach.call $('.box_item_combo_resume'), (item, idx, obj)->
				el = $(item)
				price = parseFloat(el.find('.combo_item').data('price'))
				len = parseInt(el.find('.cant').data('cant'), 10) || 0
				total += (price * len)
			$('.sb_total').text(total.toFixed(2))
			return
		calculateTotalPrices: ()->
			price = 0
			len = 0
			total = 0
			[].forEach.call $('.sb_total_price'), (item, idx, obj)->
				el = $(item)
				price = parseFloat(el.text())
			# 	len = parseInt(el.find('.cant').data('cant'), 10) || 0
				total += (price)
			$('.total_prices').text(total.toFixed(2))
			return
		manageDisplayCbo: ()->
			cantCbo= dom.ctnListCbo.find('li').length
			totalCbo= jsonListCombo.combos.length
			if cantCbo >= totalCbo
				dom.lnkAddCbo.fadeOut()
			else
				dom.lnkAddCbo.fadeIn()
			return
		addCombos: (data)->
			combos= data.split('||')
			lCombos= _.clone(jsonListCombo.combos)
			lCombos= _.indexBy(lCombos, 'id');
			_.each combos, (combo)->
				arrValues= combo.split('-')
				idCbo= arrValues[0]
				cantCbo= arrValues[1]
				json= 
					'combo': lCombos[idCbo]
					'cantidad': cantCbo
				htmlCbo= dom.tplCombo json
				dom.ctnListCbo.append htmlCbo
				return
			functions.manageDisplayCbo()
			return
	catchDom()
	suscribeEvents()
	functions.manageDisplayCbo()
	functions.calculateTotalPrices()
	return
