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

         <div class="row">
        <div class="col-sm-12 text-start">
            <form class="no-print mb-2">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                           <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" value="{{request()->get('start_date')}}"  class="form-control flatdate" name="start_date">
                        </div>
                    </div>
                    <!--col-sm-3-->
                    <div class="col-sm-4">
                        <div class="form-group">
                           <label for="end_date" class="form-label">End Date</label>
                            <input type="date" value="{{request()->get('end_date')}}" class="form-control flatdate" name="end_date">
                        </div>
                    </div>
                    <!--col-sm-3-->
                    <div class="col-sm-4 text-start">
                        <div class="form-group mt-3">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <!-- col end -->
                </div>
            </form>
        </div>
    </div>
    <!--graph chart start -->
    <div class="graph-pie">
        <div class="row">
            <div class="col-sm-3 main-Pie">
                   <div id="chartContainer" style="height: 200px; width: 100%;"></div>
                <a href="{{route('admin.orders','all')}}">
                <div class="inner-chart">
                    <h5>total value</h5>
                    <h3> ৳ {{ number_format($total_amount)}}</h3>
                    <p>{{$total_order}} Orders</p>
                </div>
                </a>
            </div>
            <!--end-col-->
            <div class="col-sm-9">
                <div class="chart-des">
                    <!--new-row-start-->
                    <div class="row">
                        <div class="col-sm-4">
                          <a href="{{route('admin.orders','completed')}}">
                            <div class="des-item" style="border-left:6px solid #21c624; padding-left:20px;">
                                <h5>Delivered</h5>
                                <h2>@if($total_complete > 0) {{number_format(($total_complete*100)/$total_order,2)}} @else 0 @endif%</h2>
                                <h5>{{$total_complete}} orders | {{$delivery_amount}} Tk</h5>
                            </div>
                            </a>
                        </div>
                        <!--end-col-->
                        <div class="col-sm-4">
                          <a href="{{route('admin.orders','in-courier')}}">
                            <div class="des-item" style="border-left:6px solid #ffcd00; padding-left:20px;">
                                <h5>Delivery Processing</h5>
                                <h2>@if($total_process > 0) {{number_format(($total_process*100)/$total_order,2)}} @else 0 @endif%</h2>
                                <h5>{{$total_process}} orders |  {{$process_amount}} Tk</h5>
                            </div>
                           </a>
                        </div>
                        <!--end-col-->
                        <div class="col-sm-4">
                          <a href="{{route('admin.orders','returned')}}">
                            <div class="des-item" style="border-left:6px solid #ff4c49;padding-left:20px;">
                                <h5>Returned</h5>
                                <h2>@if($total_return > 0) {{number_format(($total_return*100)/$total_order,2)}} @else 0 @endif%</h2>
                                <h5>{{$total_return}} orders |  {{$return_amount}} Tk</h5>
                            </div>
                          </a>
                        </div>
                        <!--end-col-->
                    </div>
                    <!--new-row-end-->
                </div>
            </div>
            <!--end-col-->
        </div>
        <!--end-row-->
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

