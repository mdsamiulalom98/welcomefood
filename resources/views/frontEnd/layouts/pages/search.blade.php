@extends('frontEnd.layouts.master')
@section('title', $keyword)
@section('content')
    <section class="product-section">
        <div class="container">
            <div class="sorting-section">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="category-breadcrumb d-flex align-items-center">
                            <a href="{{ route('home') }}">Home</a>
                            <span>/</span>
                            <strong>{{ $keyword }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="showing-data">
                                    <span>Showing {{ $foods->firstItem() }}-{{ $foods->lastItem() }} of
                                        {{ $foods->total() }} Results</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="page-sort">
                                    @include('frontEnd.layouts.partials.sort_form')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9">
                    <div class="category-product">
                        @forelse($foods as $key => $value)
                            <div class="product_item wist_item">
                                @include('frontEnd.layouts.partials.product')
                            </div>
                        @empty
                            <div class="no-found">
                                <img src="{{ asset('public/frontEnd/images/not-found.png') }}" alt="">
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-sm-3">
                    <!-- cart sidebar -->
                    <div class="mini-cart-wrapper">
                        @include('frontEnd.layouts.partials.mini_cart')
                    </div>
                    <!-- cart sidebar -->
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="custom_paginate">
                        {{ $foods->links('pagination::bootstrap-4') }}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
