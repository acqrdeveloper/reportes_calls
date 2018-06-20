/**
 * Created by jdelacruz on 19/09/2017.
 */
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="_token"]').getAttribute('content')
var queuesTask = new Vue({
    el: '#formTaskQueues',
    data: {
        statusTaskOne:      'wait',
        statusTaskTwo:      'wait',
        statusTaskThree:    'wait',
        buttonTask:         'wait'
    },
    methods: {
        sendUrlRequest: async function (url) {
            let response
            try {
                response = await this.$http.post(url)
            } catch (err) {
                response = {'data': 'error'}
            }
            return response.data
        },
        deployTask: async function() {
            this.buttonTask = 'load'
            this.statusTaskOne = await this.oneTask()
            this.statusTaskTwo = await this.secondTask()
            this.statusTaskThree = await this.threeTask()
            this.buttonTask = 'wait'
        },
        oneTask: async function () {
            this.statusTaskOne = 'load'
            let response = await this.sendUrlRequest('exportQueues')
            if(response.message) return response.message
            return response
        },
        secondTask: async function () {
            this.statusTaskTwo = 'load'
            let response = await this.sendUrlRequest('executeSSH')
            console.log(response)
            if(response.message) return response.message
            return response
        },
        threeTask:  async function () {
            this.statusTaskThree = 'load'
            await socketSails.get('/queues/queuesReload', async function (resData, jwRes) {
                this.statusTaskThree = await resData.Response
            }.bind(this))

        }
    }
})