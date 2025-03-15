@extends('backEnd.layouts.master')
@section('title', 'Food Create') 
@section('css')
<style>
    .increment_btn,
    .remove_btn {
        margin-top: -17px;
        margin-bottom: 10px;
    }
</style>
<link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
    type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('foods.index') }}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Food Create</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <form action="{{ route('foods.update') }}" method="POST" data-parsley-validate=""
        enctype="multipart/form-data" name="editForm">
        <input type="hidden" value="{{ $edit_data->id }}" name="id" />
    @csrf
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Food Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $edit_data->name }}" id="name" required />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Categories *</label>
                                <select class="form-control select2 @error('category_id') is-invalid @enderror"
                                    name="category_id" value="{{ old('category_id') }}" id="category_id" required>
                                    <option value="">Select..</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="subcategory_id" class="form-label">Sub Categories </label>
                                <select class="form-control select2 @error('subcategory_id') is-invalid @enderror"
                                    id="subcategory_id" name="subcategory_id" data-placeholder="Choose ...">
                                    <optgroup>
                                        <option value="">Select..</option>
                                    </optgroup>
                                </select>
                                @error('subcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-12 mb-3">
                            <label for="image">Images (Press to multiple) *</label>
                            <div class="input-group control-group">
                                <input type="file" name="image[]" multiple
                                    class="form-control @error('image') is-invalid @enderror" />
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                           <div class="product_img">
                                @foreach ($edit_data->images as $image)
                                    <img src="{{ asset($image->image) }}" class="edit-image border"
                                        alt="" />
                                    <a href="{{ route('foods.image.destroy', ['id' => $image->id]) }}"
                                        class="btn btn-xs btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-close"></i></a>
                                @endforeach
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="description" class="form-label">Description *</label>
                                <textarea name="description" rows="6"
                                    class="summernote form-control @error('description') is-invalid @enderror" required>{{ $edit_data->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                    </div>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
        <div class="col-lg-6">
             <div class="card">
                 <div class="card-body">
                     <div class="variable_product">
                        @foreach ($variables as $variable)
                            <input type="hidden" value="{{ $variable->id }}" name="up_id[]">
                            <div class="row mb-2">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="up_size" class="form-label">Size/Weight</label>
                                        <select class="form-control" name="up_sizes[]">
                                            <option value="">Select</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->name }}"
                                                    @if ($variable->size == $size->name) selected @endif>
                                                    {{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('up_size')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!--col end -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="up_cost_prices" class="form-label">Cost Price
                                            *</label>
                                        <input type="text"
                                            class="form-control @error('up_cost_prices') is-invalid @enderror"
                                            name="up_cost_prices[]"
                                            value="{{ $variable->cost_price }}"
                                            id="up_cost_prices" />
                                        @error('cost_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="up_old_prices" class="form-label">Old Price</label>
                                        <input type="text"
                                            class="form-control @error('up_old_prices') is-invalid @enderror"
                                            name="up_old_prices[]" value="{{ $variable->old_price }}"
                                            id="up_old_prices" />
                                        @error('old_prices')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="up_new_prices" class="form-label">New Price *</label>
                                        <input type="text"
                                            class="form-control @error('up_new_prices') is-invalid @enderror"
                                            name="up_new_prices[]" value="{{ $variable->new_price }}"
                                            id="up_new_prices" />
                                        @error('up_new_prices')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="input-group-btn mt-1">
                                    <a href="{{ route('foods.price.destroy', ['id' => $variable->id]) }}"
                                        class="btn btn-danger btn-xs text-white"
                                        onclick="return confirm('Are you want delete this?')"
                                        type="button"><i class="mdi mdi-close"></i></a>
                                </div>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="roles" class="form-label">Size/Weight</label>
                                    <select class="form-control" name="sizes[]">
                                        <option value="">Select</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->name }}">{{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sizes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!--col end -->

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="cost_prices" class="form-label">Cost Price *</label>
                                    <input type="text"
                                        class="form-control @error('cost_prices') is-invalid @enderror"
                                        name="cost_prices[]" value="{{ old('cost_prices') }}"
                                        id="cost_prices" />
                                    @error('purchase_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="old_prices" class="form-label">Old Price </label>
                                    <input type="text"
                                        class="form-control @error('old_prices') is-invalid @enderror"
                                        name="old_prices[]" value="{{ old('old_prices') }}" id="old_prices" />
                                    @error('old_prices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="new_prices" class="form-label">New Price *</label>
                                    <input type="text"
                                        class="form-control @error('new_prices') is-invalid @enderror"
                                        name="new_prices[]" value="{{ old('new_prices') }}" id="new_prices" />
                                    @error('new_prices')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <div class="input-group-btn mt-3">
                                <button class="btn btn-success increment_btn  btn-xs text-white" type="button"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="clone_variable" style="display:none">
                            <div class="row increment_control">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="roles" class="form-label">Size/Weight</label>
                                        <select class="form-control" name="sizes[]">
                                            <option value="">Select</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->name }}">{{ $size->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('size')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!--col end -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cost_prices" class="form-label">Cost Price *</label>
                                        <input type="text"
                                            class="form-control @error('cost_prices') is-invalid @enderror"
                                            name="cost_prices[]" value="{{ old('cost_prices') }}"
                                            id="cost_prices" />
                                        @error('cost_prices')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="old_prices" class="form-label">Old Price </label>
                                        <input type="text"
                                            class="form-control @error('old_prices') is-invalid @enderror"
                                            name="old_prices[]" value="{{ old('old_prices') }}"
                                            id="old_prices" />
                                        @error('old_prices')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="new_prices" class="form-label">New Price *</label>
                                        <input type="text"
                                            class="form-control @error('new_prices') is-invalid @enderror"
                                            name="new_prices[]" value="{{ old('new_prices') }}"
                                            id="new_prices" />
                                        @error('new_prices')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- col-end -->
                                <div class="input-group-btn mt-3">
                                    <button class="btn btn-danger remove_btn  btn-xs text-white" type="button"><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                     </div>
                    <!--variable product  end-->
                    <div class="row">
                        <!-- col end -->
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="status" class="d-block">Status</label>
                                <label class="switch">
                                    <input type="checkbox" value="1" name="status" checked />
                                    <span class="slider round"></span>
                                </label>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="topsale" class="d-block">Best Deals</label>
                                <label class="switch">
                                    <input type="checkbox" value="1" name="topsale" />
                                    <span class="slider round"></span>
                                </label>
                                @error('topsale')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-success d-block" value="Submit" />
                        </div>
                    </div>
                 </div>
             </div>
        </div>
    </div>
    </form>
</div>
@endsection 

@section('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
    <!-- Plugins js -->
    <script src="{{ asset('public/backEnd/') }}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });
    </script>
    <script>
        $(document).ready(function() {
            var serialNumber = 1;
            $(".increment_btn").click(function() {
                var html = $(".clone_variable").html();
                var newHtml = html.replace(/stock\[\]/g, "stock[" + serialNumber + "]");
                $(".variable_product").after(newHtml);
                serialNumber++;
            });
            $("body").on("click", ".remove_btn", function() {
                $(this).parents(".increment_control").remove();
                serialNumber--;
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".select2").select2();
        });

        // category to sub
        $("#category_id").on("change", function() {
            var ajaxId = $(this).val();
            if (ajaxId) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ajax-product-subcategory') }}?category_id=" + ajaxId,
                    success: function(res) {
                        if (res) {
                            $("#subcategory_id").empty();
                            $("#subcategory_id").append('<option value="0">Choose...</option>');
                            $.each(res, function(key, value) {
                                $("#subcategory_id").append('<option value="' + key + '">' +
                                    value + "</option>");
                            });
                        } else {
                            $("#subcategory_id").empty();
                        }
                    },
                });
            } else {
                $("#subcategory_id").empty();
            }
        });
    </script>
    <script type="text/javascript">
        document.forms["editForm"].elements["category_id"].value = "{{ $edit_data->category_id }}";
        document.forms["editForm"].elements["subcategory_id"].value = "{{ $edit_data->subcategory_id }}";
    </script>
@endsection


