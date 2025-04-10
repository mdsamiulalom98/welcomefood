@extends('backEnd.layouts.master')
@section('title', 'Order Slip')
@section('content')
    <style>
        @page {
            size: 75mm 100mm;
            margin: 0;
        }

        .customer-invoice {
            margin-top: 20px;
        }

        .invoice_btn {
            margin-bottom: 16px;
            font-weight: 400;
        }

        p {
            margin: 0;
            font-size: 11px !important;
            font-weight: 400;
        }

        td {
            font-size: 11px !important;
            font-weight: 400;
        }

        @media print {
            .invoice-innter {
                width: 75mm;
                height: 100mm;
                margin: 0 auto;
                padding: 0mm;
                margin-left: -10px !important;
                margin-top: -25px !important;
                font-size: 11px !important !important;

            }

            .container,
            .row,
            .col-sm-12 {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .no-print,
            header,
            footer,
            .left-side-menu,
            .navbar-custom {
                display: none !important;
            }

            .invoice_btn {
                margin-bottom: 0 !important;
            }

            td {
                font-size: 11px !important;
                font-weight: 400;
            }

            p {
                margin: 0;
                font-size: 11px !important;
                font-weight: 400;
            }

            header,
            footer,
            .no-print,
            .left-side-menu,
            .navbar-custom {
                display: none !important;
            }
            /*
            style="background-image: url('https://forum.sambapos.com/uploads/default/optimized/3X/0/b/0b694ddb196f635bd4cfe2c3305bbfac26c45771_2_690x920.jpeg');background-repeat: no-repeat; background-size: 60%;background-position: left"
             */
        }
    </style>

    <section class="customer-invoice " >
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <a href="javascript:window.history.back();" class="no-print"><strong><i class="fe-arrow-left"></i> Back To
                            Order</strong></a>
                </div>
                <div class="col-sm-6">
                    <button onclick="printFunction()"class="no-print btn btn-xs btn-success waves-effect waves-light"><i
                            class="fa fa-print"></i></button>
                </div>
                <div class="pos__prints mt-3">
                    <div class="invoice-innter"
                        style="width:75mm;height:100mm;margin: 0 auto;background: #fff;overflow: hidden;padding:2px 8px;">
                        <div>
                            <img style=" height: 40px; width: auto; margin: 0 auto; display: block; " src="{{ asset($generalsetting->white_logo) }}" alt="">
                        </div>
                        <table style="width:100%; border:1px dashed;margin-top: 2px;">
                            <tr>
                                <td>
                                    <div class="invoice_to"
                                        style="text-align: left; padding: 1px 5px; display: grid ; grid-template-columns: 1fr 1fr; align-items: center;">
                                        <div class="invoice_form" style="text-align: left;">
                                            <p style="font-size:11px !important;font-weight:400;color:#000">Welcome Food
                                            </p>
                                            <p style="font-size:11px !important;font-weight:400;color:#000">
                                                {{ $contact->phone }}</p>
                                        </div>
                                        <div class="invoice_form" style="text-align: left;">
                                            <p style="font-size:11px !important;font-weight:400;color:#000"><strong>Invoice
                                                    No: </strong>{{ $order->invoice_id }}</p>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table style="width:100%">
                            <tr>
                                <td>
                                    <div class="invoice_to" style="text-align: center">
                                        <div class="invoice_form" style="text-align: center;">
                                            <p style="font-size:11px !important;font-weight:400;color:#000">To</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table style="width:100%; border:1px dashed;">
                            <tr>
                                <td style="">
                                    <div class="invoice_to" style="text-align: left; padding:1px 5px">
                                        <p style="font-size:11px !important;font-weight:400;color:#000;">
                                            {{ $order->shipping ? $order->shipping->name : '' }}
                                            ({{ $order->shipping ? $order->shipping->phone : '' }})</p>
                                        <p style="font-size:11px !important;font-weight:400;font-weight:400;color:#000;">
                                            Address:{{ $order->shipping ? $order->shipping->address : '' }}</p>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table style="width: 100%;padding-top: 0px;">
                            <thead >
                                <tr style="border-bottom: 1px dashed">
                                    <th style="font-size:11px !important;font-weight:400;color:#000; padding: 6px 0;">Qty</th>
                                    <th style="font-size:11px !important;font-weight:400;color:#000; padding: 6px 0;">Item Description</th>
                                    <th style="font-size:11px !important;font-weight:400;color:#000; text-align: right; padding: 6px 0;">Price</th>
                                </tr>
                            </thead>
                            <tbody style="border-bottom: 1px dashed">
                                @foreach ($order->orderdetails as $key => $value)
                                    <tr>
                                        <td style="font-size:11px !important;font-weight:400;color:#000">{{ $value->qty }}x </td>
                                        <td style="font-size:11px !important;font-weight:400;color:#000">
                                            {{ Str::limit($value->food_name, 25) }}</td>
                                        <td style="font-size:11px !important;font-weight:400;color:#000;text-align: right;">
                                            ৳{{ $value->sale_price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="border-bottom: 1px dashed;">
                                    <th style="font-size:13px !important;color:#000; padding: 8px 0;" colspan="2">Subtotal
                                    </th>
                                    <td style="font-size:11px !important;font-weight:400;color:#000; text-align: right; padding: 8px 0;">
                                        ৳{{ $order->amount + $order->discount - $order->shipping_charge }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:11px !important;font-weight:400;color:#000" colspan="2">
                                        Shipping(+)</td>
                                    <td style="font-size:11px !important;font-weight:400;color:#000; text-align: right;">
                                        ৳{{ $order->shipping_charge }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:11px !important;font-weight:400;color:#000" colspan="2">
                                        Discount(-)</td>
                                    <td style="font-size:11px !important;font-weight:400;color:#000; text-align: right;">
                                        ৳{{ $order->discount }}</td>
                                </tr>
                                <tr style="border-top: 1px dashed;">
                                    <td style="font-size:14px !important;font-weight:600;color:#000;padding: 6px 0;" colspan="2">Final
                                        Total</td>
                                    <td style="font-size:11px !important;font-weight:400;color:#000; text-align: right;">৳{{ $order->amount }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <table style="width: 100%;padding-top: 1px;">
                            </tbody>
                            <tr>
                                <td style="text-align: center;margin-top:0px">
                                    <div>
                                        <p style="border-top: 1px dashed;padding-top: 0px;padding-bottom: 0px">Thank You!
                                        </p>
                                        <p style="color:#000;">www.welcomefood.com</p>
                                    </div>
                                    <div style="width: 130px;overflow:hidden;margin: 0 auto;height:15px;">
                                        <img
                                            src="data:image/png;base64,{{ DNS1D::getBarcodePNG($order->invoice_id, 'C39+', 2.5) }}" />
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function printFunction() {
            window.print();
        }
    </script>
@endsection
