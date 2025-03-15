@extends('backEnd.layouts.master')
@section('title','Purchase Reports')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <a href="{{route('products.purchase_create')}}" class="btn btn-primary rounded-pill">Create</a>
            </div>
            <h4 class="page-title">Purchase Reports</h4>
        </div>
    </div>
</div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table nowrap w-100">
                    <thead>
                        <tr>
                            <th style="width:2%">SL</th>
                            <th style="width:20%">Date</th>
                            <th style="width:20%">Name</th>
                            <th style="width:10%">Category</th>
                            <th style="width:10%">Color & Size</th>
                            <th style="width:10%">Purchase</th>
                            <th style="width:10%">Old Price</th>
                            <th style="width:10%">Price</th>
                            <th style="width:8%">Stock</th>
                        </tr>
                    </thead>               
                
                    <tbody>
                        @foreach($purchase as $key=>$value)
                         <tr>
                            <td style="width:2%">{{$loop->iteration}}</td>
                            <td style="width:20%">{{$value->created_at->format('d-m-Y')}}</td>
                            <td style="width:20%">{{$value->product?$value->product->name:''}}</td>
                            <td style="width:10%">{{$value->product?$value->product->category->name:''}}</td>
                            <td style="width:10%">{{$value->color}} , {{$value->size}}</td>
                            <td style="width:10%">{{$value->purchase_price}}</td>
                            <td style="width:10%">{{$value->old_price}}</td>
                            <td style="width:10%">{{$value->new_price}}</td>
                            <td style="width:8%">{{$value->stock}}</td>
                         </tr>
                        @endforeach
                     </tbody>
                    </table>
                </div>
                <div class="custom-paginate">
                    {{$purchase->links('pagination::bootstrap-4')}}
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection