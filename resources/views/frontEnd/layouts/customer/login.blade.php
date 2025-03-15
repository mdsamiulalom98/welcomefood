@extends('frontEnd.layouts.master')
@section('title','Login')
@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="form-content">
                    <p class="auth-title">Customer Login </p>
                    <form action="{{route('customer.signin')}}" method="POST"  data-parsley-validate="">
                        @csrf
                        <div class="form-group mb-3">
                                <label for="email_phone" class="form-label">Email or Phone Number <span>*</span></label>
                                <input type="text" class="form-control  {{ $errors->has('email_phone') ? 'is-invalid' : '' }}"
                                    placeholder="Enter email or phone number *" name="email_phone" value="{{ old('email_phone') }}" required>
                                @if ($errors->has('email_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="password">Password *</label>
                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" name="password" value="{{ old('password') }}"  required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <a href="{{route('customer.forgot.password')}}" class="forget-link"><i class="fa-solid fa-unlock"></i> Forgot Password?</a>
                        <div class="form-group mb-3">
                            <button class="submit-btn"> Login </button>
                        </div>
                     <!-- col-end -->
                     </form>
                     <div class="register-now no-account">
                        <p> You Have No Account?  <a href="{{route('customer.register')}}"><i data-feather="edit-3"></i> Click To Register</a></p>
                       
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