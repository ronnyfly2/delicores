define [], () ->
	st =
		btnSend : '.btn_send'
		frmResumen : '.form_resume'
	dom = {}
	instTimeout= null
	catchDom = (st)->
		dom.btnSend = $(st.btnSend)
		dom.frmResumen = $(st.frmResumen)
		return
	suscribeEvents = ()->
		dom.btnSend.on 'click', events.validate
		return
	events =
		validate : (verifed)->
			if $('#terms').is(':checked')
				if dataSessionStatus isnt 1
					functions.openAuth()
					return false
				else
					utils.loader $('.pay_section'), true
					dom.frmResumen.submit()
				return
			else
				$('.terms_resume > .alert_ticket > span').text('Debes aceptar los terminos y condiciones')
				$('.terms_resume > .alert_ticket').fadeIn(600)
				if instTimeout
					clearTimeout instTimeout
					instTimeout= null
				instTimeout= setTimeout ()->
					$('.terms_resume > .alert_ticket').fadeOut 600,()->
						$('.terms_resume > .alert_ticket > span').text('')
						return
					return
				, 6000
				return false
			return false
	functions =
		openAuth: ()->
			$('.smenu-header .link_login').trigger 'click'
			return
	catchDom(st)
	suscribeEvents()
	return
