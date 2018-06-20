'use strict'
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="_token"]').getAttribute('content')

const socketSails = io.sails.connect(restApiSails)
io.sails.autoConnect = false
socketSails.reconnection = true
socketSails.reconnectionDelayMax = 5

const socketNodejs = io.connect(restApiDashboard, {
	'reconnection': true,
	'reconnectionAttempts': 15,
	'reconnectionDelay': 9000,
	'reconnectionDelayMax': 9000}
)

const vueFront = new Vue({
	el: '#frontAminLTE',
	data: {
		divContainer: '-',

		getNameProyect: '',
		getUserId: '',
		getUsername: '',
		getNameComplete: '',
		getRole: '',
		getRemoteIp: '',
		getEventId: '',
        getChangeRole: '',
		statusChangePassword: '',
		statusChangeAssistance: '',
		statusAddAgentDashboard: '',
		statusQueueAddAsterisk: false,
		eventStatusPause: '',
		annexedStatusAsterisk: 0,
		annexed: 0,
		srcAvatar: 'default_avatar.png',

		remotoReleaseUserId: 0,
		remotoReleaseUsername: 0,
		remotoReleaseAnnexed: 0,
		remotoReleaseStatusQueueRemove: false,
		remoteAgentHour: '',
		remoteActiveCallsUserId: '',
		remoteActiveCallsNameRole: '',

		getQueuesUser: [],
		getListEvents: [],
		getAgentDashboard: [],
		getBroadcastMessage: [],

		hourServer: '',
		textDateServer: '',
		dateServer: '',
		requiredAnnexed: false,
		differenceHour: '00:00:00',

		assistanceTextModal: 'Entrada',
		assistanceHour: '',
		assistanceNextHour: '',

		nextEventId: '',
		nextEventName: '',
		routeAction: '/detalle_eventos/registrarDetalle',

		ModalLoading: 'modal fade',
		ModalAssistance: 'modal fade',
		ModalChangeStatus: 'modal fade',
		ModalReleasesAnnexed: 'modal fade',
		ModalConnectionNodeJs: 'modal fade',
		ModalStandByAssistance: 'modal fade',

		nodejsStatusSails: false,
		nodejsStatusAsterisk: false,
		nodejsServerStatus: 'activo',
		nodejsServerName: '',
		nodejsServerMessage: '',

		titleStandBy: '',
		messageStandBy: ''
	},
	created(){
		this.loadVariablesGlobals()
	},
	mounted () {
		this.loadAllListEvent()
		this.loadQueuesUser()
		this.loadBroadcastMessage()
		this.loadAgentDashboard()
	},
	computed:{
		getPercentageOfWeightQueue() {
			return this.getQueuesUser.map(function(item) {
				let weightAgent = item.Priority.weight_agent
				return Math.round(100/weightAgent)
			})
		},
		getColorPercentageOfWeightQueue() {
			return this.getQueuesUser.map(function(item) {
				let color
				let weightAgent = item.Priority.weight_agent
				let percentage = Math.round(100/weightAgent)
				switch (true){
				case (percentage > 75):
					color = 'success'
					break
				case (percentage > 50 && percentage <= 75):
					color = 'primary'
					break
				case (percentage > 25 && percentage <= 50):
					color = 'info'
					break
				case (percentage > 10 && percentage <= 25):
					color = 'warning'
					break
				case (percentage > 0 && percentage <= 10):
					color = 'danger'
					break
				default:
					color = 'light-blue'
					break
				}
				return color
			})
		},

		getNameEvent: function () {
			return this.searchNameEvent(this.getEventId)
		}
	},
	methods: {

		sendUrlRequest: async function (url, parameters = {}) {
			try {
				let response = await this.$http.post(url, parameters)
				return response.data
			} catch (error) { return error.status }
		},

		getAvatar: function () {
			let userId = this.getUserId
			let parameters = { userID: userId }
			this.$http.post('viewUsers', parameters).then(response => {
				this.srcAvatar = response.body[0].user_profile.avatar
			}, response => console.log(response.body))
		},

		loadVariablesGlobals: async function () {
			const response = await this.sendUrlRequest('/frontPanel/getVariablesGlobals')
			this.getNameProyect = response.getNameProyect
			this.getUserId = response.getUserId
			this.getUsername = response.getUsername
			this.getNameComplete = response.getNameComplete
			this.getRole = response.getRole
            this.getChangeRole = response.getChangeRole
			this.getRemoteIp = response.getRemoteIp
			this.statusChangePassword = response.statusChangePassword
			this.statusChangeAssistance = response.statusChangeAssistance
			this.statusQueueAddAsterisk = response.statusQueueAddAsterisk
			this.requiredAnnexed = response.requiredAnnexed
			this.hourServer = response.hourServer
			this.textDateServer = response.textDateServer
			this.dateServer = response.dateServer
			this.annexed = response.annexed
			this.assistanceNextHour = response.assistanceNextHour
			currenTime()

			// Cargando image del profile_user
			this.getAvatar()

			// Verificacion de marcado de asistencia y requerimiento de cambio de contraseña
			await this.verifyAssistance()

			if (this.annexed === 0) this.loadOptionMenu('agents_annexed')

			if (response) {
				if (this.getUserId && this.getNameProyect) {
					this.statusAddAgentDashboard = true
                    socketNodejs.emit('createRoomFrontPanel', { nameProyect: this.getNameProyect, agent_user_id: this.getUserId})
				}

				// Cargando registro en Dahsboard
				let responseAddDashboard = await this.sendUrlRequest('/frontPanel/getStatusAddAgentDashboard')
				if (responseAddDashboard.statusAddAgentDashboard === false) {
					this.statusAddAgentDashboard = true
					this.getAgentDashboard = await this.sendUrlRequest('/frontPanel/getAgentDashboard')
					socketNodejs.emit('addUserToDashboard', this.getAgentDashboard)
				}
			}
		},

		loadQueuesUser: async function () {
			const response = await this.sendUrlRequest('/frontPanel/getQueuesUser')
			this.getQueuesUser = response.getQueuesUser
		},

		loadAllListEvent: async function (){
			this.getListEvents = await this.sendUrlRequest('/frontPanel/getAllListEvents')
		},

		loadAgentDashboard: async function (){
			const response = await this.sendUrlRequest('/frontPanel/getAgentDashboard')
			this.getAgentDashboard = response
			this.annexedStatusAsterisk = response.agent_status
			this.getEventId = response.event_id
		},

		loadBroadcastMessage: async function () {
			const response = await this.sendUrlRequest('/frontPanel/broadcastMessage')
			this.getBroadcastMessage = response.getBroadcastMessage
		},

		verifyQueueAssign: function () {
			if (this.getRole === 'user') {
				if (this.getQueuesUser.length === '0') {
					showNotificacion('warning', 'Usted no tiene colas asignadas.', 'Ooops!!!', 10000, false, true)
					return false
				}
			}
			return true
		},

		loadModalStatus: async function () {
			let isVerifyAnnexed = false
            let isVerifyEvent = (this.getEventId == 11) ? true : this.verifyEvent(this.getEventId)
			let isVerifyQueueAssign = this.verifyQueueAssign()
			if (isVerifyQueueAssign) isVerifyAnnexed = this.verifyAnnexed()
            if (isVerifyAnnexed && isVerifyEvent) this.ModalChangeStatus = 'modal show'
		},

		verifyAnnexed: function () {
			if (this.getRole === 'user') {
				if (this.requiredAnnexed) {
					if (this.annexed == 0) {
						closeNotificationBootstrap()
						showNotificacion('warning', 'Usted debe seleccionar un anexo.', 'Ooops!!!', 8000, true, true)
						return false
					}
					return true
				}
				return false
			}
			return true
		},

        verifyEvent: function (eventID) {
            if (this.searchStatusVisible(eventID) === 2) {
                closeNotificationBootstrap()
                showNotificacion('error', 'No puede cambiar de evento en plena llamada', 'Ooops!!!', 8000, true, true)
                return false
            }else{
                return true
            }
        },

		defineRoute: function (event) {
			switch (event) {
			case 'changeStatus' :
				if (this.getRole === 'user') {
					(this.statusQueueAddAsterisk === true) ? this.routeAction = '/detalle_eventos/queuePause' : this.routeAction = '/detalle_eventos/queueAdd'
				} else this.routeAction = '/detalle_eventos/registrarDetalle'
				break
			case 'releasesAnnexed' :
				this.routeAction = '/anexos/liberarAnexoOnline'
				break
			case 'assignAnnexed' :
				this.routeAction = '/anexos/asignarAnexo'
				break
			case 'disconnectAgent' :
				(this.statusQueueAddAsterisk === true) ? this.routeAction = '/detalle_eventos/queueRemove' : this.routeAction = '/anexos/logout'
				break
			case 'checkAssistance' :
				this.routeAction = '/detalle_eventos/registerAssistence'
				break
			}
		},

		changeStatus: function (eventId, eventName, eventStatusPause) {
            const arrayEventRing = ['12','13','18','21','24','27']
            if(arrayEventRing.includes(this.getEventId)){
                this.ModalChangeStatus = 'modal fade'
                showNotificacion('error', 'No puede cambiar de evento, ya que acaba de ingresarle una llamada', 'Warning', 10000, false, true)
            } else {
                this.ModalChangeStatus = 'modal fade'
                this.defineRoute('changeStatus')
                this.nextEventId = eventId
                this.nextEventName = eventName
                this.eventStatusPause = eventStatusPause
                this.remoteAgentHour = this.hourServer
                let parameters = this.loadParameters('changeStatus')
                ajaxNodeJs(parameters, this.routeAction, true, 2000)
            }
		},

		assignAnnexed: function () {
			this.defineRoute('assignAnnexed')
			this.nextEventId = this.getEventId
			let parameters = this.loadParameters('assignAnnexed')
			ajaxNodeJs(parameters, this.routeAction, true, 2000)
			this.loadOptionMenu('agents_annexed')
		},

        liberarAnexos: function () {
            let isVerifyAnnexed = (this.annexed != 0) ? true : false
            let isVerifyStatusVisible = (this.searchStatusVisible(this.getEventId) === 2 && this.getEventId != 11) ? false : true

            if (isVerifyAnnexed && isVerifyStatusVisible) this.ModalReleasesAnnexed = 'modal show'
            if (!isVerifyAnnexed) showNotificacion('error', 'No tiene un anexo asignado', 'Warning', 10000, false, true)
            if (!isVerifyStatusVisible) showNotificacion('error', 'No puedes liberar el anexo, en plena llamada', 'Warning', 10000, false, true)
        },

		releasesAnnexed: function () {
			this.defineRoute('releasesAnnexed')
			this.nextEventId = 11
			this.nextEventName = 'Login'
			this.remoteAgentHour = this.hourServer
			this.annexed = 0
			let parameters = this.loadParameters('releasesAnnexed')
			vueFront.ModalReleasesAnnexed = 'modal fade'
			ajaxNodeJs(parameters, this.routeAction, true, 2000)
			this.loadOptionMenu('agents_annexed')
		},

		activeCalls: async function () {
			let parametersRole = this.loadParameters('activeCalls')
			let response = await this.sendUrlRequest('saveformchangeRole', parametersRole)

			closeNotificationBootstrap()
			if (response.message === 'Success') {
				if (this.getUserId === this.remoteActiveCallsUserId) {
					this.getRole = this.remoteActiveCallsNameRole
					this.statusQueueAddAsterisk = false
					this.remoteActiveCallsNameRole = ''
					this.remoteActiveCallsUserId = ''
				}
				showNotificacion('success', 'El cambio de rol se realizo exitosamente !!!', 'Success', 5000, false, true)
			} else {
				showNotificacion('error', 'Problemas a la  hora de actualizar el rol en la base de datos', 'Error', 10000, false, true)
			}
		},

		disconnectAgent: function () {
			this.defineRoute('disconnectAgent')
			this.nextEventId = 15
			this.nextEventName = 'Desconectado'
			let parameters = this.loadParameters('disconnectAgent')
			ajaxNodeJs(parameters, this.routeAction, true, 2000)
		},

		verifyAssistance: async function () {
			if (this.statusChangeAssistance === true) this.loadModalCheckAssistance()
			else if (this.statusChangeAssistance != false) {
				this.titleStandBy = 'Ventana de Conexión'
				this.messageStandBy = 'Usted ingresara al menú del sistema en :'
				this.loadModalStandByAssistance()
			} else checkPassword()
		},

		loadModalCheckAssistance: async function () {
			let rankHours = await rangoHoras(this.hourServer)
			this.assistanceHour = rankHours[1]
			this.assistanceNextHour = rankHours[2]
			this.ModalAssistance = 'modal show'
		},

		loadModalStandByAssistance: function () {
			this.titleStandBy = 'Ventana de Conexión'
			this.messageStandBy = 'Usted ingresara al menú del sistema en :'
			this.ModalStandByAssistance = 'modal show'
			let refreshIntervalStandBy = setInterval(() => {
				this.differenceHour = restarHoras(this.hourServer, this.assistanceNextHour)
				if (this.hourServer >= this.assistanceNextHour) {
					clearInterval(refreshIntervalStandBy)
					this.ModalStandByAssistance = 'modal fade'
					checkPassword()
				}
			}, 1000)
		},

		checkAssistance: function () {
			let route = (this.assistanceTextModal === 'Entrada') ? 'checkAssistance' : 'disconnectAgent'
			this.defineRoute(route)
			if (route == 'checkAssistance') {
				this.nextEventId = 11
				this.nextEventName = 'Login'
			}
			let parameters = this.loadParameters(route)
			ajaxNodeJs(parameters, this.routeAction, true, 2000)
			this.ModalAssistance = 'modal fade'
		},

		loadParameters: function (actionEvent) {
			let data = []

			if (actionEvent === 'activeCalls') {
				if (this.remoteActiveCallsNameRole === '') data = { nameRole: this.getRole, userId: this.getUserId }
				else data = {nameRole: this.remoteActiveCallsNameRole, userId: this.remoteActiveCallsUserId }
				return data
			}

			data = {
				userID: (this.remotoReleaseUserId === 0) ? this.getUserId : this.remotoReleaseUserId,
				username: (this.remotoReleaseUsername === 0) ? this.getUsername : this.remotoReleaseUsername,
				userRol: this.getRole,
				eventID: this.getEventId,
				eventNextID: this.nextEventId,
				eventNextName: this.nextEventName,
				eventFechaHora: `${this.dateServer} ${this.remoteAgentHour}`,
				eventDateReally: `${this.dateServer} ${this.hourServer}`,
				eventIPCliente: this.getRemoteIp,
				eventAnnexed: (this.remotoReleaseAnnexed === 0) ? this.annexed : this.remotoReleaseAnnexed,
				typeActionPostRequest: actionEvent,
				eventStatusPause: this.eventStatusPause,
				statusQueueRemove: (this.remotoReleaseStatusQueueRemove === false) ? this.statusQueueAddAsterisk : this.remotoReleaseStatusQueueRemove
			}
			return data
		},

		loadOptionMenu: async function (idMenu) {
			if (idMenu === "activate_calls") activeCalls()
			else {
				$('#container').html('<div class="loading" id="loading" style="display: inline;"><li></li><li></li><li></li><li></li><li></li></div>')
				$('#container').html(await this.sendUrlRequest(`/${idMenu}`))
			}
		},

		searchNameEvent: function (eventID) {
			if(this.getListEvents.length != 0){
				if (eventID) {
					let index = parseInt(eventID) - 1
					return this.getListEvents[index]['name']
				}
			}
		},

        searchStatusVisible: function (eventID) {
            if(this.getListEvents.length != 0){
                if (eventID) {
                    let index = parseInt(eventID) - 1
                    return this.getListEvents[index]['estado_visible_id']
                }
            }
        },
	}
})

socketNodejs.on('connect', function () {
	vueFront.nodejsServerName = 'Servidor Nodejs'
	vueFront.ModalConnectionNodeJs = 'modal fade'
	vueFront.nodejsServerMessage = 'Acabas de conectar con el Servidor Nodejs'
	if (vueFront.nodejsServerStatus === 'inactivo') {
		vueFront.loadVariablesGlobals()
		vueFront.nodejsServerStatus = 'activo'
	}
	console.log('socketNodejs connected!')
})

socketNodejs.on('connect_error', function () {
	vueFront.nodejsServerName = 'Servidor Nodejs'
	vueFront.ModalConnectionNodeJs = 'modal show'
	let i = 9
	let refreshIntervalId = setInterval(() => {
		vueFront.nodejsServerMessage = `Fallo la conexión con el socket del Server NodeJS volveremos a reintentar en ${i} segundos!!!`
		i--
		if (i === 0) clearInterval(refreshIntervalId)
	}, 1000)
	console.log('socketNodejs Connection Failed')
})

socketNodejs.on('disconnect', function () {
	vueFront.nodejsServerName = 'Servidor Nodejs'
	vueFront.ModalConnectionNodeJs = 'modal show'
	vueFront.nodejsServerMessage = 'Acabas de perder conexión con el socket del Server Nodejs !!!'
	vueFront.nodejsServerStatus = 'inactivo'
	console.log('socketNodejs Disconnected')
})

socketNodejs.on('datetime', function (data) {
    vueFront.hourServer = data.datetime
})

// Cambia la etiqueta de estado actual cuando este recibe o realiza un llamada
socketNodejs.on('statusAgent', (data) => {
	vueFront.sendUrlRequest('/updateStatusAddAgentDashboard')
	vueFront.statusAddAgentDashboard = data.statusAddAgentDashboard
	vueFront.getEventId = data.eventId
	vueFront.annexedStatusAsterisk = data.annexedStatusAsterisk
	vueFront.nextEventId = ''
	vueFront.nextEventName = ''
})

// Cambia la etiqueta del estado actual cada vez que realiza un cambio de estado
socketSails.on('statusSails', function (data) {
	vueFront.ModalLoading = 'modal fade'
	vueFront.getEventId = data.eventId
	vueFront.nextEventId = ''
	vueFront.nextEventName = ''
})

socketSails.on('connect', function () {
	vueFront.nodejsServerName = 'Servidor Sails'
	vueFront.ModalConnectionNodeJs = 'modal fade'
	vueFront.nodejsServerMessage = 'Acabas de conectar con el Servidor Sails'
	console.log('Socket Sails.io connected!')
})

socketSails.on('disconnect', function () {
	vueFront.nodejsServerName = 'Servidor Sails'
	vueFront.ModalConnectionNodeJs = 'modal show'
	vueFront.nodejsServerMessage = 'Acabas de perder conexión con el Servidor Sails'
	console.log('Socket Sails.io desconectado!')
})
