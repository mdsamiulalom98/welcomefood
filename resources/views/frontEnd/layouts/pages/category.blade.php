@extends('frontEnd.layouts.master')
@section('title', $category->name)
@push('seo')
    <meta name="app-url" content="{{ route('category', $category->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $category->meta_description }}" />
    <meta name="keywords" content="{{ $category->slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $category->name }}" />
    <meta name="twitter:title" content="{{ $category->name }}" />
    <meta name="twitter:description" content="{{ $category->meta_description }}" />
    <meta name="twitter:creator" content="{{ $generalsetting->name }}" />
    <meta property="og:url" content="{{ route('category', $category->slug) }}" />
    <meta name="twitter:image" content="{{ asset($category->image) }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $category->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('category', $category->slug) }}" />
    <meta property="og:image" content="{{ asset($category->image) }}" />
    <meta property="og:description" content="{{ $category->meta_description }}" />
    <meta property="og:site_name" content="{{ $category->name }}" />
@endpush
@section('content')
    <section class="homeproduct product-section">
        <div class="container-fluid">
            <div class="sorting-section">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="category-breadcrumb d-flex align-items-center">
                            <a href="{{ route('home') }}">Home</a>
                            <span>/</span>
                            <strong>{{ $category->name }}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="filter_sort">
                                    <div class="page-sort">
                                        @include('frontEnd.layouts.partials.sort_form')
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 d-none d-sm-block">
                                <div class="showing-data">
                                    <span>Showing {{ $foods->firstItem() }}-{{ $foods->lastItem() }} of
                                        {{ $foods->total() }} Results</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9">
                    <div class="category-product {{ $foods->total() == 0 ? 'no-product' : '' }}">
                        @forelse($foods as $key => $value)
                            <div class="mini-product-item">
                                @include('frontEnd.layouts.partials.mini_product')
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
