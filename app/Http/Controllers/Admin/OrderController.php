<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Customer;
use App\Models\OrderStatus;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\DeliveryZone;
use App\Models\Payment;
use App\Models\Food;
use App\Models\User;
use App\Models\Expense;
use App\Models\ExpenseCategories;
use App\Models\FoodVariable;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index', 'order_store', 'order_edit']]);
        $this->middleware('permission:order-create', ['only' => ['order_store', 'order_create']]);
        $this->middleware('permission:order-edit', ['only' => ['order_edit', 'order_update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
        $this->middleware('permission:order-invoice', ['only' => ['invoice']]);
        $this->middleware('permission:order-process', ['only' => ['process', 'order_process']]);
        $this->middleware('permission:order-process', ['only' => ['process']]);
    }
    public function index($slug, Request $request)
    {
        if ($slug == 'pos') {
            $show_data = Order::where('order_type', 'pos')->orderBy('id', 'DESC')->with('shipping', 'status');

            if (Auth::user()->hasRole('Waiter')) {
                $show_data = $show_data->where('waiter_id', Auth::user()->id);
            }

            if (Auth::user()->hasRole('Chef')) {
                $show_data = $show_data->where('chef_id', Auth::user()->id);
            }
            $order_status = (object) [
                'name' => 'POS Order',
                'orders_count' => $show_data->count(),
            ];
            if ($request->keyword) {
                $show_data = $show_data->where(function ($query) use ($request) {
                    $query->orWhere('invoice_id', 'LIKE', '%' . $request->keyword . '%')
                        ->orWhereHas('shipping', function ($subQuery) use ($request) {
                            $subQuery->where('phone', $request->keyword);
                        });
                });
            }
            $show_data = $show_data->paginate(50);
        } else {
            $order_status = OrderStatus::where('slug', $slug)
                ->withCount([
                    'orders' => function ($query) {
                        if (Auth::user()->hasRole('Waiter')) {
                            $query->where('waiter_id', Auth::user()->id);
                        }
                        if (Auth::user()->hasRole('Chef')) {
                            $query->where('chef_id', Auth::user()->id);
                        }
                    }
                ])
                ->first();
            $show_data = Order::where(['order_status' => $order_status->id])->latest()->with('shipping', 'status');
            if (Auth::user()->hasRole('Waiter')) {
                $show_data = $show_data->where('waiter_id', Auth::user()->id);
            }
            if (Auth::user()->hasRole('Chef')) {
                $show_data = $show_data->where('chef_id', Auth::user()->id);
            }

            $show_data = $show_data->paginate(50);
        }
        $users = User::get();
        return view('backEnd.order.index', compact('show_data', 'order_status', 'users'));
    }

    public function invoice($invoice_id)
    {
        $order = Order::where(['invoice_id' => $invoice_id])->with('orderdetails', 'payment', 'shipping', 'customer')->firstOrFail();
        return view('backEnd.order.slip', compact('order'));
    }

    public function process($invoice_id)
    {
        $data = Order::where(['invoice_id' => $invoice_id])->select('id', 'invoice_id', 'order_status', 'order_type')->with('orderdetails', 'shipping')->first();
        $deliveryzones = DeliveryZone::where('status', 1)->get();
        return view('backEnd.order.process', compact('data', 'deliveryzones'));
    }

    public function order_process(Request $request)
    {

        $link = OrderStatus::find($request->status)->slug;
        $order = Order::with('payment')->find($request->id);
        $order_status = $order->order_status;
        $order->order_status = $request->status;
        $order->admin_note = $request->admin_note;
        $order->save();

        $shipping_update = Shipping::where('order_id', $order->id)->first();
        $shipping_update->name = $request->name;
        $shipping_update->phone = $request->phone;
        $shipping_update->address = $request->address;
        $shipping_update->area = $request->area;
        $shipping_update->save();

        Toastr::success('Success', 'Order status change successfully');
        return redirect('admin/order/' . $link);
    }
    public function destroy(Request $request)
    {
        $order = Order::where('id', $request->id)->delete();
        $order_details = OrderDetails::where('order_id', $request->id)->delete();
        $shipping = Shipping::where('order_id', $request->id)->delete();
        $payment = Payment::where('order_id', $request->id)->delete();
        Toastr::success('Success', 'Order delete success successfully');
        return redirect()->back();
    }

    public function order_assign(Request $request)
    {
        $foods = Order::whereIn('id', $request->input('order_ids'))->update(['user_id' => $request->user_id]);
        return response()->json(['status' => 'success', 'message' => 'Order user id assign']);
    }

    public function order_status(Request $request)
    {
        $orders = Order::whereIn('id', $request->input('order_ids'))->update(['order_status' => $request->order_status]);
        return response()->json(['status' => 'success', 'message' => 'Order status change successfully']);
    }

    public function bulk_destroy(Request $request)
    {
        $orders_id = $request->order_ids;
        foreach ($orders_id as $order_id) {
            $order = Order::where('id', $order_id)->delete();
            $order_details = OrderDetails::where('order_id', $order_id)->delete();
            $shipping = Shipping::where('order_id', $order_id)->delete();
            $payment = Payment::where('order_id', $order_id)->delete();
        }
        return response()->json(['status' => 'success', 'message' => 'Order delete successfully']);
    }
    public function order_print(Request $request)
    {
        $orders = Order::whereIn('id', $request->input('order_ids'))->with('orderdetails', 'payment', 'shipping', 'customer')->get();
        $view = view('backEnd.order.print', ['orders' => $orders])->render();
        return response()->json(['status' => 'success', 'view' => $view]);
    }
    public function order_create()
    {
        $foods = Food::select('id', 'name', 'new_price', 'old_price', 'status')->get();
        $cartinfo = Cart::instance('sale')->content();
        $deliveryzones = DeliveryZone::where('status', 1)->get();
        $chefs = User::role('chef')->get();
        // return $chefs;
        Session::put('pos_shipping');
        Session::forget('pos_discount');
        Session::forget('product_discount');
        Session::forget('cpaid');
        Session::forget('cdue');
        return view('backEnd.order.create', compact('foods', 'cartinfo', 'deliveryzones', 'chefs'));
    }

    public function order_store(Request $request)
    {
        // return $request->all();
        if ($request->guest_customer) {
            $this->validate($request, [
                'guest_customer' => 'required',
            ]);
            $customer = Customer::find($request->guest_customer);
            $area = DeliveryZone::where('only_pos', 1)->first();
            $name = $customer->name;
            $phone = $customer->phone;
            $address = $area->name;
            $area = $area->id;
        } else {
            $this->validate($request, [
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'area' => 'required',
            ]);
            $name = $request->name;
            $phone = $request->phone;
            $address = $request->address;
            $area = $request->area;
        }

        if (Cart::instance('sale')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');
            return redirect()->back();
        }

        $subtotal = Cart::instance('sale')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $discount = Session::get('pos_discount') + Session::get('product_discount');

        $deliveryzone = DeliveryZone::where('status', 1)->where('id', $area)->first();

        $exits_customer = Customer::where('phone', $phone)->select('phone', 'id')->first();
        if ($exits_customer) {
            $customer_id = $exits_customer->id;
        } else {
            $password = rand(111111, 999999);
            $store = new Customer();
            $store->name = $name;
            $store->phone = $phone;
            $store->password = bcrypt($password);
            $store->verify = 1;
            $store->status = 'active';
            $store->save();
            $customer_id = $store->id;
        }

        // order data save
        $order = new Order();
        $order->invoice_id = rand(11111, 99999);
        $order->amount = ($subtotal + $deliveryzone->amount) - $discount;
        $order->discount = $discount ? $discount : 0;
        $order->shipping_charge = $deliveryzone->amount;
        $order->customer_id = $customer_id;
        $order->order_status = $deliveryzone->only_pos == 1 ? '3' : '1';
        $order->user_id = Auth::user()->id;
        $order->order_type = $deliveryzone->only_pos == 1 ? 'pos' : 'website';
        $order->save();

        if ($order->order_type == 'pos') {
            $slug = 'pos';
        } else {
            $slug = OrderStatus::find($order->order_status)->slug;
        }

        if (Auth::user()->hasRole('Waiter')) {
            $order->waiter_id = Auth::user()->id;
            $order->chef_id = $request->chef_id;
            $order->save();
        }

        // shipping data save
        $shipping = new Shipping();
        $shipping->order_id = $order->id;
        $shipping->customer_id = $customer_id;
        $shipping->name = $name;
        $shipping->phone = $phone;
        $shipping->address = $address;
        $shipping->area = $deliveryzone->name;
        $shipping->save();

        // payment data save
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->customer_id = $customer_id;
        $payment->payment_method = 'Cash On Delivery';
        $payment->amount = $order->amount;
        $payment->payment_status = 'paid';
        $payment->save();

        // order details data save
        foreach (Cart::instance('sale')->content() as $cart) {
            // return $cart;
            $order_details = new OrderDetails();
            $order_details->order_id = $order->id;
            $order_details->food_id = $cart->id;
            $order_details->food_name = $cart->name;
            $order_details->cost_price = $cart->options->cost_price;
            $order_details->product_discount = $cart->options->product_discount;
            $order_details->sale_price = $cart->price;
            $order_details->size = $cart->options->size;
            $order_details->qty = $cart->qty;
            $order_details->save();
        }

        Cart::instance('sale')->destroy();
        Session::forget('sale');
        Session::forget('pos_discount');
        Session::forget('product_discount');
        Session::forget('cpaid');
        Session::forget('cdue');
        Toastr::success('Thanks, Your order place successfully', 'Success!');
        return redirect()->route('admin.orders', $slug);
    }
    public function search(Request $request)
    {
        $qty = 1;
        $keyword = $request->keyword;
        $foods = Food::select('id', 'name', 'slug', 'new_price', 'old_price')->with('image', 'variables');
        if ($keyword) {
            $foods = $foods->where('name', 'LIKE', '%' . $keyword . "%");
        }
        $foods = $foods->get();
        if (empty($request->keyword)) {
            $foods = [];
        }
        return view('backEnd.order.search', compact('foods'));

    }
    public function cart_add(Request $request)
    {
        $food = Food::select('id', 'name', 'slug', 'new_price', 'old_price', 'cost_price')->where(['id' => $request->id])->first();
        $var_product = FoodVariable::where(['food_id' => $request->id, 'size' => $request->size])->first();
        $cost_price = $var_product ? $var_product->cost_price : 0;
        $old_price = $var_product ? $var_product->old_price : 0;
        $new_price = $var_product ? $var_product->new_price : 0;
        $stock = $var_product ? $var_product->stock : 0;
        $qty = 1;

        $cartitem = Cart::instance('sale')->content()->where('id', $food->id)->first();

        if ($cartitem) {
            $cart_qty = $cartitem->qty + $qty;
        } else {
            $cart_qty = $qty;
        }
        $cartinfo = Cart::instance('sale')->add([
            'id' => $food->id,
            'name' => $food->name,
            'qty' => $qty,
            'price' => $new_price,
            'weight' => 1,
            'options' => [
                'slug' => $food->slug,
                'image' => $food->image->image,
                'old_price' => $new_price,
                'cost_price' => $cost_price,
                'size' => $request->size,
            ],
        ]);
        return response()->json(compact('cartinfo'));
    }
    public function cart_content()
    {
        $cartinfo = Cart::instance('sale')->content();
        return view('backEnd.order.cart_content', compact('cartinfo'));
    }
    public function cart_details()
    {
        $cartinfo = Cart::instance('sale')->content();
        $discount = 0;
        foreach ($cartinfo as $cart) {
            $discount += $cart->options->product_discount * $cart->qty;
        }
        Session::put('product_discount', $discount);
        return view('backEnd.order.cart_details', compact('cartinfo'));
    }
    public function cart_increment(Request $request)
    {
        $qty = $request->qty + 1;
        $cartinfo = Cart::instance('sale')->update($request->id, $qty);
        return response()->json($cartinfo);
    }
    public function cart_decrement(Request $request)
    {
        $qty = $request->qty - 1;
        $cartinfo = Cart::instance('sale')->update($request->id, $qty);
        return response()->json($cartinfo);
    }
    public function cart_remove(Request $request)
    {
        $remove = Cart::instance('sale')->remove($request->id);
        $cartinfo = Cart::instance('sale')->content();
        return response()->json($cartinfo);
    }
    public function product_discount(Request $request)
    {
        $discount = $request->discount;
        $cart = Cart::instance('sale')->content()->where('rowId', $request->id)->first();
        $cartinfo = Cart::instance('sale')->update($request->id, [
            'options' => [
                'slug' => $cart->slug,
                'image' => $cart->options->image,
                'cost_price' => $cart->options->old_price,
                'cost_price' => $cart->options->cost_price,
                'size' => $cart->options->size,
                'product_discount' => $request->discount,
                'details_id' => $cart->options->details_id
            ],
        ]);
        return response()->json($cartinfo);
    }
    public function cart_shipping(Request $request)
    {
        $shipping = DeliveryZone::where(['status' => 1, 'id' => $request->id])->first()->amount;
        Session::put('pos_shipping', $shipping);
        return response()->json($shipping);
    }

    public function cart_clear(Request $request)
    {
        $cartinfo = Cart::instance('sale')->destroy();
        Session::forget('pos_shipping');
        Session::forget('pos_discount');
        Session::forget('product_discount');
        return redirect()->back();
    }

    public function order_edit($invoice_id)
    {
        $data = Order::where(['invoice_id' => $invoice_id])->select('id', 'invoice_id', 'order_status', 'order_type')->with('orderdetails', 'shipping')->first();
        $deliveryzones = DeliveryZone::where('status', 1)->get();
        $order = Order::where('invoice_id', $invoice_id)->first();
        $cartinfo = Cart::instance('sale')->destroy();
        $shippinginfo = Shipping::where('order_id', $order->id)->first();
        $chefs = User::role('chef')->get();
        Session::put('product_discount', $order->discount);
        Session::put('pos_shipping', $order->shipping_charge);
        $orderdetails = OrderDetails::where('order_id', $order->id)->get();
        foreach ($orderdetails as $ordetails) {
            $cartinfo = Cart::instance('sale')->add([
                'id' => $ordetails->food_id,
                'name' => $ordetails->food_name,
                'qty' => $ordetails->qty,
                'price' => $ordetails->sale_price,
                'weight' => $ordetails->weight ?? 1,
                'options' => [
                    'image' => $ordetails->image->image,
                    'cost_price' => $ordetails->cost_price,
                    'product_discount' => $ordetails->product_discount,
                    'size' => $ordetails->size,
                    'details_id' => $ordetails->id,
                ],
            ]);
        }
        $cartinfo = Cart::instance('sale')->content();
        return view('backEnd.order.edit', compact('cartinfo', 'deliveryzones', 'shippinginfo', 'order', 'data', 'chefs'));
    }

    public function order_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if (Cart::instance('sale')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');
            return redirect()->back();
        }

        if (Auth::user()->hasRole('Waiter')) {
            $order = Order::where('id', $request->order_id)->first();
            $order->chef_id = $request->chef_id;
            $order->waiter_id = Auth::user()->id;
            $order->save();
        }
        $subtotal = Cart::instance('sale')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $discount = Session::get('pos_discount') + Session::get('product_discount');
        $shipping_area = DeliveryZone::where('status', 1)->where('id', $request->area)->first();
        $exits_customer = Customer::where('phone', $request->phone)->select('phone', 'id')->first();
        if ($exits_customer) {
            $customer_id = $exits_customer->id;
        } else {
            $password = rand(111111, 999999);
            $store = new Customer();
            $store->name = $request->name;
            $store->slug = $request->name;
            $store->phone = $request->phone;
            $store->password = bcrypt($password);
            $store->verify = 1;
            $store->status = 'active';
            $store->save();
            $customer_id = $store->id;
        }

        // order data save
        $order = Order::where('id', $request->order_id)->first();
        $order->amount = ($subtotal + $shipping_area->amount) - $discount;
        $order->discount = $discount ? $discount : 0;
        $order->shipping_charge = $shipping_area->amount;
        $order->customer_id = $customer_id;
        $order->note = $request->note;
        $order->save();

        // shipping data save
        $shipping = Shipping::where('order_id', $request->order_id)->first();
        $shipping->order_id = $order->id;
        $shipping->customer_id = $customer_id;
        $shipping->name = $request->name;
        $shipping->phone = $request->phone;
        $shipping->address = $request->address;
        $shipping->area = $request->area ? $shipping_area->name : 'Free Shipping';
        $shipping->save();

        // payment data save
        $payment = Payment::where('order_id', $request->order_id)->first();
        $payment->order_id = $order->id;
        $payment->customer_id = $customer_id;
        $payment->payment_method = 'Cash On Delivery';
        $payment->amount = $order->amount;
        $payment->payment_status = 'pending';
        $payment->save();

        // order details data save
        foreach ($order->orderdetails as $orderdetail) {
            $item = Cart::instance('sale')->content()->where('id', $orderdetail->food_id)->first();
            if (!$item) {
                $orderdetail->delete();
            }
        }
        foreach (Cart::instance('sale')->content() as $cart) {
            $exits = OrderDetails::where('id', $cart->options->details_id)->first();
            if ($exits) {
                $order_details = OrderDetails::find($exits->id);
                $order_details->product_discount = $cart->options->product_discount;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            } else {
                $order_details = new OrderDetails();
                $order_details->order_id = $order->id;
                $order_details->food_id = $cart->id;
                $order_details->food_name = $cart->name;
                $order_details->cost_price = $cart->options->cost_price;
                $order_details->product_discount = $cart->options->product_discount;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            }
        }
        Cart::instance('sale')->destroy();
        Session::forget('pos_shipping');
        Session::forget('pos_discount');
        Session::forget('product_discount');
        Session::forget('cpaid');
        Toastr::success('Thanks, Your order place successfully', 'Success!');
        return redirect('admin/order/pending');
    }

    public function order_report(Request $request)
    {
        $users = User::where('status', 1)->get();
        $orders = OrderDetails::with('shipping', 'order')->whereHas('order', function ($query) {
            $query->where('order_status', 3);
        });
        if ($request->keyword) {
            $orders = $orders->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->user_id) {
            $orders = $orders->whereHas('order', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            });
        }
        if ($request->start_date && $request->end_date) {
            $orders = $orders->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        $total_purchases = $orders->sum(DB::raw('cost_price * qty'));
        $total_item = $orders->sum('qty');
        $total_sales = $orders->sum(DB::raw('sale_price * qty'));
        $orders = $orders->paginate(50);
        return view('backEnd.reports.order', compact('orders', 'users', 'total_purchases', 'total_item', 'total_sales'));
    }
    public function expense_report(Request $request)
    {
        $data = Expense::where('status', 1);
        if ($request->keyword) {
            $data = $data->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category_id) {
            $data = $data->where('expense_cat_id', $request->category_id);
        }
        if ($request->start_date && $request->end_date) {
            $data = $data->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        $data = $data->paginate(10);
        $categories = ExpenseCategories::where('status', 1)->get();
        return view('backEnd.reports.expense', compact('data', 'categories'));
    }
    public function loss_profit(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $total_expense = Expense::where('status', 1)->whereBetween('created_at', [$request->start_date, $request->end_date])->sum('amount');
            $total_purchase = OrderDetails::whereHas('order', function ($query) use ($request) {
                $query->where('order_status', 3)
                    ->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })->sum(DB::raw('cost_price * qty'));

            $total_sales = OrderDetails::whereHas('order', function ($query) use ($request) {
                $query->where('order_status', 3)
                    ->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })->sum(DB::raw('sale_price * qty'));
        } else {
            $total_expense = Expense::where('status', 1)->sum('amount');
            $total_purchase = OrderDetails::whereHas('order', function ($query) {
                $query->where('order_status', 3);
            })->sum(DB::raw('cost_price * qty'));

            $total_sales = OrderDetails::whereHas('order', function ($query) {
                $query->where('order_status', 3);
            })->sum(DB::raw('sale_price * qty'));
        }

        return view('backEnd.reports.loss_profit', compact('total_expense', 'total_purchase', 'total_sales'));
    }
}
