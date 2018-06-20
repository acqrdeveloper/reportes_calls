Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="_token"]').getAttribute('content')
Vue.component('v-select', VueSelect.VueSelect)

const socketNodejs = io.connect(restApiDashboard, {
    'reconnection': true,
    'reconnectionAttempts': 15,
    'reconnectionDelay': 9000,
    'reconnectionDelayMax': 9000
})

const dashboard = new Vue({
    el: '#dashboard',
    data: {
        callsInbound: [],
        callsOutbound: [],
        callsWaiting: [],
        others: [],
        filterRoles: ['User'],
        rolesPermission: [],

        filterParameters: [],
        agentStatusSummary: [],
        listProfileUsers: [],
        listEventos: [],
        listQueues: [],

        percentageAnswer: '',
        percentageUnanswer: '',
        avgWait: '',
        avgCallDuration: '',
        totalCallDurationInbound: '',
        totalCallDurationOutbound: '',

        answeredMonth: '0',
        answeredTimeMonth: '0',
        slaMonth: '0',

        slaDay: '0',
        answered: '0',
        abandoned: '0',
        totalCallsWaiting: '0',

        answeredTime: '0',
        abandonedTime: '0',

        abandonedSymbol: '',
        answeredSymbol: '',

        abandonedSecond: '',
        answeredSecond: '',

        ModalConnectionNodeJs: 'modal fade',
        nodejsServerName: '',
        nodejsServerMessage: '',
        nodejsServerStatus: 'activo',

        dateServer:'-',
        hourServer: '-',
        textDateServer: '-',
        routeMusicQueue: '-'
    },
    created () {
        this.loadVariablesGlobals()
        this.loadMetricasKpi(true)
    },
    computed: {
        getTotalCallsWaiting: function () {
            return this.totalCallsWaiting
        }
    },
    mounted(){
        this.initialization()
        this.loadQueues()
    },
    methods: {
        loadQueues: async function () {
            let response = await this.sendUrlRequest('dashboard_01/getListQueues')
            this.listQueues = response.listQueues
        },
        loadMetricasKpi: async function (viewLoad) {
            if (viewLoad) {
                this.answered = '-'
                this.abandoned = '-'
                this.answeredTime = '-'
                this.abandonedTime = '-'
                this.slaDay = '-'
            }

            //this.panelAgentStatusSummary()
            //this.panelGroupStatistics()
            await this.loadAllKpisDay()
            await this.loadSlaDay()

            await this.loadAllKpisMonth()
            await this.loadSlaMonth()
        },

        loadTimeElapsed: function (index, dataDashboard, namePanel) {
            setInterval(async function () {
                if (dataDashboard[index]) {
                    const horaBD = await this.getEventTime(index, dataDashboard, namePanel)
                    const currenTime = (new Date(`${this.dateServer} ${this.hourServer}`)).getTime()
                    const elapsed = differenceHours(currenTime - horaBD)
                    if (elapsed != 'NaN:NaN:NaN') dataDashboard[index].timeElapsed = elapsed
                }
            }.bind(this), 1000)
        },

        getEventTime: function (index, dataDashboard, namePanel) {
            if (namePanel === 'callsInbound') return dataDashboard[index].inbound_start
            if (namePanel === 'callsOutbound') return dataDashboard[index].outbound_start
            if (namePanel === 'others') return dataDashboard[index].event_time
        },

        loadTimeElapsedEncoladas: function (index) {
            let calcular = () => {
                let horaInicio = (new Date()).getTime()
                let horaFin = this.callsWaiting[index].start_call
                this.callsWaiting[index].timeElapsed = differenceHours(horaInicio - horaFin)
            }
            setInterval(calcular(), 1000)
        },

        // Funcion para traer data de los controladores
        sendUrlRequest: async function (url, filterParameters) {
            let response = await this.$http.post(url, filterParameters)
            return response.data
        },

        loadAllKpisDay: async function () {
            let response = await this.sendUrlRequest('dashboard_01/getEventKpi', { rangeDateSearch: 'forDay' })

            this.abandoned = response[0].calls_abandone.message
            this.answered = response[0].calls_completed.message

            this.answeredTime = response[0].calls_completed_time.message
            this.answeredSecond = response[0].calls_completed_time.time
            this.answeredSymbol = response[0].calls_completed_time.symbol

            this.abandonedTime = response[0].calls_abandone_time.message
            this.abandonedSecond = response[0].calls_abandone_time.time
            this.abandonedSymbol = response[0].calls_abandone_time.symbol
        },

        loadSlaDay: function () {
            let answered = this.answered
            let answeredTime = this.answeredTime
            this.slaDay = 0
            if (answered !== 0) this.slaDay = ((answeredTime * 100) / answered).toFixed(2)
        },

        loadAllKpisMonth: async function () {
            let response = await this.sendUrlRequest('dashboard_01/getEventKpi', { rangeDateSearch: 'forMonth' })

            this.answeredMonth = response[0].calls_completed.message
            this.answeredTimeMonth = response[0].calls_completed_time.message
        },

        loadSlaMonth: function () {
            let answeredMonth = this.answeredMonth
            let answeredTimeMonth = this.answeredTimeMonth
            this.slaMonth = 0
            if (answeredMonth !== 0) this.slaMonth = ((answeredTimeMonth * 100) / answeredMonth).toFixed(2)
        },

        loadVariablesGlobals: async function () {
            let response = await this.sendUrlRequest('dashboard_01/getVariablesGlobals')
            this.listProfileUsers = response.listAllUserProfile
            this.listEventos = response.listAllEventos
            this.dateServer = response.dateServer
            this.hourServer = response.hourServer
            this.textDateServer = response.textDateServer
            if (response) {
                this.loadCurrenTime()
                this.refreshDetailsCalls()
            }
        },

        loadCurrenTime: function () {
            setTimeout(function () {
                let hourServer = this.hourServer.split(':')
                let hora = parseInt(hourServer[0])
                let minuto = parseInt(hourServer[1])
                let segundo = parseInt(hourServer[2])
                segundo = segundo + 1
                if (segundo == 60) {
                    minuto = minuto + 1
                    segundo = 0
                    if (minuto == 60) {
                        minuto = 0
                        hora = hora + 1
                        if (hora == 24) {
                            hora = 0
                        }
                    }
                }
                let str_hora = ''
                let str_minuto = ''
                let str_segundo = ''
                str_hora = new String(hora)
                str_minuto = new String(minuto)
                str_segundo = new String(segundo)
                if (str_hora.length == 1) hora = '0' + hora
                if (str_minuto.length == 1) minuto = '0' + minuto
                if (str_segundo.length == 1) segundo = '0' + segundo
                this.hourServer = hora + ':' + minuto + ':' + segundo
                this.loadCurrenTime()
            }.bind(this), 1000)

        },

        loadCallWaiting: function () {
            // this.queue = 15
        },

        panelAgentStatusSummary: async function () {
            let response = await this.sendUrlRequest('dashboard_01/panelAgentStatusSummary', { filterRoles: this.filterRoles })
            let result = response.message
            let eventList = getRulers('event_id')
            result.forEach((item) => {
                item.color = eventList[item.event_id].color
                item.icon = eventList[item.event_id].icon
            })
            result = await orderObjects(result, 'event_id', eventList) // Ordena por regla establecida
            this.agentStatusSummary = result
        },

        panelGroupStatistics: async function () {
            let response = await this.sendUrlRequest('dashboard_01/panelGroupStatistics')
            this.avgWait = response.avgWait
            this.avgCallDuration = response.avgCallDuration
            this.percentageAnswer = response.percentageAnswer
            this.percentageUnanswer = response.percentageUnanswer
            this.totalCallDurationInbound = response.totalCallDurationInbound
            this.totalCallDurationOutbound = response.totalCallDurationOutbound
        },

        compareRole: function (role) {
            let permission = false
            this.rolesPermission.forEach((index) => {
                index.forEach((roleName) => {
                    let miniName = roleName.toLowerCase()
                    if (role === miniName) permission = true
                })
            })
            return permission
        },

        loadRolePermission: function (val) {
            let cookieRole = this.replaceCookieArray(Cookies.get('roleCookie'))
            Cookies.set('roleCookie', val, {expires: timeDaycookie, path: ''})
            this.rolesPermission.push(val)
            this.panelAgentStatusSummary()
        },

        initialization: function () {
            const cookieRole = this.replaceCookieArray(Cookies.get('roleCookie'))
            this.filterRoles = ['User']
            if (cookieRole) {
                if (cookieRole.toString().length !== 0) this.filterRoles = cookieRole
            }
        },

        // Refresca la informacion de la tabla de DetailsCalls
        refreshDetailsCalls: function () {
            this.callsInbound = []
            this.callsOutbound = []
            this.callsWaiting = []
            this.others = []
            socketNodejs.emit('createRoomDashboard', {nameProyect: nameProyecto})
            socketNodejs.emit('listDataDashboard', {nameProyect: nameProyecto})
            socketNodejs.emit('listCallsWaiting', {nameProyect: nameProyecto})
        },

        replaceCookieArray: function (cookie) {
            if (cookie) {
                let firstCookie = cookie.replace(/"/g, '')
                let secondCookie = firstCookie.replace('[', '')
                let thirdCookie = secondCookie.replace(']', '')
                return thirdCookie.split(',')
            }
        },

        searchInformationProfile: function (data, index,namePanel) {
            if (data) {
                let role =  this.listProfileUsers[data.agent_user_id]['role']
                let avatar = this.listProfileUsers[data.agent_user_id]['avatar']
                let nameComplete = this.listProfileUsers[data.agent_user_id]['nameComplete']

                if (namePanel === 'callsInbound') {
                    this.callsInbound[index].role = role
                    this.callsInbound[index].avatar = avatar
                    this.callsInbound[index].nameComplete = nameComplete
                }

                if (namePanel === 'callsOutbound') {
                    this.callsOutbound[index].role = role
                    this.callsOutbound[index].avatar = avatar
                    this.callsOutbound[index].nameComplete = nameComplete
                }

                if (namePanel === 'others') {
                    this.others[index].role = role
                    this.others[index].avatar = avatar
                    this.others[index].nameComplete = nameComplete
                }
            }
        },

        searchNameEvent: function (eventID) {
            if (eventID) {
                let index = parseInt(eventID) - 1
                return this.listEventos[index]['name']
            }
        },

        musicQueues: function () {
            let listCallWaiting = this.callsWaiting
            this.listQueues.forEach((item, index) => {
                this.listQueues[index].totalWaiting = (Object.keys(listCallWaiting).filter(key => (listCallWaiting[key].name_queue === item.name) ? true : false)).length
            })
            Object.keys(this.listQueues).filter(key => this.listQueues[key].totalWaiting != 0 ? true : false).some((item, index) => {
                if(this.listQueues[item].totalWaiting >= this.listQueues[item].limit_call_waiting) {
                    this.routeMusicQueue = this.listQueues[item].music.route_music
                    setTimeout(function() { dashboard.$refs.audioElm.play() },800)
                }else{
                    setTimeout(function() { dashboard.$refs.audioElm.pause() },800)
                }
            })
            if(this.callsWaiting.length === 0) setTimeout(function() { dashboard.$refs.audioElm.pause() },800)
        },
    }
})

socketNodejs.on('connect', function () {
    dashboard.ModalConnectionNodeJs = 'modal fade'
    if (dashboard.nodejsServerStatus === 'inactivo') {
        dashboard.refreshDetailsCalls()
        dashboard.nodejsServerStatus = 'activo'
    }
    console.log('Socket Nodejs connected!')
})

socketNodejs.on('datetime', function (data) {
    dashboard.hourServer = data.datetime
})

socketNodejs.on('connect_error', function () {
    dashboard.nodejsServerName = 'Servidor Nodejs'
    dashboard.ModalConnectionNodeJs = 'modal show'
    let i = 9
    let refreshIntervalId = setInterval(() => {
        dashboard.nodejsServerMessage = `Fallo la conexión con el socket del Server NodeJS volveremos a reintentar en ${i} segundos!!!`
        i--
        if (i === 0) clearInterval(refreshIntervalId)
    }, 1000)
    console.log('socketNodejs Connection Failed')
})

socketNodejs.on('disconnect', function () {
    dashboard.nodejsServerName = 'Servidor NodeJS'
    dashboard.ModalConnectionNodeJs = 'modal show'
    dashboard.nodejsServerMessage = `Acabas de perder conexión con el socket del Server Nodejs !!!`
    dashboard.nodejsServerStatus = 'inactivo'
    console.log('socket Nodejs Disconnected')
})

const objectFindByKey = (array, key, value) => {
    for (let i = 0; i < array.length; i++) {
        if (array[i][key] === value) return false
    }
    return true
}

socketNodejs.on('AddCallWaiting', dataCallWaiting => {
    if(objectFindByKey(dashboard.callsWaiting, 'unique_id', dataCallWaiting.unique_id)){
        dashboard.callsWaiting.push(dataCallWaiting)
        dashboard.totalCallsWaiting = (dashboard.callsWaiting).length
    }
    dashboard.musicQueues()
})

socketNodejs.on('RemoveCallWaiting', dataCallWaiting => {
    let uniqueID = dataCallWaiting.unique_id
    dashboard.callsWaiting.forEach((item, index) => {
        if (item.unique_id === uniqueID) dashboard.callsWaiting.splice(index, 1)
    })
    dashboard.totalCallsWaiting = (dashboard.callsWaiting).length
    dashboard.musicQueues()
})

socketNodejs.on('RemoveOther', dataOther => removeDataDashboard(dataOther, dashboard.others, 'others'))
socketNodejs.on('UpdateOther', dataOther => updateDataDashboard(dataOther, dashboard.others, 'others'))
socketNodejs.on('AddOther', dataOther => AddDataDashboard(dataOther, dashboard.others, 'others'))

socketNodejs.on('RemoveOutbound', dataOutbound => removeDataDashboard(dataOutbound, dashboard.callsOutbound, 'callsOutbound'))
socketNodejs.on('UpdateOutbound', dataOutbound => updateDataDashboard(dataOutbound, dashboard.callsOutbound, 'callsOutbound'))
socketNodejs.on('AddOutbound', dataOutbound => AddDataDashboard(dataOutbound, dashboard.callsOutbound, 'callsOutbound'))

socketNodejs.on('RemoveInbound', dataInbound => removeDataDashboard(dataInbound, dashboard.callsInbound, 'callsInbound'))
socketNodejs.on('UpdateInbound', dataInbound => updateDataDashboard(dataInbound, dashboard.callsInbound, 'callsInbound'))
socketNodejs.on('AddInbound', dataInbound => AddDataDashboard(dataInbound, dashboard.callsInbound, 'callsInbound'))

const removeDataDashboard = (data, dataDashboard) => {
    dataDashboard.forEach((item, index) => {
        if (item.agent_name === data.agent_name) dataDashboard.splice(index, 1)
    })
    dashboard.panelAgentStatusSummary()
}

const updateDataDashboard = (data, dataDashboard, namePanel) => {
    dataDashboard.forEach(async (item, index) => {
        if (item.agent_name === data.agent_name) {
            if (item.event_id !== data.event_id) {
                let eventList = getRulers('event_id')
                data.color = eventList[data.event_id].color
                data.icon = eventList[data.event_id].icon
                dataDashboard.splice(index, 1, data)
                dashboard.loadMetricasKpi(false)
                dashboard.loadTimeElapsed(index, dataDashboard, namePanel)
                dataDashboard[index].total_calls = await getTotalCalls(data)
            }
            item.agent_annexed = data.agent_annexed
            item.event_name = data.event_name
            item.agent_status = data.agent_status
            orderDashboard(dataDashboard, namePanel)
        }
    })
    dashboard.panelAgentStatusSummary()
    dashboard.panelGroupStatistics()
}

const AddDataDashboard = async (data, dataDashboard, namePanel) => {
    let exist = isExistDuplicate(data, dataDashboard)
    if (exist) {
        let index = (dataDashboard.length)
        let eventList = getRulers('event_id')
        data.color = eventList[data.event_id].color
        data.icon = eventList[data.event_id].icon
        dataDashboard.push(data)
        orderDashboard(dataDashboard, namePanel)
        dashboard.loadTimeElapsed(index, dataDashboard, namePanel)
        dataDashboard[index].total_calls = await getTotalCalls(data)
        dashboard.panelAgentStatusSummary()
        dashboard.panelGroupStatistics()
    }
}

const getTotalCalls = async (data) => {
    let response = await dashboard.sendUrlRequest('dashboard_01/getQuantityCalls', { nameAgent: data.agent_name })
    return response.message
}

const differenceHours = (s) => {
    function addZ (n) {
        return (n < 10 ? '0' : '') + n
    }

    let ms = s % 1000
    s = (s - ms) / 1000
    let secs = s % 60
    s = (s - secs) / 60
    let mins = s % 60
    let hrs = (s - mins) / 60

    return addZ(hrs) + ':' + addZ(mins) + ':' + addZ(secs)
}

const isExistDuplicate = (data, dataDashboard) => {
    let exist = true
    if (dataDashboard.length > 0) {
        dataDashboard.forEach((item) => {
            if (item.agent_name == data.agent_name) exist = false
        })
    }
    return exist
}

const orderDashboard = async (dataDashboard, namePanel) => {
    if (namePanel !== '') {
        let newObject = await orderObjects(dataDashboard, 'event_time') // Ordena alfabeticamente
        newObject = await orderObjects(newObject, 'event_id', getRulers('event_id')) // Ordena por regla establecida
        newObject = await orderObjects(newObject, 'agent_role', getRulers('agent_role')) // Ordena por regla establecida
        eval('dashboard.' + namePanel + '= newObject')
    }
}

const orderObjects = (object, column, rulers = '') => {
    let newObject = []
    let indexObject = []
    object.forEach(function (objectPrimary, indexPrimary) {
        let menorIndex = indexPrimary
        let menorObject = objectPrimary
        object.forEach((objectSecond, indexSecond) => {
            if (indexObject.indexOf(menorIndex) < 0) {
                if (indexObject.indexOf(indexSecond) < 0) {
                    if (menorIndex != indexSecond) {
                        let primervalor = (rulers !== '') ? rulers[menorObject[column]].position : menorObject[column]
                        let segundovalor = (rulers !== '') ? rulers[objectSecond[column]].position : objectSecond[column]
                        if (primervalor === segundovalor) {
                            if (indexSecond > menorIndex) {
                                menorIndex = menorIndex
                                menorObject = menorObject
                            } else {
                                menorIndex = indexSecond
                                menorObject = objectSecond
                            }
                        } else if (primervalor > segundovalor) {
                            menorIndex = indexSecond
                            menorObject = objectSecond
                        }
                    }
                }
            } else {
                menorIndex = indexSecond
                menorObject = objectSecond
            }
        })
        indexObject.push(menorIndex)
        newObject[indexPrimary] = menorObject
    })
    return newObject
}

const getRulers = (action) => {
    let rulers = ''
    if (action === 'event_id') {
        rulers = {
            '12': {'icon': 'fa fa-volume-up', 'color': 'success', 'position': 1},  // Ring Inbound
            '16': {'icon': 'fa fa-bell-slash', 'color': 'danger', 'position': 2},  // Hold Inbound
            '8': {'icon': 'fa fa-phone', 'color': 'success', 'position': 3},  // Inbound
            '13': {'icon': 'fa fa-volume-up', 'color': 'primary', 'position': 4},  // Ring Outbound
            '17': {'icon': 'fa fa-bell-slash', 'color': 'danger', 'position': 5},  // Hold Outbound
            '9': {'icon': 'fa fa-headphones', 'color': 'warning', 'position': 6},  // Outbound
            '18': {'icon': 'fa fa-volume-up', 'color': 'default', 'position': 7},  // Ring Inbound Interno
            '22': {'icon': 'fa fa-bell-slash', 'color': 'default', 'position': 8},  // Hold Inbound Interno
            '19': {'icon': 'fa fa-phone', 'color': 'default', 'position': 9},  // Inbound Interno
            '24': {'icon': 'fa fa-volume-up', 'color': 'default', 'position': 10},  // Ring Inbound Transfer
            '26': {'icon': 'fa fa-bell-slash', 'color': 'default', 'position': 11},  // Hold Inbound Transfer
            '25': {'icon': 'fa fa-phone', 'color': 'default', 'position': 12},  // Inbound Transfer
            '21': {'icon': 'fa fa-volume-up', 'color': 'default', 'position': 13},  // Ring Outbound Interno
            '23': {'icon': 'fa fa-bell-slash', 'color': 'default', 'position': 14},  // Hold Outbound Interno
            '20': {'icon': 'fa fa fa-headphones', 'color': 'default', 'position': 15},  // Outbound Interno
            '27': {'icon': 'fa fa-volume-up', 'color': 'default', 'position': 10},  // Ring Outbound Transfer
            '28': {'icon': 'fa fa-bell-slash', 'color': 'default', 'position': 11},  // Hold Outbound Transfer
            '29': {'icon': 'fa fa-phone', 'color': 'default', 'position': 12},  // Outbound Transfer
            '1': {'icon': 'fa fa-fax', 'color': 'info', 'position': 16},  // ACD
            '7': {'icon': 'fa fa-suitcase', 'color': 'primary', 'position': 17},  // Gestión BackOffice
            '2': {'icon': 'fa fa-star', 'color': 'primary', 'position': 18},  // Break
            '4': {'icon': 'fa fa-cutlery', 'color': 'primary', 'position': 19}, // Refrigerio
            '3': {'icon': 'fa fa-asterisk', 'color': 'primary', 'position': 20}, // SSHH
            '5': {'icon': 'fa fa-retweet', 'color': 'danger', 'position': 21}, // Feedback
            '6': {'icon': 'fa fa-book', 'color': 'danger', 'position': 22}, // Capacitación
            '11': {'icon': 'fa fa-home', 'color': 'default', 'position': 23}  // Login
        }
    }

    if (action === 'agent_role') {
        rulers = {
            'user': {'position': 1},
            'backoffice': {'position': 2},
            'supervisor': {'position': 3},
            'admin': {'position': 4},
            'cliente': {'position': 5},
            'calidad': {'position': 6}
        }
    }
    return rulers
}