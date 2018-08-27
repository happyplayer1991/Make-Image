@extends('layouts.app')
   
@section('content')
    <div class="container">
        @include('includes.header')
        <table style="width: 1110px; position: fixed; height: 30px; z-index: 999; top: 58px;">
            <thead>
                <th style="width: 385px;"></th>
                <th style="width: 725px;"></th>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 0; !important; vertical-align: top;">
                        <table width='100%'>
                            <thead>
                                <tr class="nav_bar">
                                    <th class="coin_header">Coin</th>
                                    <th class="price_header">Price (7d)</th>
                                    <th class="macd_header">MACD</th>
                                    <th style="width: 10px"></th>
                                </tr>
                            </thead>
                        </table>
                    </td>
                    <td style="padding: 0; !important; vertical-align: top; background-color: #fff;">
                        <table width='100%'>
                            <thead>
                                <tr class="nav_bar">
                                    <th>
                                        <div class="dropdown">
                                            <img class="hamburger dropdown-toggle" data-toggle="dropdown" src="{{asset('img/hamburger.png')}}"/>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Contact Us</a>
                                                <a class="dropdown-item" href="#">Help</a>
                                                <a class="dropdown-item" href="#">About</a>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="position: relative; top: 90px;">
            <thead>
                <th width="35%"></th>
                <th width="65%"></th>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 0; !important; vertical-align: top;">
                        <table width='100%'>
                            <thead>
                            </thead>
                            <tbody >
                                <tr>
                                    <td style="padding: 0" colspan="4">

                                        <table>
                                            <tbody style="height: 1370px; overflow: hidden;" id="coinlists">
                                                @foreach($tickers as $key => $ticker)
                                                    <tr>
                                                        <?php $arr = explode("/", $ticker[0]); ?>
                                                        <input type="hidden" class="<?php echo "ticker".$key ?>" 
                                                            data-ticker="<?php echo $arr[0] ?>"
                                                            data-fullticker="<?php echo $ticker[0] ?>" 
                                                            data-tickerlogosrc="{{ asset('img/').'/'.str_replace('/','_',$ticker[0]).'.png'}}"
                                                        >
                                                        <td class="coin" style="width: 192px;">
                                                            <p class="coin" data-id="<?php echo $key ?>"><img src="{{ asset('img/').'/'.str_replace("/","_",$ticker[0]).'.png'}}" class="coin_img" /><span class="coin_name">{{  $arr[0] }}</span></p>
                                                        </td>
                                                        <td>
                                                            <div class="price" data-id="<?php echo $key ?>" id="<?php echo 'eachcoin'. $key ?>" style="height: 55px; width: 130px">
                                                            </div>
                                                        </td>
                                                        <td >
                                                            <div class="smacd" data-id="<?php echo $key ?>" id="<?php echo 'eachmacd'. $key ?>" style="height: 55px; width: 67px; ">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="<?php echo "block". $key ?>" style="width: 30px; height: 55px;"></div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>                            
                                </tr>

                            </tbody>
                        </table>
                    </td>
                    <td style="padding: 0; !important; vertical-align: top; background-color: #fff;">
                        <table width='100%'>
                            <thead>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 0;">
                                        <div id="container" style="height: 580px; min-width: 310px; margin-top: -1px;" class="chart-container diplay-hide">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0;">
                                        <div id="exchange-part">
                                            <p class="coin" data-id="8">
                                                <img class="coin_img">
                                                <span class="coin_name">NEO</span>
                                                <span class="coin_data_BTC">1.538 BTC</span>
                                                <span class="coin_data_USD">123.98 USD</span>
                                            </p>
                                            <p>
                                                <span class="coin_data_poloniex">Poloniex</span>
                                                <span class="coin_data_binance">Binance</span>
                                            </p>
                                            <div id="exchange-info" style="display:none; height: 600px; margin-bottom: 20px;">
                                            </div>
                                            <p>
                                                <img src="{{asset('img/V.png')}}" class="V-down">
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            
            
        </table>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

        var rotateFlag = false;
        paceOptions = {
            elements: true
        };
        
        // Pace.start(function() {

        // });
        // setTimeout(function(){
        //     Pace.ignore(function(){
        //     });
        // }, 12000);

        function getEquityData_old(data, profitData) {
            /**
            * Structure of data 
            * [ [timestamp, open, high, low, close, macd], [t,o,h,l,c,m] ... ]
            */
            /**
            * Structure of profitData
            * [ [dateOpen, open, high, low, close, macd], [t,o,h,l,c,m] ... ]
            */
            /**
            *  group of squity 
            *  equity = [ [sequity1], [sequity2], ... ]
            */
            equity = []; 
            sequity = [];
            dataLength = data.length;
            profitDataLength = profitData.length;
            if((dataLength == 0) || (profitDataLength == 0)) {
                console.log('empty');
                return;
            }
            //Get firstChartDate, firstDateOpen, firstDateClose
            firstChartDate = data[0][0];
            firstPrice = data[0][1];

            firstDateOpen = profitData[0][0];

            if(firstChartDate < firstDateOpen) {
                price = firstPrice;
            } else if(firstChartDate >= firstDateOpen) {
                price = profitData[0][2] - 1;
            }
            //draw 
            sequity.push(firstChartDate);
            sequity.push(price);
            equity.push(sequity);

            status = 0;
            j = 0;
            dateOpen = 0;
            dateClose = 0;
            priceOpen = 0;
            priceClose = 0;
            for(i=1;i<data.length;i++) {
                stepDate = data[i][0];
            //    console.log('start');
                if(dateClose <= stepDate) {
                if((status == 1) || (status == 0)) {
                        dateOpen = profitData[j][0]; 
                        price = price + (priceClose - priceOpen);
                        j++;
                        status = -1;
                    }
                    if(stepDate <= dateOpen) {
                    sequity.push(stepDate);
                    sequity.push(price);
                    equity.push(sequity);
                    }
                } else if(dateOpen < stepDate) {
                    if((status == -1) || (status == 0)) {
                        dateClose = profitData[j][1];
                        priceOpen = profitData[j][2] - 1;
                        priceClose = profitData[j][3] - 1;
                        price = priceOpen;
                        j++;
                        status = 1;
                    }
                    if(stepDate < dateClose) {
                    sequity.push(stepDate);
                    sequity.push(price);
                    equity.push(sequity);
                    }
                }
            //    console.log('end');
            }
            //console.log(equity);
        }

        /**
         * structure of data: data = [[date, open, high, low, close], [...], ...]
         * structure of profitData: profitData = [[dateOpen, dateClose, priceOpen, priceClose, profit, sold_amount], [...], ...]
         */
        function getEquityData(data, profitData) {
            var equity = [];

            if ((!data.length) || (!profitData.length))
                return;
            //
            // draw first line
            firstChartDate = data[0][0];
            priceOfFirstItem = data[0][1];
            dateOpen  = profitData[0][0];
            priceOpen = profitData[0][2];
            status = 0;
            //profit data
            profitOpen = 0;
            profitClose = 0;
            if(firstChartDate < dateOpen) {
                firstPriceOnChart = priceOpen;
                status = 1; //line
                equity.push(priceOpen);
                profitOpen = priceOpen;
            }
            else if(dateOpen < firstChartDate) {
                firstPriceOnChart = priceOfFirstItem;
            }

            profitIndex = 0;

            for(i = 1; i < data.length; i++) {
                if(data[i][0] <= profitData[profitIndex][0]) {
                    if(status == 1) {
                        equity.push(profitOpen);            
                    }
                }
                else if(data[i][0] < profitData[profitIndex][1]) {
                    equity.push(0);
                }
                else if(data[i][0] >= profitData[profitIndex][1]) {
                    profitClose = profitOpen + profitData[profitIndex][4];
                    equity.push(profitClose);
                    profitOpen = profitClose;
                }
            }

            // output
            //console.log(equity);
        }

        $(document).ready(function() {

            $(window).on('load', function() {
                Pace.ignore(function() {
                });
                // Pace.stop(function() {
                    
                // });
            });

            @foreach ( $tickers as $key => $ticker )
                <?php 
                    $each_chart = 'eachcoin'. $key;
                    $each_macd = 'eachmacd'. $key;
                    $arr = explode("/", $ticker[0]);
                ?>
                tickername = "<?php echo ($arr[1]) ?>";
                testdata = "<?php echo ($ticker[1]) ?>"; //json data ['timestamps', 'open', 'high', 'low', 'close', 'macd']
                colour = <?php echo ($ticker[2]) ?>;     //colours ['colour', 'midColour,'midLight', 'lightColour']
                data = JSON.parse(testdata);

                blockClass = ".block" + "<?php echo $key ?>";
                $(blockClass).css('background-color', colour[0]);

                close = []; //close data
                smacd = []; //smacd data
                // console.log('start');
                // for(i = 0; i < data.length ; i++) {
                //     close.push(data[i][4]);
                //     // console.log(data[i][5] - 1);
                // }
                c = 0;
                closec = 0;
                max = 0;
                lastdateseconds = data[data.length-1][0];
                var lastdate = new Date(lastdateseconds * 1000);
                lastdate.setDate(lastdate.getDate() - 7);
                day7ago = lastdate.getTime()/1000;
                lastdata = [];
                for( i = data.length -1 ; i>=0; i--) {
                    /**
                    if((typeof(data[i][4])!= 'undefined') && (data[i][0] >= day7ago))
                        close.push(data[i][4]);
                    */
                    if(typeof(data[i][1])!= 'undefined' && ( (closec ++) < 50)) {
                        close.push(data[i][1]); //edit
                        // closec ++;
                    }
                    if(typeof(data[i][2])!= 'undefined' && ((c++) < 10)) {
                        multi_value = (data[i][2] - 1) * 1000000000; //edit
                        lastdata.push(multi_value);
                        max = (Math.abs(max) > Math.abs(multi_value)) ? Math.abs(max) : Math.abs(multi_value);
                    }
                }
                smacd = lastdata.reverse();

                // console.log('end');
                if (data === undefined || data.length == 0) { 
                } else {

                    /**
                         *show price chart
                        */
                    Highcharts.chart('<?php echo $each_chart ?>', {
                        chart: {
                            backgroundColor: colour[0],
                            type: 'line',
                            margin: 4,
                        },
                        exporting: {
                            enabled: false
                        },
                        title: {
                            text: null
                        },
                        tooltip: {
                            enabled: false
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            visible: false,
                            text: null,
                            gridLineWidth: 0,
                            labels: {
                            enabled: false
                            }
                        },
                        yAxis: {
                            title: {
                            text: null
                            },
                            gridLineWidth: 0,
                            text: null,
                            labels: {
                            enabled: false
                            }
                        },
                        plotOptions: {

                            series: {
                                color: '#FFFFFF',
                                lineWidth: 3,
                                linecap: 'round',
                                marker: {
                                    enabled: false,
                                    states: {
                                    hover: {
                                        enabled: false
                                    }
                                    }
                                },
                                animation: false,
                                // dataGrouping: {
                                //     forced: true,
                                //     units: [
                                //         ['week', [1]]
                                //     ]
                                // },
                            }
                        },
                        series: [{
                            data: close,
                            // dataGrouping: {
                            //     approximation: function () {
                            //         console.log(
                            //             'dataGroupInfo:',
                            //             this.dataGroupInfo,
                            //             'Raw data:',
                            //             this.options.data.slice(this.dataGroupInfo.start, this.dataGroupInfo.start + this.dataGroupInfo.length)
                            //         );
                            //         return this.dataGroupInfo.length;
                            //     },
                            //     forced: true
                            // },
                            //type: 'column',
                            showInLegend: false,
                            clip: false,
                            // pointStart: Date.UTC(lastdate.getYear(),lastdate.getMonth(),lastdate.getDate(),lastdate.getHours(),lastdate.getMinutes(),lastdate.getSeconds()),
                        }]
                    });
                    
                    /**
                         *show small macd chart
                        */
                    Highcharts.chart('<?php echo $each_macd ?>', {
                        chart: {
                            backgroundColor: colour[2],
                            type: 'column',
                            margin: 4,
                            borderColor: colour[0],
                            borderWidth: 4
                        },
                        exporting: {
                            enabled: false
                        },
                        title: {
                            text: null
                        },
                        tooltip: {
                            enabled: false
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            visible: false,
                            text: null,
                            gridLineWidth: 0,
                            labels: {
                            enabled: false
                            }
                        },
                        yAxis: {
                            title: {
                            text: null
                            },
                            gridLineWidth: 0,
                            text: null,
                            labels: {
                                enabled: false
                            },
                            max: max,
                            min: 0-max
                        },
                        plotOptions: {

                            series: {
                            color: '#FFFFFF',
                            borderWidth: 0,

                            marker: {
                                enabled: false,
                                states: {
                                hover: {
                                    enabled: false
                                }
                                }
                            },
                            animation: false
                            }
                        },
                        series: [{
                            data: smacd,
                            showInLegend: false,
                            clip: false
                        }]
                    });
        

                }
            @endforeach
        
            /**
             * Get Host address like http://localhost:4000 
             */
            var url = window.location.href
            var arr = url.split("/");
            var hosturl = arr[0] + "//" + arr[2];

            /**
             * When Select Coin
             * Show ticker and Coin logo of selected coin
             * Show Main Chart(right Side)
             */
            var progressbar2 = new Nanobar({target: document.getElementById('progressbar2')});
            function showChart(element) {
                $('#progressbar2').removeClass('display-hide');
                progressbar2.go(10);
            
                className = ".ticker" + element.data('id');
                onlyticker = $(className).data('ticker');      //BTC_XMR => XMR
                ticker = $(className).data('fullticker');     //BTC_XMR => BTC_XMR
                tickerlogosrc = $(className).data('tickerlogosrc');
                /*  */
                $('p.coin').each(function() {
                    $(this).removeClass('coin_select');
                });
                $(this).addClass('coin_select'); 

                /* show selected logo on the top of right side */
                $('span.coin_select_name').text(onlyticker);
                $('p.coin_select').removeClass('display-hide');
                //console.log($(this)[0].firstChild.currentSrc);
                $('.coin_select_img').attr('src', tickerlogosrc);

                // Exchange part
                rotateFlag = false;
                $('div#exchange-part img.coin_img').attr('src', tickerlogosrc);
                $('div#exchange-part img.V-down').rotate(180);
                /* show loading gif while chart show */
                // $('div.chart-container').html('<div id="overlay"><img src="http://localhost:4000/icons/loadingCB.gif" class="loading_circle" alt="loading" /></div>');
                // $('.loading-gif').addClass('loading');
                $('.chart-container').css('opacity', 0.7);

                /* Get data from database when select coin */
                // Pace.start();
                var start = Date.now();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: hosturl + '/getcoindata',
                    data: {
                        ticker: ticker
                    },
                    success: function (suc, status) {
                        
                        var end = Date.now();
                        var time = setInterval(progressbar2.go(100),2000);
                        $('#progressbar2').addClass('display-hide');
                        // Pace.stop();
                        /* */
                        // $('.loading-gif').addClass('display-hide');
                        // $('.loading-gif').removeClass('loading');
                        $('.chart-container').css('opacity', 1);

                        /* after loading data, show main chart using this data */
                        coindata = JSON.parse(suc);
                        data     = JSON.parse(coindata[0])
                        colour   = JSON.parse(coindata[1]);
                        profitData = JSON.parse(coindata[2]); // [dateOpen, dateClose, priceOpen, priceClose, profit, sold_amount]
                        
                        getEquityData(data, profitData);
                        //equity = getEquityData(data, profitData);
                        //console.log(equtiy);
                        

                        var ohlc = [],
                            volume = [],
                            dataLength = data.length,
                            // set the allowed units for data grouping
                            groupingUnits = [[
                                'week',                         // unit name
                                [1]                             // allowed multiples
                            ], [
                                'month',
                                [1, 2, 3, 4, 6]
                            ]],
                                
                            i = 0;
                    /* filter data to show equity line */
                        // for(i=0;i<profitData.length;i++)
                        //     console.log(profitData[i][0],profitData[i][1],profitData[i][2],profitData[i][3],profitData[i][4],profitData[i][5]);
                        i = 0;
                        //firstchartdate = 1519862400000;
                        /* make ohlc(open, high, low, close) data from loaded data */
                        //test
                        testequity = [];
                        pointStart = data[0][0] * 1000;
                        //add
                        max = 0;
                        for (i; i < dataLength; i += 1) {
                            // mainchartdate = 1519862400000 + i * 86400000;
                            // if(mainchartdate - firstchartdate > 2592000000)
                            //     break;
                            ohlc.push([
                                parseInt(data[i][0]) * 1000, // the date
                                // mainchartdate, // the date
                                data[i][1] * 1, // open
                                data[i][2] * 1, // high
                                data[i][3] * 1, // low
                                data[i][4] * 1// close
                            ]);
                            testequity.push([data[i][0], data[i][4]]);
                            volume.push([
                                parseInt(data[i][0]) * 1000, // the date
                                // mainchartdate, // the date
                                data[i][5] - 1 // the macd
                            ]);
                            //add
                            max = (Math.abs(max) > Math.abs( data[i][5] - 1)) ? Math.abs(max) : Math.abs( data[i][5] - 1);
                        }
                        
                        var coincolour = colour[0];
                        var midcolour = colour[1];
                        var midlight = colour[2];
                        var lightcolour = colour[3];
                        /* show main chart */
                        var highChart = Highcharts.stockChart('container', {
                            chart: {
                                type: 'candlestick',
                                marginLeft: 40, // Keep all charts left aligned
                                spacingTop: 20,
                                spacingBottom: 20,
                                zoomType: 'x',
                                backgroundColor: midlight,
                                borderColor: coincolour,
                                borderWidth: 6
                            },
                            title: {    
                                text: null,
                            },
                            credits: {
                                enabled: false
                            },
                            legend: {
                                enabled: false
                            },
                            exporting: {
                                enabled: false
                            },
                    
                    
                            // rangeSelector: {
                            //     selected: 1
                            // },
                    
                            rangeSelector: {
                                //enabled: false, // TODO make this apply to top chart only
                                inputEnabled: true,
                                inputBoxBorderColor: coincolour,
                                buttonTheme: {
                                    fill: 'none',
                                    stroke: 'none',
                                    'stroke-width': 0,
                                    r: 8,
                                    style: {
                                    color: coincolour,
                                    fontWeight: 'bold'
                                    },
                                    states: {
                                    hover: {},
                                    select: {
                                        fill: coincolour,
                                        style: {
                                        color: 'white'
                                        }
                                    }
                                    // disabled: { ... }
                                    }
                                },
                                buttons: [{
                                    type: 'hour',
                                    count: 1,
                                    text: '1h',
                                },{
                                    type: 'hour',
                                    count: 12,
                                    text: '12h',
                                },{
                                    type: 'day',
                                    count: 1,
                                    text: '1d',
                                },{
                                    type: 'day',
                                    count: 3,
                                    text: '3d',
                                },{
                                    type: 'day',
                                    count: 7,
                                    text: '1w',
                                },{
                                    type: 'month',
                                    count: 1,
                                    text: '1m',
                                },{
                                    type: 'month',
                                    count: 3,
                                    text: '3m',
                                },{
                                    type: 'month',
                                    count: 6,
                                    text: '6m',
                                },{
                                    type: 'year',
                                    count: 1,
                                    text: '1y',
                                }],
                            },
                            xAxis: [{
                                    crosshair: true,
                                    // gridLineWidth: 0,
                                    // text: null,
                                    // plotBands: [
                                    //     {},
                                    // ]
                                    // plotBands: [{
                                        
                                    // }, ]
                                    minRange: 300 * 1000
                                },{
                                    crosshair: true,
                                    minRange: 300 * 1000,
                                    events: {
                                        setExtremes: function (e) {
                                            $('#report').html('<b>Set extremes:</b> e.min: ' + Highcharts.dateFormat(null, e.min) +
                                                ' | e.max: ' + Highcharts.dateFormat(null, e.max) + ' | e.trigger: ' + e.trigger);
                                        }
                                    }
                                }
                            ],
                            yAxis: [{
                                gridLineWidth: 0,
                                labels: {
                                    enabled: false,
                                    align: 'right',
                                    x: -3
                                },
                                // title: {
                                //     text: 'OHLC'
                                // },
                                height: '60%',
                                lineWidth: 0.5,
                                resize: {
                                    enabled: true
                                }, 
                                //max: 0.1,
                                //scale: 5
                            }, {
                                gridLineWidth: 0,
                                // backgroundColor: coincolour,
                                // borderWidth: 3,
                                // borderColor: coincolour,
                    
                                labels: {
                                    enabled: false,
                                    align: 'right',
                                    x: -3
                                },
                                // title: {
                                //     text: 'Volume'
                                // },
                                top: '65%',
                                height: '35%',
                                offset: 0,
                                lineWidth: 2,
                                max: max,
                                min: 0 - max
                            }],
                    
                            tooltip: {
                                enabled: false, // could enable this later for numerical display - needs to handle OHLC 
                                // positioner: function() {
                                // return {
                                //   x: this.chart.chartWidth - this.label.width, // right aligned
                                //   y: -1 // align to title
                                // };
                                //},
                                borderWidth: 0,
                                backgroundColor: 'none',
                                pointFormat: '{point.y}',
                                headerFormat: '',
                                shadow: false,
                                style: {
                                fontSize: '8px'
                                },
                                //valueDecimals: dataset.valueDecimals
                            },
                            plotOptions: {
                                candlestick: {
                                    color: lightcolour, //lightcolour
                                    upColor: coincolour, //colour
                                    lineWidth: 0.3,
                                },
                                column: {
                                    color: '#FFFFFF',
                                },
                                series: {
                                    animation: {
                                    //duration: 5000
                                    },
                                    cursor: 'pointer',
                                    // events: {
                                    //   click: function() {
                                    //     alert('You just clicked the graph');
                                    //   }
                                    // }
                                    pointStart: pointStart,
                                }
                            },
                    
                    
                    
                            series: [
                                {
                                    type: 'candlestick',
                                    name: 'AAPL',
                                    data: ohlc,
                                },
                                // {
                                //     type: 'line',
                                //     name: 'EquityLine',
                                //     data: testequity,
                                //     //yAxis: 1
                                // },
                                {
                                    type: 'column',
                                    name: 'Volume',
                                    data: volume,
                                    yAxis: 1,
                                }
                            ]
                        });

                    }
                });
                
            }
            

            showChart($('p.coin[data-id=0]'));
            $(document).on('click', 'p.coin', function() {
                showChart($(this));
            });
            
            $(document).on('click', '.price', function() {
                showChart($(this));
            });
            
            $(document).on('click', '.smacd', function() {
                showChart($(this));
            });

            $(document).on('click', 'div.toolbar-icon', function() {
                $('div.toolbar-icon').each(function() {
                    $(this).css('background-color', '#fff');
                })
                $(this).css('background-color', '#e1e1e1');
            });
            
            $(document).on('click', 'div#exchange-part img.V-down', function() {
                (rotateFlag) ? ($(this).rotate(180)) : ($(this).rotate(-180));
                rotateFlag = !rotateFlag;
                
                $('div#exchange-info').slideToggle("slow");
                if(rotateFlag) {
                    $('html, body').animate({
                        scrollTop: $('div#exchange-info').offset().top - 10
                    }, 2000);
                } else {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 2000);
                }
            });
        });
    </script>

    <script type="text/babel">
        var simple = new SimpleBar(document.getElementById('coinlists'));
    </script>
@endsection