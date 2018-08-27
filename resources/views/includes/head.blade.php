<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- <title>{{ config('app.name', 'Coinbot') }}</title> -->
<title>Coinbot</title>
<link rel="shortcut icon" type="image/png" href="{{asset('img/favicon.ico')}}"/>

<link href="{{asset('plugins/bootstrap/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('plugins/simplebar/simplebar.css')}}" rel="stylesheet">
<link href="{{asset('plugins/pace/pace.css')}}" rel="stylesheet">

<script src="{{asset('plugins/jquery/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/easing/jquery.easing.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/rotate/rotate.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/popper/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/bootstrap/bootstrap.min.js')}}" type="text/javascript"></script>

<!--==================================== HighChart =======================================================-->
<script src="{{asset('plugins/chart/stock/highstock.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/chart/streamgraph.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/chart/series-label.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/chart/annotations.js')}}" type="text/javascript"></script>
<script src="{{asset('plugins/chart/stock/modules/exporting.js')}}" type="text/javascript"></script>

<script src="{{asset('plugins/pace/pace.js')}}" type="text/javascript"></script>

<script src="{{asset('plugins/simplebar/react.js')}}"></script>
<script src="{{asset('plugins/simplebar/react-dom.js')}}"></script>
<script src="{{asset('plugins/simplebar/browser.min.js')}}"></script>

<script src="{{asset('plugins/simplebar/simplebar.js')}}"></script>
<script src="{{asset('plugins/nanobar/nanobar.js') }}"></script>

<script src="{{asset('plugins/html2canvas/html2canvas.min.js')}}"></script>
