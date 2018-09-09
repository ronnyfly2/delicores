require.config
	baseUrl: '../../../js'
	waitSeconds: 0
	urlArgs: 'v=' + (new Date()).getTime()
	paths:
		'libBxSlider': 'libs/bxslider-4/jquery.bxslider'
		#'libParsley': 'libs/parsleyjs/dist/parsley.min'
		'libUnderscore':'libs/underscore/underscore'
		'libOwlCarousel':'libs/owlcarousel/owl-carousel/owl.carousel.min'
		'libFancyBox':'libs/fancybox/source/jquery.fancybox.pack'
		'initBxSlider': 'modules/index/initBxSlider'
		'es': 'libs/parsleyjs/src/i18n/es'
		'jqutils' :'libs/jq-utils/jq-utils'
		'shopping': 'modules/all/shopping'
		'priceCombo': 'modules/all/initCombosAddCart'
		'libJqueryUi': 'libs/jquery-ui/jquery-ui.min'
define 'jquery', [], () ->
	return jQuery
define 'Vue', [], () ->
	return Vue
define [], ->
	window.schema =
		controllers:
			'home':
				actions:
					getIndex: ->
						require(['modules/all/tabs'])
				allActions: ->
		allControllers: ->
			require([])
			return
	getCtrl = (schema) ->
		for parents of schema
			parents = parents
			if parents == 'controllers'
				for controller of schema[parents]
					if controller == alpha.controller
						for actions of schema[parents][controller]
							for action of schema[parents][controller][actions]
								if action == alpha.action
									schema[parents][controller][actions][action]()
			if parents == 'allControllers'
				schema[parents]()
		return
	getCtrl window.schema
	return
