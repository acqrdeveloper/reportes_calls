<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard - Abandonadas</title>
    {{--CDN Styles--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    {{--CDN Scripts--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.3.5"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.js"></script>
</head>
<body>
<div id="app">
    <div class="container-fluid">
        <header>
            {{--<h1 class="text-bold text-muted">Dashboard</h1>--}}
            <br>
                <span class="text-bold text-muted h2">{{env("PROYECT_NAME_COMPLETE")}} - Dashboard</span>
            <br>
            <br>
            <div class="form-inline">
                <label for="">
                    <span v-if="now == selectedDate">Fecha Actual&nbsp;&nbsp;</span>
                    <input v-model="selectedDate" type="date" class="form-control" @change="change()">
                </label>
                <button class="btn btn-info ml-1" @click="fnClick()"><i class="fa fa-refresh"></i></button>
                <label>
                    <select v-model="selectedTimeMinute" class="form-control ml-1" @change="changeReLoad()">
                        <option value="60">1 Hora</option>
                        <option value="30" selected>30 Minutos</option>
                        <option value="15">15 Minutos</option>
                    </select>
                </label>
            </div>
            <hr>
        </header>
        <div class="table-responsive">
            <canvas id="myChart" width="280" height="100%"></canvas>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

        let data1 = [], data2 = [], data3 = [];
        new Vue({
            el:"#app",
            data:()=>({
                now:moment().format("YYYY-MM-DD").toString(),
                selectedDate : moment('2018-01-02').format("YYYY-MM-DD").toString(),
                selectedTimeMinute:30,
                my_interval:null
            }),
            created() {
                // this.timeReLoad();
                // this.my_interval = setInterval(() => {
                //     this.timeReLoad();
                // }, ((this.selectedTimeMinute * 60) * 1000));//5 minutos
                window.clearInterval(this.my_interval);
                this.changeReLoad();
            },
            methods: {
                changeReLoad(){
                    window.clearInterval(this.my_interval);
                    this.timeReLoad();
                    this.my_interval = setInterval(() => {
                        this.timeReLoad();
                    }, ((this.selectedTimeMinute * 60) * 1000));//30 minutos
                },
                timeReLoad(){
                    data1 = [];
                    data2 = [];
                    data3 = [];
                    this.load1();
                    this.load2();
                    this.load3();
                    setTimeout(()=>{
                        this.load();
                    },1000);
                },
                load() {
                    let ctx = document.getElementById("myChart").getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: [
                                "00:00 - 01:00",
                                "01:00 - 02:00",
                                "02:00 - 03:00",
                                "03:00 - 04:00",
                                "04:00 - 05:00",
                                "05:00 - 06:00",
                                "06:00 - 07:00",
                                "07:00 - 08:00",
                                "08:00 - 09:00",
                                "09:00 - 10:00",
                                "10:00 - 11:00",
                                "11:00 - 12:00",
                                "12:00 - 13:00",
                                "13:00 - 14:00",
                                "14:00 - 15:00",
                                "15:00 - 16:00",
                                "16:00 - 17:00",
                                "17:00 - 18:00",
                                "18:00 - 19:00",
                                "19:00 - 20:00",
                                "20:00 - 21:00",
                                "21:00 - 22:00",
                                "22:00 - 23:00",
                                "23:00 - 00:00",
                            ],
                            datasets: [
                                {
                                label: 'Abandonadas x Hora',
                                data: data1,
                                backgroundColor: "transparent",
                                borderColor: '#2196F3',
                                borderWidth: 2
                            },
                                {
                                    label: 'Abandonadas 10S',
                                    data: data2,
                                    backgroundColor: "transparent",
                                    borderColor: '#FF9800',
                                    borderWidth: 2
                                },
                                {
                                    label: 'Abandonadas',
                                    data: data3,
                                    backgroundColor: "transparent",
                                    borderColor: '#F44336',
                                    borderWidth: 2
                                }
                            ]
                        },
                        options: {
                            title: {
                                display: true,
                                text: 'Abandonadas por Hora'
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                        }
                    });
                },
                load1() {
                    this.$http.get('/abandonadasPorHora',{params:{pfecha:this.selectedDate}}).then(r => {
                        $.each(r.data, (k, v) => {
                            $.each(v, (kk, vv) => {
                                data1.push(vv);
                            })
                        });
                    }, e => {
                        console.error(e.response);
                    });
                },
                load2() {
                    this.$http.get('/abandonadasDiez',{params:{pfecha:this.selectedDate}}).then(r => {
                        $.each(r.data, (k, v) => {
                            $.each(v, (kk, vv) => {
                                data2.push(vv);
                            })
                        });
                    }, e => {
                        console.error(e.response);
                    });
                },
                load3() {
                    this.$http.get('/abandonadasDiff',{params:{pfecha:this.selectedDate}}).then(r => {
                        $.each(r.data,  (k, v) => {
                            $.each(v,  (kk, vv) => {
                                data3.push(vv);
                            })
                        });
                    }, e => {
                        console.error(e.response);
                    });
                },
                change(){
                    this.timeReLoad();
                },
                fnClick(){
                    this.selectedDate = this.now;
                    this.change();
                }
            }
        });

        });
    </script>
</div>
</body>
</html>