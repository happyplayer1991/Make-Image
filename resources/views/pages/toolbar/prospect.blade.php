@extends('layouts.app')
   
@section('content')
    <div class="container">
        @include('includes.header')
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
                                <tr class="nav_bar">
                                    <th class="coin_header">Coin</th>
                                    <th class="price_header">Price (7d)</th>
                                    <th class="macd_header">MACD</th>
                                    <th style="width: 10px"></th>
                                </tr>
                            </thead>
                        </table>
                    </td>
                    <td style="padding: 0 !important; vertical-align: top; background-color: #fff;">
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
                    <td style="padding: 0 !important; vertical-align: top">
                        <table width='100%'>
                            <thead></thead>
                        </table>
                    </td>
                    <td style="padding: 0 !important; vertical-align: top; background-color: #fff;">
                        <table width='100%'>
                            <thead></thead>
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
    </script>

@endsection
