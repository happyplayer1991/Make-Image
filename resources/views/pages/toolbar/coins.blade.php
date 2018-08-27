@extends('layouts.app')
   
@section('content')
    <div class="container">
        <table style="position: fixed; height: 30px; z-index: 999; top: 58px;" class="fixed_child">
            <thead>
                <th style="width: 35%;"></th>
                <th style="width: 65%;"></th>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 0 !important; vertical-align: top;">
                        <table width='100%'>
                            <thead>
                                
                            </thead>
                        </table>
                    </td>
                    <td style="padding: 0 !important; vertical-align: top; background-color: #fff;">
                        <table width='100%'>
                            <thead>
                                <tr class="nav_bar">
                                    
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
                    <td style="padding: 0 !important; vertical-align: top">
                        <table width='100%' style="margin-top: -2px;">
                            <thead></thead>
                            <tbody >
                                <tr>
                                    <td style="padding: 0" colspan="4">

                                        <table>
                                            <tbody style="height: 1370px; overflow: hidden; padding-right: 17px !important;" id="coinlists">
                                                @foreach($coins as $key => $coin)
                                                    <tr>
                                                        <?php $arr = explode("/", $coin['ticker']); ?>
                                                        <input type="hidden" class="<?php echo "ticker".$key ?>" 
                                                            data-ticker="<?php echo $arr[0] ?>"
                                                            data-fullticker="<?php echo $coin['ticker'] ?>" 
                                                            data-tickerlogosrc="{{ asset('img/').'/'.str_replace('/','_',$coin['ticker']).'.png'}}"
                                                        >
                                                        <td class="coin" style="width: 192px;">
                                                            <p class="coin" data-id="<?php echo $key ?>"><img src="{{ asset('img/').'/'.str_replace("/","_",$coin['ticker']).'.png'}}" class="coin_img" /><span class="coin_name">{{  $arr[0] }}</span></p>
                                                        </td>
                                                        <td colspan="3">
                                                            <div id="<?php echo 'img-part'. $key ?>" style="display: inline-flex;">
                                                                <div class="price" data-id="<?php echo $key ?>" id="<?php echo 'eachcoin'. $key ?>" style="height: 55px; width: 130px">
                                                                </div>
                                                                <div class="smacd" data-id="<?php echo $key ?>" id="<?php echo 'eachmacd'. $key ?>" style="height: 55px; width: 67px; ">
                                                                </div>
                                                                <div class="<?php echo "block". $key ?>" style="width: 10px; height: 55px;"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td class="coin" style="width: 192px;">
                                                    </td>
                                                    <td>
                                                        <div class="price" style="height: 55px; width: 130px">
                                                        </div>
                                                    </td>
                                                    <td >
                                                        <div class="smacd" style="height: 55px; width: 67px; ">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="width: 10px; height: 55px;"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>                            
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="padding: 0 !important; vertical-align: top; background-color: #fff;">
                        <table width='100%' style="margin-top: -1px;">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 0;">
                                        <div id="container" style="height: 580px; min-width: 310px; margin-top: -1px;" class="chart-container diplay-hide">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
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
            
            var url = window.location.href
            var arr = url.split("/");
            var hosturl = arr[0] + "//" + arr[2];

            function upload(filenames_data, imgdata_data, start, end) {
                if(start >= filenames_data.length)
                    return;
                start_pos = start;
                end_pos = end;
                end_pos = (end_pos < filenames_data.length) ? end_pos : filenames_data.length; 
                filenames = filenames_data.slice(start, end);
                imgdata = imgdata_data.slice(start, end);
            
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: hosturl + '/writePNG',
                    data: {
                        imagedata: imgdata,
                        filenames: filenames
                    },
                    success: function (suc, status) {
                        
                        upload(filenames_data, imgdata_data, start + 3, start + 6);
                    }
                });
            }
            
            let fixed_content_width = $('.fixed_child').parent().width()
            $('.fixed_child').width(fixed_content_width)

            $(window).resize(function() {
                $('.fixed_child').width(fixed_content_width)
            })

            //Get current timestamp
            currtime = Date.now();
            filenames = [];
            imgdata  = [];
            loopc = 0;
            @foreach ( $coins as $key => $coin )
                <?php 
                    $each_chart = 'eachcoin'. $key;
                    $each_macd = 'eachmacd'. $key;
                    $img_part = 'img-part'.$key;
                    $arr = explode("/", $coin['ticker']);
                    $count = count($coins);
                ?>
                count = parseInt("<?php echo $count ?>");
                tickername = "<?php echo ($arr[1]) ?>";
                testdata = "<?php echo ($coin['json']) ?>"; //json data ['timestamps', 'open', 'high', 'low', 'close', 'macd']
                data = JSON.parse(testdata);
                
                colour = <?php echo ($coin['colour']) ?>;     //colours ['colour', 'midColour,'midLight', 'lightColour']

                blockClass = ".block" + "<?php echo $key ?>";
                $(blockClass).css('background-color', colour['colour']);
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
                    var lineChart = Highcharts.chart('<?php echo $each_chart ?>', {
                        chart: {
                            backgroundColor: colour['colour'],
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
                    var smacdChart = Highcharts.chart('<?php echo $each_macd ?>', {
                        chart: {
                            backgroundColor: colour['midLight'],
                            type: 'column',
                            margin: 4,
                            borderColor: colour['colour'],
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
                    
                    div  = $('#' + "<?php echo $img_part?>");                   
                    filename = 'img/charts/' + "<?php echo $arr[1] ?>" + '_' + "<?php echo $arr[0] ?>" + '_chart_' + currtime + '.png';
                    filenames.push(filename);
                    
                    html2canvas(div.get(0)).then(function (canvas) {
                        loopc ++;
                        var Image = canvas.toDataURL();
                        imgdata.push(Image);
                        
                        if(loopc == count) {
                            upload(filenames, imgdata, 0, 3);
                        }
                    });

                }
            @endforeach
        });
    </script>

    <script type="text/babel">
        var simple = new SimpleBar(document.getElementById('coinlists'));
    </script>
@endsection


            <!-- function writePNG(div, fileName)
            {
                // html2canvas((div.get(0)), {
                //     onrendered: function(canvas) {
                //         var myImage = canvas.toDataURL();
                //         downloadURI(myImage, "MaSimulation.png");
                //     }
                // });

                html2canvas(div.get(0)).then(function (canvas) {
                    var Image = canvas.toDataURL();
                    //downloadURI(myImage, filename);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: hosturl + '/writePNG',
                        data: {
                            image: Image,
                            fileName: fileName
                        },
                        success: function (suc, status) {
                            //console.log(suc);
                        }
                    });
                });
            }



            function downloadURI(uri, name) {
                var link = document.createElement("a");

                link.download = name;
                link.href = uri;
                document.body.appendChild(link);
                link.click();   
                //after creating link you should delete dynamic link
                // clearDynamicLink(link); 
            }


                        function timeStamp() {
                // Create a date object with the current time
                var now = new Date();

                // Create an array with the current month, day and time
                var date = [ now.getFullYear(), now.getMonth() + 1, now.getDate() ];

                // Create an array with the current hour, minute and second 
                var time = [ now.getHours(), now.getMinutes(), now.getSeconds() ];

                // Determine AM or PM suffix based on the hour
                //var suffix = ( time[0] < 12 ) ? "AM" : "PM";

                // Convert hour from military time
                // time[0] = ( time[0] < 12 ) ? time[0] : time[0] - 12;

                // // If hour is 0, set it to 12
                // time[0] = time[0] || 12;

                // If seconds and minutes are less than 10, add a zero

                for ( var i = 1; i < 3; i++ ) {
                    date[i] = (date[i] < 10 ) ? ("0" + date[i]) : date[i];
                    time[i] = (time[i] < 10 ) ? ("0" + time[i]) : time[i];
                }
                time[0] = (time[0] < 10 ) ? ("0" + time[0]) : time[0];
                // Return the formatted string
                //return date.join("/") + " " + time.join(":") + " " + suffix;
                return date.join("") + time.join("");
            } -->
            