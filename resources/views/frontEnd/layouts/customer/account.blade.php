@extends('frontEnd.layouts.master')
@section('title','Customer Account')
@section('content')
<section class="breadcumb-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="account-breadcumb">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('customer.account')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Account</li>
                      </ol>
                    </nav>
                    <h3>My Account</h3>
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
                <div class="customer-dashboard">
                   <div class="row">
                       <div class="col-sm-4 col-6">
                           <div class="dashboard-box">
                               <a href="{{route('customer.orders')}}">
                                   <i class="fa-brands fa-dropbox"></i>
                               </a>
                               <h3>Orders</h3>
                           </div>
                       </div>
                       <!-- col end -->
                       <div class="col-sm-4 col-6">
                           <div class="dashboard-box">
                               <a href="{{route('wishlist.show')}}">
                                   <i class="fa-solid fa-heart"></i>
                               </a>
                               <h3>Wishlist</h3>
                           </div>
                       </div>
                       <!-- col end -->
                       <div class="col-sm-4 col-6">
                           <div class="dashboard-box">
                               <a href="{{route('customer.profile_edit')}}">
                                   <i class="fa-solid fa-location-dot"></i>
                               </a>
                               <h3>Address</h3>
                           </div>
                       </div>
                       <!-- col end -->
                       <div class="col-sm-4 col-6">
                           <div class="dashboard-box">
                               <a href="{{route('customer.profile_edit')}}">
                                   <i class="fa-solid fa-user"></i>
                               </a>
                               <h3>Profile</h3>
                           </div>
                       </div>
                       <!-- col end -->
                       <div class="col-sm-4 col-6">
                           <div class="dashboard-box">
                               <a href="{{route('customer.change_pass')}}">
                                   <i class="fa-solid fa-key"></i>
                               </a>
                               <h3>Change Password</h3>
                           </div>
                       </div>
                       <!-- col end -->
                       <div class="col-sm-4 col-6">
                           <div class="dashboard-box">
                               <a href="{{ route('customer.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                   <i class="fa-solid fa-arrow-right-from-bracket"></i>
                               </a>
                               <h3>Logout</h3>
                           </div>
                           <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                       </div>
                       <!-- col end -->
                   </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush