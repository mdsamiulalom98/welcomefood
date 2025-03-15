@extends('frontEnd.layouts.master')
@section('title', 'My Wishlist')
@section('content')
<section class="breadcumb-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="account-breadcumb">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('customer.account')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
                      </ol>
                    </nav>
                    <h3>My Wishlist</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcumb end -->
<section class="customer-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="customer-content">
                    <h5 class="account-title">My Wishlist</h5>
                    <div class="table-responsive" id="wishlist">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Cart</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                    <tr>
                                        <td>
                                            <form action="{{route('wishlist.remove')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $value->rowId }}">
                                                <button class="remove-cart"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                            <img src="{{ asset($value->options->image) }}" class="wishlist_img  quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal" alt="{{$value->name}}">
                                        </td>
                                        <td><a class="quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal">{{$value->name }}</a></td>
                                        <td>{{ $value->qty }} </td>
                                        <td>{{ $value->price }} Tk</td>
                                        <td><a class="wcart-btn quick_view" data-id="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#quickview_modal"><i class="fa-solid fa-shopping-cart"></i> <span>Add To Cart</span></a></td>
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
