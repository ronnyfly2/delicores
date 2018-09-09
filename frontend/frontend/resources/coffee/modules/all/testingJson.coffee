define ['libJqueryUi'], () ->
	st =
		btn: 'button'
	dom = {}
	catchDom = (st) ->
		dom.btn = $(st.btn)
		return
	suscribeEvents = () ->
		dom.btn.on 'click', events.getJson
		return
	events =
		getJson : (e) ->
			losDatos = 
				"operation":"Transaction"
				"data_sale":
					"id_movie": 1
					"name_movie": "MISION RESCATE"
					"sl_terminal_id" : 1
					"sl_type_sale_id" : 1
					"card_operation" : ""
					"customer" : "81"
					"amount" : "29.000000"
					"pr_type_pay_id" : 2
					"card_code" : ""
					"total_movies": 17.00
					"total_products": 12.00
					"EntityList" :
						"moviesCardEntityList" :[{
							"category" : 1
							"seat" : "A2"
							"id" : "1"
							"codefun" : "16F8"
							"description" : "Jubilados"
							"hall" : 2
							"uvkcard" : 0
						}]
						"productsCardEntityList" : [{
							"category" : 1
							"seat" : ""
							"id" : "135"
							"codefun" : "16F8"
							"description" : "COMBO OTTIS"
							"hall" : ""
							"uvkcard" : ""
						}]
					"employee" : 1
					"number" : 1
					"turn" : 1
					"serie" : 1
					"doc_user" : null
					"extra_detail" : "none"
					"sale_id" : 0
					"payment" : "29.000000"
					"subsidiaries" : "6"
			$.ajax
				method: "POST"
				url: 'http://10.10.0.61/uvk_middleware/source/public/transactions/createTransactionMobile'
				dataType: "JSON"
				data: losDatos
				beforeSend: ()->
					utils.loader $('.pay_section'), true
					return
				success: (response)->
					if response.status == 1
						utils.loader $('.pay_section'), false
						$('.form_register').submit()
						$('.error_form').text(response.msg)
						return
					else
						utils.loader $('.pay_section'), false
						$('.error_form').text(response.msg)
						return
					return
			return
	catchDom(st)
	suscribeEvents()
	return
