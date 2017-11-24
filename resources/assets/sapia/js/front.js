$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

        }
	})

	$('#menuleft li.treeview ul li').click(function(){
		$('#menuleft li.treeview ul li.active').removeClass("active")
		$(this).addClass("active")

		$('#menuleft li.treeview.active').removeClass("active")
		$('#menuleft li.treeview.menu-open').addClass("active")
	})
})

/* [showTabIncoming Función que carga Llamadas Entrantes en el reporte] */
const showTabIncoming = (evento) => dataTables('table-incoming', getDataFilters(evento), 'incoming_calls')

/* [showTabSurveys Función que carga los datos de las Encuenstas] */
const showTabSurveys = (evento) => dataTables('table-surveys', getDataFilters(evento), 'surveys')

/* [showTabConsolidated Función que carga los datos del Consolidado] */
const showTabConsolidated = (evento) => dataTables('table-consolidated', getDataFilters(evento), 'consolidated_calls')

/* [showTabDetailEvents Función que carga los datos detallados de los Eventos del Agente] */
const showTabDetailEvents = (evento) => dataTables('table-detail-events', getDataFilters(evento), 'events_detail')

/* [show_tab_angetOnline Función que carga los datos de los agentes online] */
const showTabAgentOnline = (evento) => dataTables('table-agentOnline', getDataFilters(evento), 'agents_online')

/* [showTabOutgoing Función que carga los datos de las Llamadas Salientes] */
const showTabOutgoing = (evento) => dataTables('table-outgoing', getDataFilters(evento), 'outgoing_calls')

/* [showTabListUser Función que carga los datos detallados de los usuarios] */
const showTabListUser = (evento) => dataTables('table-list-user', getDataFilters(evento), 'manage_users')

/* [showTabListQueues Función que carga los datos detallados de las colas] */
const showTabListQueues = (evento) => dataTables('table-list-queue', getDataFilters(evento), 'manage_queues')

/* [showTabListTemplateQueues Función que carga los datos detallados de los template de las colas] */
const showTabListTemplateQueues = (evento) => dataTables('table-list-template-queue', getDataFilters(evento), 'manage_template_queues')

/* [showTabListSoundMassive Función que carga los datos detallados de los sonidos masivos] */
const showTabListSoundMassive = (evento) => dataTables('table-list-sound-massive', getDataFilters(evento), 'manage_sound_massive')

/* [showTabListMusicOnHold Función que carga los datos detallados de los music on hold] */
const showTabListMusicOnHold = (evento) => dataTables('table-list-music-on-hold', getDataFilters(evento), 'manage_music_on_hold')

/* [showTabAnnexed Función que carga la lista de anexos] */
const showTabAnnexed = (event) => {
	let token = $('meta[name="_token"]').attr('content')
	let imageLoading = `<div class="loading" id="loading"><li></li><li></li><li></li><li></li><li></li></div>`
	$.ajax({
		type: 'POST',
		url: 'agents_annexed/list_annexed',
		cache: false,
		data: {
			_token: token,
			event: event
		},
		beforeSend: () => {
			$('#divListAnnexed').html(imageLoading)
		},
		success: (data) => {
			$('#divListAnnexed').html(data)
		}
	})
}

// Función que activa las llamadas a travez del cambio de roles
const activeCalls = () => {
	if (vueFront.annexed !== 0) {
		showNotificacion('warning', 'Usted debe liberar el anexo antes de activar las llamadas.', 'Ooops!!!', 10000, false, true)
	} else {
		vueFront.remoteActiveCallsUserId = vueFront.getUserId
		let message,title,roleAction,actionCalls
		if(vueFront.getRole == 'backoffice'){
			title = 'Activar Llamadas'
			message = '<h4>¿Usted desea poder recibir llamadas?</h4>' +
																'<br>' +
																'<p><b>Nota : </b>Cuando active la entrada de llamadas usted tendra que seleccionar su anexo y pasar a ACD para que le puedan caer las llamadas. ' +
																'Por favor de verificar que esta asignados a las colas correspondientes.</p>'
			roleAction = 'user'
			actionCalls = 'user'
		}else{
			title = 'Desactivar Llamadas'
			message = '<h4>¿Deseas pasar a BackOffice nuevamente?</h4>' +
																'<br>' +
																'<p><b>Nota : </b>Con esto volveras a pasar al rol BackOffice.</p>'
			roleAction = 'backoffice'
			actionCalls = ''
		}

		BootstrapDialog.show({
			type: 'type-primary',
			title: title,
			message: message,
			closable: true,
			buttons: [
				{
					label: '<i class="fa fa-check" aria-hidden="true"></i> Si',
					cssClass: 'btn-success',
					action: function (dialogRef) {
						let $button = this
						$button.disable()
						if (vueFront.getRole !== roleAction) {
							$button.spin()
							vueFront.remoteActiveCallsNameRole = roleAction
							vueFront.activeCalls(actionCalls)
						} else {
							closeNotificationBootstrap()
						}
					}
				},
				{
					label: '<i class="fa fa-times" aria-hidden="true"></i> No',
					cssClass: 'btn-danger',
					action: function (dialogRef) {
						vueFront.remoteActiveCallsUserId = ''
						dialogRef.close()
					}
				}
			]
		})
	}
}

// Función que verifica si necesita realizar un cambio de contraseña
const checkPassword = () => { if (vueFront.statusChangePassword == 0) $('#changePassword').click() }



/**
 * Created by jdelacruzc on 11/04/2017.
 *
 * [changeStatus description]
 * @return Cambia el estado del usuario
 */
const changeStatusUser = (userId, status) => {
	let token = $('meta[name="_token"]').attr('content')
	let estado = (status === 'Inactivo') ? 1 : 2
	let message = 'Deseas cambiar el estado del usuario ?' +
				'<br>' +
				'<b>Nota :</b> Esto afecta el estado (Activo o Inactivo).'

	BootstrapDialog.show({
		type: 'type-primary',
		title: 'Cambiar Estado',
		message: message,
		closable: true,
		buttons: [
			{
				label: 'Si',
				cssClass: 'btn-success',
				action: function (dialogRef) {
					$.ajax({
						type: 'POST',
						url: 'changeStatus',
						data: {
							_token: token,
							userID: userId,
							estadoID: estado
						},
						success: function (data) {
							if (data === 1) {
								showTabListUser('list_users')
								dialogRef.close()
								showNotificacion('success', 'Se cambio el estado del usuario!!!', 'Success', 2000, false, true)
							} else {
								showNotificacion('error', 'Problemas al cambiar en la base de datos', 'Error', 10000, false, true)
							}
						}
					})
				}
			},
			{
				label: 'No',
				cssClass: 'btn-danger',
				action: function (dialogRef) {
					dialogRef.close()
				}
			}
		]
	})
}

/**
 * Created by jdelacruzc on 11/04/2017.
 *
 * [createUser description]
 * @return Crea un usuario nuevo y refersca el datatable listuser
 */
function createUser () {
	const token = $('meta[name="_token"]').attr('content')
	const message = '<br>' +
						'<div class="row">' +
						'<div class="col-md-12">' +
						'<div class="col-md-6" >' +
						'Primer Nombre:' +
						'</div>' +
						'<div class="col-md-6">' +
						'<input type="text" class="form-control" style="border-radius: 7px" id="primerNombre" placeholder="Test">' +
						'</div>' +
						'<br>' + '<br>' + '<br>' +
						'<div class="col-md-6">' +
						'Segundo Nombre:' +
						'</div>' +
						'<div class="col-md-6">' +
						'<input type="text" class="form-control" style="border-radius: 7px" id="segundoNombre" placeholder="Test 2">' +
						'</div>' +
						'<br>' + '<br>' + '<br>' +
						'<div class="col-md-6">' +
						'Apellido Paterno:' +
						'</div>' +
						'<div class="col-md-6">' +
						'<input type="text" class="form-control" style="border-radius: 7px" id="apellidoPaterno" placeholder="Cosapi">' +
						'</div>' +
						'<br>' + '<br>' + '<br>' +
						'<div class="col-md-6">' +
						'Apellido Materno:' +
						'</div>' +
						'<div class="col-md-6">' +
						'<input type="text" class="form-control" style="border-radius: 7px" id="apellidoMaterno" placeholder="Cosapi 2">' +
						'</div>' +
						'<br>' + '<br>' + '<br>' +
						'<div class="col-md-6">' +
						'Username:' +
						'</div>' +
						'<div class="col-md-6">' +
						'<input type="text" class="form-control" style="border-radius: 7px" id="userName" placeholder="testCosapi">' +
						'</div>' +
						'<br>' + '<br>' + '<br>' +
						'<div class="col-md-6">' +
						'Contraseña:' +
						'</div>' +
						'<div class="col-md-6">' +
						'<input type="password" class="form-control" style="border-radius: 7px" id="nuevaContraseña" placeholder="xxxxxx">' +
						'</div>' +
						'<br>' + '<br>' + '<br>' +
						'<div class="col-md-6">' +
						'Correo:' +
						'</div>' +
						'<div class="col-md-6">' +
						'<input type="text" class="form-control" style="border-radius: 7px" id="email" placeholder="cosapi@cosapidata.com.pe">' +
						'</div>' +
						'<br>' + '<br>' + '<br>' +
						'<div class="col-md-6">' +
						'Rol de Usuario:' +
						'</div>' +
						'<div class="col-md-6">' +
						'<select class="form-control" style="border-radius: 7px" id="slRol">' +
						'<option value="sinrol" selected>Seleccionar Aqui</option>' +
						'<option value="user">Usuario</option>' +
						'<option value="backoffice">BackOffice</option>' +
						'<option value="supervisor">Supervisor</option>' +
						'<option value="cliente">Cliente</option>' +
						'<option value="calidad">Calidad</option>' +
						'</select>' +
						'</div>' +
						'</div>' +
						'</div>'

	BootstrapDialog.show({
		type: 'type-primary',
		title: 'Crear Nuevo Usuario',
		message: message,
		closable: true,
		buttons: [
			{
				label: 'Aceptar',
				cssClass: 'btn-primary',
				action: function (dialogRef) {
					let primerNombre = $('#primerNombre').val()
					let segundoNombre = $('#segundoNombre').val()
					let apellidoPaterno = $('#apellidoPaterno').val()
					let apellidoMaterno = $('#apellidoMaterno').val()
					let userName = $('#userName').val()
					let nuevaContraseña = $('#nuevaContraseña').val()
					let email = $('#email').val()
					let role = $('#slRol').val()

					if (primerNombre != '' && segundoNombre != '' && apellidoPaterno != '' && apellidoMaterno != '' && userName != '' && nuevaContraseña != '' && email != '' && role != 'sinrol') {
						$.ajax({
							type: 'POST',
							url: 'createUser',
							data: {
								_token: token,
								primerNombre: primerNombre,
								segundoNombre: segundoNombre,
								apellidoPaterno: apellidoPaterno,
								apellidoMaterno: apellidoMaterno,
								userName: userName,
								nuevaContraseña: nuevaContraseña,
								email: email,
								role: role
							},
							success: function (data) {
								if (data == 1) {
									showTabListUser('list_users')
									dialogRef.close()
									showNotificacion('success', 'El usuario se registro correctamente!!!', 'Success', 2000, false, true)
								} else {
									showNotificacion('error', 'Problemas de inserción a la base de datos', 'Error', 10000, false, true)
								}
							}
						})
					} else {
						alert('Por favor de llenar todos los campos')
					}
				}
			},
			{
				label: 'Cancelar',
				cssClass: 'btn-primary',
				action: function (dialogRef) {
					dialogRef.close()
				}
			}
		]
	})
}

/**
 * Created by jdelacruzc on 11/04/2017.
 *
 * [RoleTableHide description]
 * @return {Array} [Los roles con el cual me ocultaran las columnas]
 */
const RoleTableHide = () => ['user', 'cliente']

// Función para asignar o liberar anexo en base al rol
const assignAnexxed = (annexed, userId, username) => {
	if (userId === '' && vueFront.annexed !== 0) {
		showNotificacion('warning', 'Ya se encuentra asignado al anexo ' + vueFront.annexed + '.', 'Warning', 10000, false, true)
	} else {
		if (userId === '') {
			vueFront.remotoReleaseAnnexed = annexed
			vueFront.assignAnnexed()
		} else {
			vueFront.remotoReleaseAnnexed = annexed
			vueFront.remotoReleaseUsername = username
			vueFront.remotoReleaseUserId = userId
			vueFront.remotoReleaseStatusQueueRemove = true
			vueFront.releasesAnnexed()
		}
	}
}

// Funcion que carga el modal se marcado de salida
const disconnect = () => {
	let hour = vueFront.hourServer
	let rank_hours = rangoHoras(hour.trim())
	const message01 = 'Usted se retira de las oficinas ?'
	const message02 = 'Por favor de seleccionar la hora correspondiente a su Salida.' +
								'<br><br>' +
								'<div class="row">' +
								'<div class="col-md-6"><center><input type="radio" name="rbtnHour" id="rbtnHour" value="' + hour + '">' + hour + '</center></div>' +
								'<div class="col-md-6"><center><input type="radio" name="rbtnHour" id="rbtnHour_after" value="' + rank_hours[2] + '">' + rank_hours[2] + '</center></div>' +
								'</div>'

    if (vueFront.searchStatusVisible(vueFront.getEventId) === 2 && vueFront.getEventId != 11) {
        showNotificacion('error', 'No puedes desconectarte, en plena llamada', 'Ooops!!!', 10000, false, true)
    }else{
        BootstrapDialog.show({
            type: 'type-primary',
            title: 'Registrar Salida',
            message: message01,
            closable: false,
            buttons: [
                {
                    label: 'Si',
                    cssClass: 'btn-primary',
                    action: function (dialogRef) {
                        dialogRef.close()
                        vueFront.nextEventId = 15
                        vueFront.nextEventName = 'Desconectado'
                        vueFront.assistanceTextModal = 'Salida'
                        vueFront.loadModalCheckAssistance()
                    }
                },
                {
                    label: 'No',
                    cssClass: 'btn-primary',
                    action: function (dialogRef) {
                        dialogRef.close()
                        vueFront.remoteAgentHour = hour.trim()
                        vueFront.disconnectAgent()
                    }
                },
                {
                    label: 'Cancelar',
                    cssClass: 'btn-danger',
                    action: function (dialogRef) {
                        dialogRef.close()
                    }
                }
            ]
        })
	}

}

// Función que acciona le ventana de asistencias correspondiente al estado
const MarkAssitance = (user_id, day, hour_actually, action) => {
	if (vueFront.statusChangeAssistance == true) {
		modalAssintance(user_id, day, hour_actually, action)
	} else if (vueFront.statusChangeAssistance != false) {
		let assistenceUser = $('#assistence_user').val().split('&')
		ModalStandBy(assistenceUser[1])
	} else {
		checkPassword()
	}
}

// Funcion para reutilizar Modals
const responseModal = (nameRoute, routeLoad, valID = null) => {
	let imageLoading = `<div class="loading" id="loading"><li></li><li></li><li></li><li></li><li></li></div>`
	let token = $('meta[name="_token"]').attr('content')
	$.ajax({
		type : 'POST',
		url : routeLoad,
		data: {
			_token: token,
			valueID: valID
		},
		beforeSend: function(){
			$(nameRoute).html(imageLoading)
		},
		success:function(data){
			$(nameRoute).html(data)
		}
	})
}

// Función para cerrar un modal y limpiar el cuerpo del mismo (Funciona con la función responseModal)
const clearModal = (modalID, bodyModal) => {
	$(bodyModal).html('').promise().done(function() {
		$('#'+modalID).modal('toggle')
	})
}

// Función para escuchar el evento cuando se cierra un modal y limpiar el cuerpo del mismo (Funciona con la función responseModal)
const clearModalClose = (modalID, bodyModal) => {
	$('#'+modalID).on('hidden.bs.modal', function () {
		$(bodyModal).html('')
	})
}

// Función que muestra un boton de carga cuando se ejecuta un formulario
const changeButtonForm = (btnShow, btnHide) => {
	$('.'+btnShow).fadeOut("fast", function() {
		$('.'+btnHide).fadeIn("fast")
	})
}

// Función que muestra los errores que emite el controlador en un DIV
const showErrorForm = (data, formDiv) => {
	let errors = ''
	for(datos in data.responseJSON){
		errors += '<strong>' + data.responseJSON[datos] + '</strong><br>'
	}
	$(formDiv).fadeIn().html(
		'<span class="fa fa-close"></span> <strong>Error</strong>'+
												'<hr class="message-inner-separator">'+
																'<span>' + errors + '</span>'
	)
}

// Función para ocultar los errores cuando se ingresa en algun campo que se requeria data
const hideErrorForm = (formDiv) => {
	$("input[type=text],input[type=checkbox],input[type=password]").click(function() {
		$(formDiv).fadeOut().html()
	})
}

// Función que carga automaticamente la ruta de la musica al iniciar el formQueues
const loadRouteMusic = (selectMusic, audioTag) => {
    let src = $(selectMusic + " option:selected").data('route')
    $(audioTag).attr('src', src)
}

const loadSelectStrategy = (selectStrategy) => {
    let nameStrategy = $(selectStrategy + " option:selected").data('name')
    $('#'+nameStrategy).fadeIn('blind')
}

// Función que detecta el cambio en un select y manda mediante el data-id la ruta para el audio
const searchRouteMusic = (selectMusic, audioTag) => {
    $(selectMusic).change(function(){
        let src = $(selectMusic + " option:selected").data('route')
        $(audioTag).attr('src', src)
    })
}

const searchLegendQueue = (selectedStrategy) => {
    $(selectedStrategy).change(function(){
        let nameStrategy = $(selectedStrategy + " option:selected").data('name')
        $('.legendQueue').hide()
        $('#'+nameStrategy).fadeIn('blind')
    })
}

// Función para poder buscar en una tabla
const searchTable = (idTable, idSearch, filterAnnexed = '') => {
	$(idSearch).keyup(function(){
		_this = this
		$.each($(idTable + " tbody tr " + filterAnnexed), function() {
			let value = -1
			let valueSearch = $(_this).val()
			if($(this).text().toLowerCase().indexOf(valueSearch.toLowerCase()) === value) {
				$(this).hide()
			}else {
				$(this).show()
			}
		})
	})
}

// Función para seleccionar todos los checkbox con uno solo
const mark_all = (checkGeneral) => {
	if($(checkGeneral).is(':checked')){
		$("input.checkNew:checkbox").prop("checked", "checked")
		$('tr.trNew').addClass('warning')
		$('select.selectNew').removeAttr("disabled").val('1')
	}else{
		$("input.checkNew:checkbox").prop("checked", false)
		$('tr.trNew').removeClass('warning').addClass('info')
		$('select.selectNew').attr("disabled", true).val('-')
	}
}

// Función que deshabilita y coloca estilo a la fila de la tabla
const markCheck = (check) => {
	if($('#checkbox_'+check).is(':checked')){
		$('#tr_'+check).addClass('warning')
		$('#select_'+check).removeAttr("disabled").val('1')
	}else{
		$('#tr_'+check).removeClass('warning').addClass('info')
		$('#select_'+check).attr("disabled", true).val('-')
	}
}
