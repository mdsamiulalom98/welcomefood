<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Food;
use App\Models\Foodimage;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\FoodVariable;
use App\Models\Size;
use File;

class FoodController extends Controller
{
    
    function __construct(){
        $this->middleware('permission:food-list|food-create|food-edit|food-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:food-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:food-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:food-delete', ['only' => ['destroy']]);
    }
    public function getSubcategory(Request $request)
    {
        $subcategory = DB::table("subcategories")
            ->where("category_id", $request->category_id)
            ->pluck('name', 'id');
        return response()->json($subcategory);
    }
    public function index(Request $request)
    {
        $data = Food::latest()->select('id','name','category_id','new_price','topsale','status')->with('image', 'category')->with('variables');
        if ($request->keyword) {
            $data = $data->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        $data = $data->paginate(50);
        return view('backEnd.food.index', compact('data'));
    }


    public function create(){
        $categories = Category::where('status', 1)->select('id', 'name', 'status')->get();
        $sizes = Size::where('status', '1')->get();
        return view('backEnd.food.create', compact('categories', 'sizes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $max_id = DB::table('food')->max('id');
        $max_id = $max_id? $max_id+1 : '1';
        $input = $request->except(['image', 'files', 'sizes', 'cost_prices', 'old_prices', 'new_prices', 'images']);
        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name . '-' . $max_id));

        

        $input['status'] = $request->status ? 1 : 0;
        $input['topsale'] = $request->topsale ? 1 : 0;
        $input['cost_price'] = $request->cost_prices[0];
        $input['old_price'] = $request->old_prices[0];
        $input['new_price'] = $request->new_prices[0];

        $save_data = Food::create($input);
 
        $pro_image = $request->file('image');
        if ($pro_image) {
            foreach ($pro_image as $key => $image) {
                $name =  time() . '-' . $image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $uploadPath = 'public/uploads/product/';
                $image->move($uploadPath, $name);
                $imageUrl = $uploadPath . $name;
                $pimage             = new Foodimage();
                $pimage->food_id = $save_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
        }
        if ($request->new_prices) {
            $size      = $request->sizes;
            $purchase   = $request->cost_prices;
            $old_price  = $request->old_prices;
            $new_price  = array_filter($request->new_prices);
                foreach ($new_price as $key => $price) {

                    $variable = new FoodVariable();
                    $variable->food_id = $save_data->id;
                    $variable->size = isset($size[$key]) ? $size[$key] : null;
                    $variable->cost_price = isset($purchase[$key]) ? $purchase[$key] : null;
                    $variable->old_price = isset($old_price[$key]) ? $old_price[$key] : null;
                    $variable->new_price = isset($new_price[$key]) ? $new_price[$key] : null;
                    $variable->pro_barcode = $this->barcode_generate();
                    $variable->save();
                }
            
        }
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('foods.index');
    }


    public function edit($id)
    {
        $edit_data = Food::with('images')->find($id);
        $categories = Category::where('status', 1)->select('id', 'name', 'status')->get();
        $subcategory = Subcategory::where('category_id', '=', $edit_data->category_id)->select('id', 'name','category_id', 'status')->get();
        $sizes = Size::where('status', '1')->get();
        $variables = FoodVariable::where('food_id', $id)->get();
        return view('backEnd.food.edit', compact('edit_data', 'categories', 'subcategory', 'sizes', 'variables'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

       
        
        $update_data = Food::find($request->id);
        $input = $request->except(['image', 'files', 'sizes', 'cost_prices', 'old_prices', 'new_prices', 'images', 'up_id', 'up_sizes', 'up_cost_prices', 'up_old_prices', 'up_new_prices', 'up_images', 'pro_barcodes', 'up_pro_barcodes']);
        // return $request->up_id;
       
        $last_id = Food::orderBy('id', 'desc')->select('id')->first();
        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name . '-' . $update_data->id));
        $input['status'] = $request->status ? 1 : 0;
        $input['topsale'] = $request->topsale ? 1 : 0;
        $input['cost_price'] = $request->up_cost_prices[0];
        $input['old_price'] = $request->up_old_prices[0];
        $input['new_price'] = $request->up_new_prices[0];
        $update_data->update($input);

        $images = $request->file('image');
        if ($images) {
            foreach ($images as $key => $image) {
                $name =  time() . '-' . $image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $uploadPath = 'public/uploads/product/';
                $image->move($uploadPath, $name);
                $imageUrl = $uploadPath . $name;

                $pimage             = new Foodimage();
                $pimage->food_id = $update_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
        }

        if ($request->up_id) {
            $update_ids = array_filter($request->up_id);
            $up_size    = $request->up_sizes;
            $up_purchase     = $request->up_cost_prices;
            $up_old_price    = $request->up_old_prices;
            $up_new_price    = $request->up_new_prices;
            $up_pro_barcode    = $request->up_pro_barcodes;
            if ($update_ids) {
                foreach ($update_ids as $key => $update_id) {
                    $upvariable =  FoodVariable::find($update_id);

                    $upvariable->food_id       = $update_data->id;
                    $upvariable->size             = $up_size ? $up_size[$key] : NULL;
                    $upvariable->cost_price       = $up_purchase[$key];
                    $upvariable->old_price        = $up_old_price ? $up_old_price[$key] : NULL;
                    $upvariable->new_price        = $up_new_price[$key];
                    $upvariable->save();
                }
            }
        }

        if ($request->new_prices) {
            $size      = $request->sizes;
            $purchase   = $request->cost_prices;
            $old_price  = $request->old_prices;
            $new_price  = array_filter($request->new_prices);;
                foreach ($new_price as $key => $price) {

                    $variable = new FoodVariable();
                    $variable->food_id = $update_data->id;
                    $variable->size = isset($size[$key]) ? $size[$key] : null;
                    $variable->cost_price = isset($purchase[$key]) ? $purchase[$key] : null;
                    $variable->old_price = isset($old_price[$key]) ? $old_price[$key] : null;
                    $variable->new_price = isset($new_price[$key]) ? $new_price[$key] : null;
                    $variable->pro_barcode = $this->barcode_generate();
                    $variable->save();
                }
            
        }

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('foods.index')->with('success','done');
    }

    public function inactive(Request $request)
    {
        $inactive = Food::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Food::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Food::find($request->hidden_id);
        foreach ($delete_data->variables as $variable) {
            File::delete($variable->image);
            $variable->delete();
        }
        foreach ($delete_data->images as $pimage) {
            File::delete($pimage->image);
            $pimage->delete();
        }
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
    public function imgdestroy(Request $request)
    {
        $delete_data = Foodimage::find($request->id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
    public function pricedestroy(Request $request)
    {
        $delete_data = FoodVariable::find($request->id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success', 'Product price delete successfully');
        return redirect()->back();
    }
    public function update_deals(Request $request)
    {
        $foods = Food::whereIn('id', $request->input('food_ids'))->update(['topsale' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Hot deals product status change']);
    }
    public function update_feature(Request $request)
    {
        $foods = Food::whereIn('id', $request->input('food_ids'))->update(['feature_product' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Feature product status change']);
    }
    public function update_status(Request $request)
    {
        $foods = Food::whereIn('id', $request->input('food_ids'))->update(['status' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Product status change successfully']);
    }
    public function barcode_update(Request $request)
    {
        $foods = FoodVariable::whereIn('id', $request->input('food_ids'))->update(['status' => $request->status]);
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
    
    public function barcodess(Request $request)
    {
        $foods = FoodVariable::get();
        foreach ($foods as $food) {
            $food->pro_barcode = str_pad($food->id, 8, '1', STR_PAD_LEFT); 
            $food->save();
        }
    }
    function barcode_generate() {
        $max_variable = DB::table('food_variables')->max(DB::raw('CAST(pro_barcode AS UNSIGNED)'));
        $starting_barcode = 100001;
        $max_barcode = $max_variable ? $max_variable : $starting_barcode;
        $new_barcode = $max_barcode + 1;
        return str_pad($new_barcode, 6, '0', STR_PAD_LEFT);
    }


    
}
