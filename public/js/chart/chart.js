// $(document).on('click', 'p.coin', function() {
//     $('p.coin').each(function() {
//         $(this).removeClass('coin_select');
//     });
//     $(this).addClass('coin_select'); 
//     $('span.coin_select_name').text($(this)[0].innerText);
//     $('p.coin_select').removeClass('display-hide');
//     //console.log($(this)[0].firstChild.currentSrc);
//     $('.coin_select_img').attr('src', $(this)[0].firstChild.currentSrc);

//     //$.getJSON('js/chart/data.json', function (data) {

//         // split the data set into ohlc and volume
//         var ohlc = [],
//             volume = [],
//             dataLength = data.length,
//             // set the allowed units for data grouping
//             groupingUnits = [[
//                 'week',                         // unit name
//                 [1]                             // allowed multiples
//             ], [
//                 'month',
//                 [1, 2, 3, 4, 6]
//             ]],
    
//             i = 0;
    
//         for (i; i < dataLength; i += 1) {
//             ohlc.push([
//                 data[i][0], // the date
//                 data[i][1], // open
//                 data[i][2], // high
//                 data[i][3], // low
//                 data[i][4] // close
//             ]);
    
//             volume.push([
//                 data[i][0], // the date
//                 data[i][5] // the volume
//             ]);
//         }
    
//         var coincolour = '#74BC2A';
//         var midcolour = '#94CB5B';
//         var midlight = '#B4DB8D';
//         var lightcolour = '#D5EABF';
//         // create the chart
//         Highcharts.stockChart('container', {
//             chart: {
//                 type: 'candlestick',
//                 marginLeft: 40, // Keep all charts left aligned
//                 spacingTop: 20,
//                 spacingBottom: 20,
//                 zoomType: 'x',
//                 backgroundColor: midlight,
//                 borderColor: coincolour,
//                 borderWidth: 6
//             },
//             title: {    
//               text: null,
//             },
//             credits: {
//               enabled: false
//             },
//             legend: {
//               enabled: false
//             },
//             exporting: {
//               enabled: false
//             },
    
    
//             // rangeSelector: {
//             //     selected: 1
//             // },
    
//             rangeSelector: {
//               //enabled: false, // TODO make this apply to top chart only
//               inputBoxBorderColor: coincolour,
//               buttonTheme: {
//                 fill: 'none',
//                 stroke: 'none',
//                 'stroke-width': 0,
//                 r: 8,
//                 style: {
//                   color: coincolour,
//                   fontWeight: 'bold'
//                 },
//                 states: {
//                   hover: {},
//                   select: {
//                     fill: coincolour,
//                     style: {
//                       color: 'white'
//                     }
//                   }
//                   // disabled: { ... }
//                 }
//               },
//             },
    
    
//             xAxis: {
//                 crosshair: true,
//                 plotBands: [{
//                     from: 1153094400000,
//                     to: 1169683200000,
//                     color: midcolour,
//                     }, {
//                     from: 1189382400000,
//                     to: 1197676800000,
//                     color: midcolour,
//                 }, ]
//             },
//             yAxis: [{
//                 gridLineWidth: 0,
//                 labels: {
//                     enabled: false,
//                     align: 'right',
//                     x: -3
//                 },
//                 // title: {
//                 //     text: 'OHLC'
//                 // },
//                 height: '60%',
//                 lineWidth: 2,
//                 resize: {
//                     enabled: true
//                 }
//             }, {
//                 gridLineWidth: 0,
//                 // backgroundColor: coincolour,
//                 // borderWidth: 3,
//                 // borderColor: coincolour,
    
//                 labels: {
//                     enabled: false,
//                     align: 'right',
//                     x: -3
//                 },
//                 // title: {
//                 //     text: 'Volume'
//                 // },
//                 top: '65%',
//                 height: '35%',
//                 offset: 0,
//                 lineWidth: 2
//             }],
    
//             tooltip: {
//                 //enabled: false, // could enable this later for numerical display - needs to handle OHLC 
//                 // positioner: function() {
//                 // return {
//                 //   x: this.chart.chartWidth - this.label.width, // right aligned
//                 //   y: -1 // align to title
//                 // };
//                 //},
//                 borderWidth: 0,
//                 backgroundColor: 'none',
//                 pointFormat: '{point.y}',
//                 headerFormat: '',
//                 shadow: false,
//                 style: {
//                 fontSize: '8px'
//                 },
//                 //valueDecimals: dataset.valueDecimals
//             },
//             plotOptions: {
//               candlestick: {
//                 color: lightcolour, //lightcolour
//                 upColor: coincolour, //colour
//                 lineWidth: 0.3,
//               },
//               column: {
//                 color: coincolour,
//               },
//               series: {
//                 animation: {
//                   //duration: 5000
//                 },
//                 cursor: 'pointer',
//                 // events: {
//                 //   click: function() {
//                 //     alert('You just clicked the graph');
//                 //   }
//                 // }
//               }
//             },
    
    
    
//             series: [{
//                 type: 'candlestick',
//                 name: 'AAPL',
//                 data: ohlc,
//                 dataGrouping: {
//                     units: groupingUnits
//                 }
//             }, {
//                 type: 'column',
//                 name: 'Volume',
//                 data: volume,
//                 yAxis: 1,
//                 dataGrouping: {
//                     units: groupingUnits
//                 }
//             }]
//         });
//     //});
// });


