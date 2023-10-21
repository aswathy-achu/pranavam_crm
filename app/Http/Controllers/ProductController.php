<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Exceptions\Exception;

class ProductController extends Controller
{
    public function createproduct(){
        if (!Auth::check()){
            return redirect('/');
        }
        $page_data['productlist'] = Product::get();
        return view('createproduct')->with($page_data);

    }
    public function product_update(Request $request, $id = '')
    {
        try{
        if ($request->isMethod('post')) {
            if ($request->input('id') == '') {
                $product = new Product;
            } else {
                $product = Product::find($request->input('id'));
            }
            $product->product_name = $request->input('product_name');
            $product->product_selling_price = $request->input('product_selling_price');
            $product->description = $request->input('description');
            $product->product_buy_price = $request->input('product_buy_price');
            if ($request->hasFile('product_image')) {
                // Delete old profile image if it exists
                if ($product->product_image && Storage::exists('product_image/' . $product->product_image)) {
                    Storage::delete('course_file/' . $product->product_image);
                }
    
                $extension = $request->file('product_image')->extension();
                $filename = rand() . '.' . $extension;
                $request->file('product_image')->storeAs('product_image', $filename);
    
                $product->product_image = $filename;
            }
           
            $product->save();
            
            if ($request->input('id')) {
                return redirect('/productlist')->with('success', 'Update successful!');
            } else {
                return redirect('/productlist')->with('success', 'Add successful!');
            }
        }
        
        if ($id)  {
            $product = Product::find($id);
        } else {
            $product = null;
        }
        
        $page_data['menu'] = 'manage_product';
        
        return view('createproduct', compact('product', 'page_data'));
        } catch (Exception $e) {
            // Handle the exception here, log the error, display a user-friendly error page, or take any appropriate action.
            return redirect('/error')->with('error', 'An error occurred. Please try again later.');
        }
    }
    
    public function productlist(){
        if (!Auth::check()) {return Redirect::to('/');}

        $page_data['product'] = Product::get();
        return view('productlist')->with($page_data);
    }
    public function del_product(Request $request, $id)
    {   
        if (!Auth::check()) {return Redirect::to('/');}
        $data = Product::find($id);
        if ($data) {
            $data->delete();
            return Redirect::back()->with('success','Delete successfully!');
        } else {
            return Redirect::back()->with('error','Data Not Found');
        }
    }        
    public function productview($id=''){
        if (!Auth::check()) {return Redirect::to('/');}
        $page_data['product'] = Product::where('id',$id)->get();
        return view('productview')->with($page_data);
     }
}
 