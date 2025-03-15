@extends('frontEnd.layouts.master')
@section('title','Profile Update')
@section('content')
<section class="breadcumb-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="account-breadcumb">
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('customer.account')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                      </ol>
                    </nav>
                    <h3>Profile Update</h3>
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
                <div class="customer-content checkout-shipping">
                    <h5 class="account-title">Profile Update</h5>
                    <form action="{{route('customer.profile_update')}}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="name">Full Name *</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$profile_edit->name}}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="phone">Phone Number *</label>
                                <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$profile_edit->phone}}"  required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$profile_edit->email}}"  required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="address">Address *</label>
                                <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$profile_edit->address}}"  required>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="zone_id">Delivery Zone *</label>
                                <select  id="zone_id" class="form-control select2 @error('zone_id') is-invalid @enderror" name="zone_id" value="{{ old('zone_id') }}"  required>
                                    <option value="">Select...</option>
                                    @foreach($deliveryzones as $key=>$zone)
                                    <option value="{{$zone->id}}" @if($profile_edit->zone_id==$zone->id) selected @endif>{{$zone->name}}</option>
                                    @endforeach
                                </select>
                                @error('zone_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="image">Image *</label>
                                <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image" value="{{Auth::guard('customer')->user()->image}}" >
                                <img src="{{asset($profile_edit->image)}}" class="rounded-circle m-1" width="50px" alt="">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <button type="submit" class="submit-btn">Update</button>
                            </div>
                        </div>
                        <!-- col-end -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush