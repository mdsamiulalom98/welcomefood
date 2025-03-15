@extends('frontEnd.layouts.master')
@section('title', 'My Order')
@section('content')
<section class="breadcumb-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="account-breadcumb">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('customer.account')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Order</li>
                      </ol>
                    </nav>
                    <h3>My Order</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcumb end -->
    <section class="customer-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="customer-sidebar">
                        @include('frontEnd.layouts.customer.sidebar')
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="customer-content">
                        <h5 class="account-title">My Order</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $value)
                                        <tr>
                                            <td>{{ $value->created_at->format('d-m-y') }}</td>
                                            <td>{{ $value->amount }}</td>
                                            <td>{{ $value->discount }} Tk</td>
                                            <td><span class="btn-status {{ $value->status == '3' ? 'success' : ''}}">{{ $value->status ? $value->status->name : '' }}</span></td>

                                            <td><a href="{{ route('customer.invoice', ['id' => $value->id]) }}"
                                                    class="invoice_btn"><i class="fa-solid fa-eye"></i></a>

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
