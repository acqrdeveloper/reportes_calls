/**
 * Created by jdelacruz on 20/09/2017.
 */
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="_token"]').getAttribute('content')
Vue.component('data', {
    props: ['idUser']
})
var userQueueView = new Vue({
    el: '#userQueueView',
    data: {
        UserQueue: []
    },
    computed:{
        getPercentageOfWeightUserQueue() {
            return this.UserQueue.map(function(item) {
                let weightAgent = item.Priority.weight_agent
                return Math.round(100/weightAgent)
            })
        },
        getColorPercentageOfWeightUserQueue() {
            return this.UserQueue.map(function(item) {
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
                    case (percentage > 25 && percentage <= 75):
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
        getColorBadgeOfWeightUserQueue() {
            return this.UserQueue.map(function(item) {
                let color
                let weightAgent = item.Priority.weight_agent
                let percentage = Math.round(100/weightAgent)
                switch (true){
                    case (percentage > 75):
                        color = 'green'
                        break
                    case (percentage > 50 && percentage <= 75):
                        color = 'blue'
                        break
                    case (percentage > 25 && percentage <= 50):
                        color = 'aqua'
                        break
                    case (percentage > 10 && percentage <= 25):
                        color = 'yellow'
                        break
                    case (percentage > 0 && percentage <= 10):
                        color = 'red'
                        break
                    default:
                        color = 'light-blue'
                        break
                }
                return color
            })
        }
    },
    methods: {
        sendUrlRequest: async function (url, filterParameters) {
            let response
            try {
                response = await this.$http.post(url, filterParameters)
            } catch (err) {
                response = {'data': 'error'}
            }
            return response.data
        },
        getQueue: async function() {
            this.UserQueue = await this.getUserQueue()
        },
        getUserQueue: async function () {
            let response = await this.sendUrlRequest('getqueuesUsers', { valueID: this.idUser })
            return response
        }
    }
})