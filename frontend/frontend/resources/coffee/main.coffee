alpha = window.alpha
console.log '==> mod:'
if typeof alpha == 'undefined'
	alpha = {}
do ->
	mod = alpha.module
	ctrl = alpha.controller
	act = alpha.action
	console.log '==> mod: ' + mod + ' - ctrl: ' + ctrl + ' - act: ' + act
	return
require [ 'schema' ]
#require [ 'router' ]
