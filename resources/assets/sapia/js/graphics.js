let parameter01 = {
  namePanel: 'abandonedCalls',
  title: 'Abandoned Calls',
  subTitle: 'Proyect: Sapia',
  titleSeriesY: 'Minutes',
  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'],
  seriesData: [{
        name: 'Aban > 5',
        data: [7, 14,21, 31, 41, 60,55, 12, 23.3, 18.3, 13.9, 9.6]
    },{
        name: 'Aban > 10',
        data: [70, 4,11, 21, 21, 66,45, 12, 23.3, 18.3, 13.9, 9.6]
    }
  ]
}

let parameter02 = {
  namePanel: 'averageAttention',
  title: 'Average Time for Online Attention',
  subTitle: 'Proyect: Sapia',
  titleSeriesY: 'Minutes',
  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'],
  seriesData: [{
        name: 'Aban > 5',
        data: [7, 14,21, 31, 41, 60,55, 12, 23.3, 18.3, 13.9, 9.6]
    },{
        name: 'Aban > 10',
        data: [70, 4,11, 21, 21, 66,45, 12, 23.3, 18.3, 13.9, 9.6]
    },
    {
        name: 'Aban > 20',
        data: [22, 30,40,50,60,70,45,59,62,75,39,25]
    }
  ]
}

let parameterBar = {
  namePanel: 'answeredCallsQueue',
  title: 'Answered Calls by Queues',
  subtitle:'Proyect: Sapia',
  text1: 'Answered Calls by Queues (Minutes)',
  valueSuffix1: ' Minutes',
  categoriesX: ['cola-1', 'cola-2', 'cola-3'],
  seriesData: [{
        name: 'cola-1',
        data: [7, 14,21]
    },{
        name: 'cola-2',
        data: [55, 4,41]
    },
    {
        name: 'cola-3',
        data: [22, 30,40]
    }
  ]
}


let parameterBarVertical = {
  namePanel: 'attendedAbandoned',
  title: 'Attended Calls  vs Abandoned Calls',
  subtitle: 'Proyect: Sapia',
  categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
  textY: 'Minutes (min)',
  series: [{
      name: 'Cola-1',
      data: [29,38,50,26,13,53,50,34,25,43,28,36]

  }, {
      name: 'Cola-2',
      data: [35,52,19,54,10,30,12,18,39,9,4,47]

  }, {
      name: 'Cola-3',
      data: [10,50,54,55,38,27,58,22,19,30,25,37]

  }, {
      name: 'Abandonadas',
      data: [18,22,14,18,13,23,14,14,11,28,21,15]
  }]
}

let generateHighCharts = (namePanel, parameter) => {
  Highcharts.chart(namePanel, parameter);
}

let generateLineGraph = (data) => {
  const parameter = {
      chart: {
          type: 'line'
      },
      title: {
          text: data.title
      },
      subtitle: {
          text: data.subTitle
      },
      xAxis: {
          categories: data.categories
      },
      yAxis: {
          title: {
              text: data.titleSeriesY
          }
      },
      plotOptions: {
          line: {
              dataLabels: {
                  enabled: true
              },
              enableMouseTracking: true
          }
      },
      series: data.seriesData
  }

  generateHighCharts(data.namePanel, parameter)
}

let generateBarGraph = (data) => {
  const parameter = {

    chart: {
            type: 'bar'
        },
        title: {
            text: data.title
        },
        subtitle: {
            text: data.subtitle
        },
        xAxis: {
            categories: data.categoriesX,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: data.text1,
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: data.valueSuffix1
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: data.seriesData

  }

  generateHighCharts(data.namePanel, parameter)
}

let generateBarVerticalGraph = (data) => {
  const parameter = {
    chart: {
            type: 'column'
        },
        title: {
            text: data.title
        },
        subtitle: {
            text: data.subtitle
        },
        xAxis: {
            categories: data.categories,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: data.textY
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} min</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        credits: {
            enabled: false
        },
        series: data.series

  }

  generateHighCharts(data.namePanel, parameter)
}
