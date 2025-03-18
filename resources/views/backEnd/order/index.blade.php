@extends('backEnd.layouts.master')
@section('title', $order_status->name . ' Order')
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        @can('order-create')
                            <a href="{{ route('admin.order.create') }}" class="btn btn-danger rounded-pill">
                                <i class="fe-shopping-cart"></i>
                                Add New</a>
                        @endcan
                    </div>
                    <h4 class="page-title">{{ $order_status->name }} Order ({{ $order_status->orders_count }})</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row order_page">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <ul class="action2-btn">
                                    <li><a data-bs-toggle="modal" data-bs-target="#asignUser"
                                            class="btn rounded-pill btn-success"><i class="fe-plus"></i> Assign User</a>
                                    </li>
                                    <li><a data-bs-toggle="modal" data-bs-target="#changeStatus"
                                            class="btn rounded-pill btn-primary"><i class="fe-plus"></i> Change Status</a>
                                    </li>
                                    <li><a href="{{ route('admin.order.bulk_destroy') }}"
                                            class="btn rounded-pill btn-danger order_delete"><i class="fe-plus"></i> Delete
                                            All</a></li>
                                    <li><a href="{{ route('admin.order.order_print') }}"
                                            class="btn rounded-pill btn-info multi_order_print"><i class="fe-printer"></i>
                                            Print</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <form class="custom_form">
                                    <div class="form-group">
                                        <input type="text" name="keyword" placeholder="Search">
                                        <button class="btn  rounded-pill btn-info">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive ">
                            <table id="datatable-buttons" class="table table-striped w-100">
                                <thead>
                                    <tr>
                                        <th style="width:2%">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input checkall" value="">
                                                </label>
                                            </div>
                                        </th>
                                        <th style="width:2%">SL</th>
                                        <th style="width:8%">Action</th>
                                        <th style="width:8%">Invoice</th>
                                        <th style="width:10%">Date</th>
                                        <th style="width:10%">Name</th>
                                        <th style="width:10%">Phone</th>
                                        <th style="width:10%">Amount</th>
                                        <th style="width:10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($show_data as $key => $value)
                                        <tr>
                                            <td><input type="checkbox" class="checkbox" value="{{ $value->id }}"></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="button-list custom-btn-list">
                                                    <a href="{{ route('admin.order.invoice', ['invoice_id' => $value->invoice_id]) }}"
                                                        title="Invoice"><i class="fe-eye"></i></a>
                                                    <a href="{{ route('admin.order.process', ['invoice_id' => $value->invoice_id]) }}"
                                                        title="Process"><i class="fe-settings"></i></a>
                                                    @can('order-edit')
                                                        <a href="{{ route('admin.order.edit', ['invoice_id' => $value->invoice_id]) }}"
                                                            title="Edit"><i class="fe-edit"></i></a>
                                                    @endcan
                                                    @can('order-delete')
                                                        <form method="post" action="{{ route('admin.order.destroy') }}"
                                                            class="d-inline">
                                                            @csrf
                                                            <input type="hidden" value="{{ $value->id }}" name="id">
                                                            <button type="submit" title="Delete" class="delete-confirm"><i
                                                                    class="fe-trash-2"></i></button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                            <td>{{ $value->invoice_id }}<br> {{ $value->customer_ip }} <br>
                                                @if ($value->order_type == 'digital')
                                                    <i class="fa fa-gift"></i>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($value->updated_at)) }}<br>
                                                {{ date('h:i:s a', strtotime($value->updated_at)) }}</td>
                                            <td><strong>{{ $value->shipping ? $value->shipping->name : '' }}</strong>
                                                <p>{{ $value->shipping ? $value->shipping->address : '' }}</p>
                                            </td>
                                            <td>{{ $value->shipping ? $value->shipping->phone : '' }}</td>
                                            <td>{{ $value->amount }} Tk</td>
                                            <td>{{ $value->status ? $value->status->name : '' }} <p><button
                                                        class="btn btn-soft-info rounded-pill waves-effect waves-light btn-xs mt-1">{{ $value->order_type }}</button>
                                                </p>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="custom-paginate">
                            {{ $show_data->links('pagination::bootstrap-4') }}
                        </div>
                    </div> <!-- end card body-->

                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
    <!-- Assign User End -->
    <div class="modal fade" id="asignUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.order.assign') }}" id="order_assign">
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">Select..</option>
                                @foreach ($users as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Assign User End-->

    <!-- Assign User End -->
    <div class="modal fade" id="changeStatus" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Status Change</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.order.status') }}" id="order_status_form">
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="order_status" id="order_status" class="form-control">
                                <option value="">Select..</option>
                                @foreach ($orderstatus as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Assign User End-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".checkall").on('change', function() {
                $(".checkbox").prop('checked', $(this).is(":checked"));
            });

            // order assign
            $(document).on('submit', 'form#order_assign', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                let user_id = $(document).find('select#user_id').val();

                var order = $('input.checkbox:checked').map(function() {
                    return $(this).val();
                });
                var order_ids = order.get();

                if (order_ids.length == 0) {
                    toastr.error('Please Select An Order First !');
                    return;
                }

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        user_id,
                        order_ids
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();

                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });

            });

            // order status change
            $(document).on('submit', 'form#order_status_form', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                let order_status = $(document).find('select#order_status').val();

                var order = $('input.checkbox:checked').map(function() {
                    return $(this).val();
                });
                var order_ids = order.get();

                if (order_ids.length == 0) {
                    toastr.error('Please Select An Order First !');
                    return;
                }

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        order_status,
                        order_ids
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();

                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });

            });
            // order delete
            $(document).on('click', '.order_delete', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var order = $('input.checkbox:checked').map(function() {
                    return $(this).val();
                });
                var order_ids = order.get();

                if (order_ids.length == 0) {
                    toastr.error('Please Select An Order First !');
                    return;
                }

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        order_ids
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();

                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });

            });

            // multiple print
            $(document).on('click', '.multi_order_print', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var order = $('input.checkbox:checked').map(function() {
                    return $(this).val();
                });
                var order_ids = order.get();

                if (order_ids.length == 0) {
                    toastr.error('Please Select Atleast One Order!');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url,
                    data: {
                        order_ids
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            console.log(res.items, res.info);
                            var myWindow = window.open("", "_blank");
                            myWindow.document.write(res.view);
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });
            // multiple courier
            $(document).on('click', '.multi_order_courier', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var order = $('input.checkbox:checked').map(function() {
                    return $(this).val();
                });
                var order_ids = order.get();

                if (order_ids.length == 0) {
                    toastr.error('Please Select An Order First !');
                    return;
                }

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        order_ids
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();

                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });

            });
        })
    </script>
@endsection
