@extends('layouts.app')
   
@section('content')
    <div class="container">
        @include('includes.header')
        <table class="fixed_child">
            <thead>
                <th class="left"></th>
                <th class="right"></th>
            </thead>
            <tbody>
                <tr>
                    <td class="left">
                        <table class="width-100">
                            <thead>
                                <tr class="nav_bar">
                                    <th class="coin_header">Coin</th>
                                    <th class="price_header">Price (7d)</th>
                                    <th class="macd_header">MACD</th>
                                </tr>
                            </thead>
                        </table>
                    </td>
                    <td class="right">
                        <table class="width-100">
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
        <table class="content-table">
            <thead>
                <th class="left"></th>
                <th class="right"></th>
            </thead>
            <tbody>
                <tr>
                    <td class="left">
                        <table class="width-100">
                            <thead></thead>
                            <tbody >
                                <tr>
                                    <td class="padding-0" colspan="4">
                                        <table>
                                            <tbody id="coinlists">
                                                @foreach($coins as $key => $coin)
                                                    <tr>
                                                        <td class="coin">
                                                            <p class="coin">
                                                                <img src="{{ asset('img/').'/'.str_replace("/","_", $coin['ticker']).'.png'}}" class="coin_img" />
                                                                <span class="coin_name">{{  explode("/", $coin['ticker'])[0] }}
                                                                </span>
                                                            </p>
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
                    <td class="right">
                        <table class="width-100">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td class="padding-0">
                                        <div id="streamgraph-container" class="chart-container diplay-hide">
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
    
        $(document).ready(function() {
            let fixed_content_width = $('.fixed_child').parent().width()
            $('.fixed_child').width(fixed_content_width)

            $(window).resize(function() {
                $('.fixed_child').width(fixed_content_width)
            })
        })

        var colors = [],
            series = [];
        @foreach($coins as $key => $coin)
            ticker = "<?php echo $coin['ticker'] ?>"; 
            
            color = "<?php echo $coin['colour'] ?>";
            
            equity = <?php echo $coin['equity'] ?>;
            equity = JSON.parse(equity);
            
            categories = [] ;
            @if($key == 0)
                for(i = 0; i< equity.length ; i++) {
                    categories.push(equity[i][0]);
                }
            @endif
            equity_data = [];
            for(i = 0; i< equity.length ; i++) {
                equity_data.push(equity[i][1]);
            }

            colors.push(color);
            data = {
                'name' : ticker,
                'data' : equity_data
            };
            series.push(data);
        @endforeach
        /* Show StreamGraph */
    /*
        Highcharts.chart('streamgraph-container', {

            chart: {
                type: 'streamgraph',
                marginBottom: 30,
                zoomType: 'x'
            },

            colors: colors,

            title: {
                floating: true,
                align: 'left',
                text: 'StreamGraph'
            },

            credits: {
                enabled: false
            },

            xAxis: {
                visible: false,
            },

            yAxis: {
                visible: false,
                startOnTick: false,
                endOnTick: false
            },

            legend: {
                enabled: false
            },

            plotOptions: {
                series: {
                    label: {
                        minFontSize: 5,
                        maxFontSize: 15,
                        style: {
                            color: 'rgba(255,255,255,0.75)'
                        }
                    }
                }
            },
            series: series,

            exporting: {
                sourceWidth: 800,
                sourceHeight: 600
            }

        });
    */

        /* Show Stacked area */
        
        Highcharts.chart('streamgraph-container', {
            chart: {
                type: 'area'
            },
            colors: colors,
            title: {
                text: 'Historic and Estimated Worldwide Population Growth by Region'
            },
            subtitle: {
                text: 'Source: Wikipedia.org'
            },
            xAxis: {
                categories: categories,
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: 'Billions'
                },
                labels: {
                    formatter: function () {
                        return this.value ;
                    }
                }
            },
            tooltip: {
                split: true,
                valueSuffix: ''
            },
            plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#666666'
                    }
                }
            },
            series: series
        });
    </script>
@endsection