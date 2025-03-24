@extends('backEnd.layouts.master')
@section('title', 'Dashboard')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
        type="text/css" />

    <style>
        a.canvasjs-chart-credit {
            display: none !important;
        }
        .graph-pie{
            background:#fff;
            margin-bottom:20px;
        }
        .des-item h5 {
            color: #979797;
        }
        .des-item h2 {
            font-weight: 800;
            color: #6a6a6a;
        }
        .chart-des {
            padding-top: 50px;
        }
        .inner-chart {
            position: absolute;
            top: 25%;
            left: 34%;
            opacity: 1;
            z-index: 999;
            text-align: center;
        }
        .inner-chart h5 {
            text-transform: capitalize;
        }
        .main-Pie{
            position:relative;
        }
        .ex-pro {
            margin-top: 14px;
            margin-left: 8px;
        }
        </style>
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">

                                    <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $total_sale }} Tk</span></h3>
                                    <p class="text-muted mb-1 text-truncate">Total Sales</p>

                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-pie-chart avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end widget-rounded-circle-->
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $current_month_sale }}</span> Tk</h3>
                                <p class="text-muted mb-1 text-truncate">This Month Sales</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-bar-chart-2 avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $today_sales }}</span> Tk</h3>
                                <p class="text-muted mb-1 text-truncate">Today Sales</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-activity avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $total_order }}</span> Tk</h3>
                                <p class="text-muted mb-1 text-truncate">Total Order</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-shopping-cart avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $current_month_order }}</span> Tk</h3>
                                <p class="text-muted mb-1 text-truncate">This Month Orders</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-database avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-dark my-1"><span data-plugin="counterup">{{ $total_customer }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Customers</p>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="avatar-sm bg-blue rounded">
                                        <i class="fe-users avatar-title font-22 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
        </div>
        <!-- end row-->
        @role('Admin')
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-0">Last 30 days sales reports</h4>
                        <canvas id="paymentsChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="widget-rounded-circle card bg-blue">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('admin.orders', ['slug' => 'pos']) }}">
                                    <div class="text-start">
                                        <h3 class="text-dark mt-1 text-white"><span
                                                data-plugin="counterup">{{ $total_pos }}</span></h3>
                                        <p class="text-dark mb-1 text-truncate text-white">Pos Order</p>
                                    </div>
                                </a>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end widget-rounded-circle-->
            </div> <!-- end col-->
            @foreach ($order_statuses as $key => $status)
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card {{$status->color}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                     <a href="{{ route('admin.orders', ['slug' => $status->slug]) }}">
                                        <div class="text-start">
                                            <h3 class="text-dark mt-1 text-white"><span
                                                    data-plugin="counterup">{{ $status->orders_count }}</span></h3>
                                            <p class="text-dark mb-1 text-truncate text-white">{{ $status->name }}</p>
                                        </div>
                                    </a>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->
            @endforeach

        </div>
         @endrole
        
    </div>

    <!--graph chart end -->

    </div> <!-- container -->
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('paymentsChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $dates_json !!}, // X-axis labels (dates)
                datasets: [{
                    label: 'Last 30 days sales reports',
                    data: {!! $totals_json !!}, // Y-axis data (payments)
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    <script>
        window.onload = function () {
        var options = {
        	animationEnabled: true,
        	title: {
        		text: ""
        	},
        	data: [{
        		type: "doughnut",
        		innerRadius: "80%",
        		dataPoints: [
        			{ label: "", y: {{$delivery_amount}} ,color: "#21c624"},
        			{ label: "", y: {{$process_amount}} , color : "#ffcd00"},
        			{ label: "", y: {{$return_amount}} , color : "#ff4c49"},

        		]
        	}]
        };
        $("#chartContainer").CanvasJSChart(options);

        }
    </script>
     <script type="text/javascript">
        $(document).ready(function () {
            flatpickr(".flatdate", {});
        });
    </script>
@endsection

