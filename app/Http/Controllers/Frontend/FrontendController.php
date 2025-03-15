<?php

namespace App\Http\Controllers\Frontend;

use shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers\ShurjopayController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Food;
use App\Models\Banner;
use App\Models\CreatePage;
use App\Models\Campaign;
use App\Models\CouponCode;
use App\Models\DeliveryZone;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\FoodVariable;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Review;
use DB;
class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Banner::where(['status' => 1, 'category_id' => 1])
            ->select('id', 'image', 'link')
            ->get();

        $hotdeal_top = Food::where(['status' => 1, 'topsale' => 1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'category_id')
            ->withCount('variable')
            ->limit(12)
            ->get();


        $reviews = Review::where(['status' => 'active'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('frontEnd.layouts.pages.index', compact('sliders', 'hotdeal_top', 'reviews'));
    }

    public function category($slug, Request $request)
    {

        $category = Category::where(['slug' => $slug, 'status' => 1])->first();
        $foods = Food::where(['status' => 1, 'category_id' => $category->id])
            ->orderBy('id', 'ASC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'category_id')->withCount('variable');
        if ($request->sort == 1) {
            $foods = $foods->orderBy('created_at', 'desc');
        } elseif ($request->sort == 2) {
            $foods = $foods->orderBy('created_at', 'asc');
        } elseif ($request->sort == 3) {
            $foods = $foods->orderBy('new_price', 'desc');
        } elseif ($request->sort == 4) {
            $foods = $foods->orderBy('new_price', 'asc');
        } elseif ($request->sort == 5) {
            $foods = $foods->orderBy('name', 'asc');
        } elseif ($request->sort == 6) {
            $foods = $foods->orderBy('name', 'desc');
        } else {
            $foods = $foods->latest();
        }
        $foods = $foods->paginate(30)->withQueryString();
        return view('frontEnd.layouts.pages.category', compact('category', 'foods'));
    }
    public function stock_check(Request $request)
    {
        $food = FoodVariable::where(['food_id' => $request->id, 'color' => $request->color, 'size' => $request->size])->first();

        $status = $food ? true : false;
        $response = [
            'status' => $status,
            'food' => $food
        ];
        return response()->json($response);
    }
    public function quick_view(Request $request)
    {
        $data['data'] = Food::where(['id' => $request->id, 'status' => 1])->with('images')->withCount('reviews')->first();
        $data = view('frontEnd.layouts.partials.quick_view', $data)->render();
        if ($data != '') {
            echo $data;
        }
    }
    public function search(Request $request)
    {
        $foods = Food::select('id', 'name', 'slug', 'new_price', 'old_price')
            ->withCount('variable')
            ->where('status', 1)
            ->with('image');
        if ($request->keyword) {
            $foods = $foods->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        $foods = $foods->paginate(36);
        $keyword = $request->keyword;
        return view('frontEnd.layouts.pages.search', compact('foods', 'keyword'));
    }


    public function shipping_charge(Request $request)
    {
        if ($request->id == NULL) {
            Session::put('shipping', 0);
        } else {
            $deliveryzone = DeliveryZone::where(['id' => $request->id, 'only_pos' => ''])->first();
            Session::put('shipping', $deliveryzone->amount);
        }

        $response = Cart::instance('shopping')->content();
        return response()->json($response);
    }


    public function contact(Request $request)
    {
        return view('frontEnd.layouts.pages.contact');
    }

    public function page($slug)
    {
        $page = CreatePage::where('slug', $slug)->firstOrFail();
        return view('frontEnd.layouts.pages.page', compact('page'));
    }

    public function payment_success(Request $request)
    {
        $order_id = $request->order_id;
        $shurjopay_service = new ShurjopayController();
        $json = $shurjopay_service->verify($order_id);
        $data = json_decode($json);

        if ($data[0]->sp_code != 1000) {
            Toastr::error('Your payment failed, try again', 'Oops!');
            if ($data[0]->value1 == 'customer_payment') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }

        if ($data[0]->value1 == 'customer_payment') {

            $customer = Customer::find(Auth::guard('customer')->user()->id);

            // order data save
            $order = new Order();
            $order->invoice_id = $data[0]->id;
            $order->amount = $data[0]->amount;
            $order->customer_id = Auth::guard('customer')->user()->id;
            $order->order_status = $data[0]->bank_status;
            $order->save();

            // payment data save
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->customer_id = Auth::guard('customer')->user()->id;
            $payment->payment_method = 'shurjopay';
            $payment->amount = $order->amount;
            $payment->trx_id = $data[0]->bank_trx_id;
            $payment->sender_number = $data[0]->phone_no;
            $payment->payment_status = 'paid';
            $payment->save();

            // order details data save
            foreach (Cart::instance('shopping')->content() as $cart) {
                $order_details = new OrderDetails();
                $order_details->order_id = $order->id;
                $order_details->food_id = $cart->id;
                $order_details->food_name = $cart->name;
                $order_details->cost_price = $cart->options->cost_price;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            }

            Cart::instance('shopping')->destroy();
            Toastr::error('Thanks, Your payment send successfully', 'Success!');
            return redirect()->route('home');
        }

        Toastr::error('Something wrong, please try agian', 'Error!');
        return redirect()->route('home');
    }
    public function payment_cancel(Request $request)
    {
        $order_id = $request->order_id;
        $shurjopay_service = new ShurjopayController();
        $json = $shurjopay_service->verify($order_id);
        $data = json_decode($json);

        Toastr::error('Your payment cancelled', 'Cancelled!');
        if ($data[0]->sp_code != 1000) {
            if ($data[0]->value1 == 'customer_payment') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }
    }
    public function livesearch(Request $request)
    {
        $foods = Food::select('id', 'name', 'slug', 'status')
            ->where('status', 1)
            ->with('image', 'start_price', 'end_price')
            ->withCount('variables');
        if ($request->keyword) {
            $foods = $foods->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        $foods = $foods->get();

        if (empty($request->category) && empty($request->keyword)) {
            $foods = [];
        }
        return view('frontEnd.layouts.ajax.search', compact('foods'));
    }

}
