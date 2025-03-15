<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\GeneralSetting;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Food;
use App\Models\CreatePage;
use App\Models\SocialMedia;
use App\Models\DeliveryZone;
use App\Models\Contact;
use App\Models\Review;
use Carbon\Carbon;
use Response;
use Hash;
use Auth;
use Mail;
use Str;
use DB;

class FrontendController extends Controller
{


    public function categorymenu()
    {
        $data = Category::where(['status' => 1])->select('id', 'slug', 'name', 'image')->with('menusubcategories', 'menusubcategories.menuchildcategories')->get();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }

    public function hotdealfood()
    {
        $data = Food::where(['status' => 1])->select('id', 'slug', 'name', 'topsale', 'old_price', 'new_price')->with('image')->get();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }

    public function homepagefood()
    {
        $data = Category::where(['status' => 1])->select('id', 'slug', 'name')->with('foods', 'foods.image')->get();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }

    public function footermenuleft()
    {
        $data = CreatePage::where(['status' => 1])->select('id', 'slug', 'name')->limit(3)->get();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }
    public function footermenuright()
    {
        $data = CreatePage::where(['status' => 1])->select('id', 'slug', 'name')->skip(3)->limit(10)->get();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }
    public function socialmedia()
    {
        $data = SocialMedia::where(['status' => 1])->get();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }
    public function contactinfo()
    {
        $data = Contact::where(['status' => 1])->first();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }

    //   Home Page Function End ====================


    
    // ==============My Api ==============//
    
    public function appconfig()
    {
        $data = GeneralSetting::where('status', 1)->select('id', 'name', 'white_logo', 'dark_logo', 'favicon')->first();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }

    public function slider()
    {
        $data = Banner::where(['status' => 1, 'category_id' => 1])->select('id', 'image', 'status', 'category_id', 'link')->get();
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }
    
    
    public function main_cateogory(){
        $data = Category::where('status', 1)->select('id', 'name', 'slug', 'status', 'image')->get();
       return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }
    
    public function popular_items(){
        $data = Food::where(['status' => 1, 'topsale' => 1])
        ->orderBy('id', 'DESC')
        ->select('id', 'name', 'slug', 'new_price', 'old_price','category_id','description')
        ->with('variable','image','variables')->orderBy('id','DESC')
        ->withCount('variable')
        ->limit(12)
        ->get();
        
       return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
    }
    
    public function catfood($id)
    {
        $category = Category::where(['status' => 1, 'id' => $id])->select('id', 'name', 'slug')->first();
        $data = Food::where(['status' => 1, 'category_id' => $category->id])
        ->select('id', 'name', 'slug', 'new_price', 'old_price','category_id','description')
        ->with('variable','image','variables')->orderBy('id','DESC')->paginate(5);
        return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data, 'category' => $category]);
    }
    
     public function quick_view($id)
        {
            $data = Food::where(['id' => $id, 'status' => 1])->with('images', 'variables')->withCount('reviews')->first();
             return response()->json(['status' => 'success', 'message' => 'Data fatch successfully', 'data' => $data]);
       }
    
    
     public function shipping_charge (){
        $shippingcharges = DeliveryZone::where(['status'=>1])->get();
        return response()->json(['status'=>'success','message'=>'Data fetch successfully','shippingcharges'=>$shippingcharges]);
    }
    
    // public function search(Request $request)
    // {
    //     $data = Food::select('id', 'name', 'slug', 'new_price', 'old_price')
    //         ->withCount('variable')
    //         ->where('status', 1)
    //         ->with('image');
    //     if ($request->keyword) {
    //         $data = $data->where('name', 'LIKE', '%' . $request->keyword . "%");
    //     }
    //     $data = $data->paginate(36);
    //     $keyword = $request->keyword;
        
    //     return response()->json([
    //         'status'=>'success',
    //         'data'=>$data,
    //         'keyword'=>$keyword
    //         ]);
        
    //     return view('frontEnd.layouts.pages.search', compact('foods', 'keyword'));
    // }
    
    public function search(Request $request)
    {
        $data = Food::select('id', 'name', 'slug', 'new_price', 'old_price','category_id','description')
        ->with('variable','image','variables')->orderBy('id','DESC')
        ->withCount('variable');
        if ($request->keyword) {
            $data = $data->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category) {
            $data = $data->where('category_id', $request->category);
        }
        $data = $data->get();

        if (empty($request->category) && empty($request->keyword)) {
            $data = [];
        }
         return response()->json(['data' => $data]);
    }
    
    
    public function getReview() {
         $reviews = Review::where(['status' => 'active'])
        ->orderBy('id', 'DESC')
        ->get();
        
        return response()->json([
            'status'=> 'success',
            'data'=> $reviews, 
            ]);
        
    }
    
    
    
}
