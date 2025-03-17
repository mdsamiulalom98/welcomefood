<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\FoodVariable;
use App\Models\Food;

class ShoppingController extends Controller
{

    public function cart_store(Request $request)
    {
        $food = Food::select('id', 'name')->where(['id' => $request->id])->first();
        if ($request->size) {
            $var_product = FoodVariable::where(['food_id' => $request->id, 'size' => $request->size])->first();
        } else {
            $var_product = FoodVariable::where(['food_id' => $request->id])->first();
        }
        $cartitem = Cart::instance('shopping')->content()->where('id', $var_product->id)->first();
        if ($cartitem) {
            $cart_qty = $cartitem->qty + ($request->qty ?? 1);
            $response = Cart::instance('shopping')->update($cartitem->rowId, $cart_qty);
        } else {
            $cart_qty = $request->qty ?? 1;

            $response = Cart::instance('shopping')->add([
                'id' => $var_product->food_id,
                'name' => $food->name,
                'qty' => $cart_qty,
                'price' => $var_product->new_price,
                'weight' => 1,
                'options' => [
                    'slug' => $var_product->slug,
                    'image' => $food->image->image,
                    'old_price' => $var_product->old_price,
                    'cost_price' => $var_product->cost_price,
                    'size' => $request->size,
                    'vat' => 0
                ],
            ]);
        }

        // if ($request->redirect == 'order_now') {
        //     return response()->json([
        //         'redirect' => 'order_now',
        //         'response' => $response,
        //     ]);
        // } else {
            return response()->json($response);
        // }
    }

    public function cart_increment(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $response = Cart::instance('shopping')->update($request->id, $qty);
        return response()->json($response);
    }

    public function cart_decrement(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $response = Cart::instance('shopping')->update($request->id, $qty);
        return response()->json($response);
    }

    public function cart_remove(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $response = Cart::instance('shopping')->content();
        return response()->json($response);
    }

    public function cart_count(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.partials.cart_count', compact('data'));
    }
    public function mini_cart(Request $request)
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.partials.mini_cart', compact('data'));
    }
    public function cart_data(Request $request)
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.partials.cart_data', compact('data'));
    }
    public function cart_summary(Request $request)
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.partials.cart_summary', compact('data'));
    }

    public function cart_increment_camp(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $response = Cart::instance('shopping')->update($request->id, $qty);
        return response()->json($response);
    }

    public function cart_decrement_camp(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $response = Cart::instance('shopping')->update($request->id, $qty);
        return response()->json($response);
    }
    public function cart_content_camp(Request $request)
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_camp', compact('data'));
    }

    public function wishlist_store(Request $request)
    {

        $food = Food::select('id', 'name')->where(['id' => $request->id])->first();
        $var_product = FoodVariable::where(['food_id' => $request->id])->first();

        Cart::instance('wishlist')->add([
            'id' => $food->id,
            'name' => $food->name,
            'qty' => $request->qty ?? 1,
            'price' => $var_product->new_price,
            'weight' => 1,
            'options' => [
                'slug' => $food->slug,
                'image' => $food->image->image,
                'old_price' => $var_product->old_price,
                'purchase_price' => $var_product->cost_price,
            ],
        ]);

        $data = Cart::instance('wishlist')->content();
        return response()->json($data);
    }
    public function wishlist_show()
    {
        $data = Cart::instance('wishlist')->content();
        return view('frontEnd.layouts.pages.wishlist', compact('data'));
    }
    public function wishlist_remove(Request $request)
    {
        Cart::instance('wishlist')->update($request->id, 0);
        Toastr::success('Food remove to wishlist successfully', 'Success!');
        return back();
    }

}
