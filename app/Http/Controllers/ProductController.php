<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();
class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_product()
    {
        $this->AuthLogin();
        $category_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();
        return view('admin.add_product')->with(['category_product' => $category_product, 'brand_id' => $brand_product]);
    }

    //Select
    public function all_product()
    {
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')->orderby('tbl_product.product_id', 'desc')->get();
        $manager_product = view('admin.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }

    //Status
    public function unactive_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function active_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Không kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }

    //ADD
    public function save_product(Request $request)
    {
        $this->AuthLogin();
        $date = array();
        $date['product_name'] = $request->product_name;
        $date['product_price'] = $request->product_price;
        $date['product_decs'] = $request->product_decs;
        $date['product_content'] = $request->product_content;
        $date['category_id'] = $request->category_product;
        $date['brand_id'] = $request->brand_product;
        $date['product_status'] = $request->product_status;

        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image)); // lấy tên trước .
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //thêm đuôi
            $get_image->move('public/upload/product', $new_image); // chuyển hình
            $date['product_image'] = $new_image; // thêm csdl
            DB::table('tbl_product')->insert($date);
            Session::put('message', 'Thêm sản phẩm thành công');
            return Redirect::to('all-product');
        }
        $date['product_image'] = '';
        DB::table('tbl_product')->insert($date);
        Session::put('message', 'Thêm sản phẩm thành công');
        return Redirect::to('add-product');
    }

    //Update
    public function edit_product($product_id)
    {
        $this->AuthLogin();
        $category_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product', $edit_product)
            ->with(['category_product' => $category_product, 'brand_id' => $brand_product]);

        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }

    public function update_product(Request $request, $product_id)
    {
        $this->AuthLogin();
        $date = array();
        $date['product_name'] = $request->product_name;
        $date['product_price'] = $request->product_price;
        $date['product_decs'] = $request->product_decs;
        $date['product_content'] = $request->product_content;
        $date['category_id'] = $request->category_product;
        $date['brand_id'] = $request->brand_product;

        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image)); // lấy tên trước .
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //thêm đuôi
            $get_image->move('public/upload/product', $new_image); // chuyển hình
            $date['product_image'] = $new_image; // thêm csdl

            DB::table('tbl_product')->where('product_id', $product_id)->update($date);
            Session::put('message', 'Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }
        DB::table('tbl_product')->where('product_id', $product_id)->update($date);
        Session::put('message', 'Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }

    //Delete 
    public function delete_product($product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id', $product_id)->delete();
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }

    //Details
    public function detail_product($product_id){
        $category_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $detail_product = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')->where('tbl_product.product_id',$product_id)->get();
        
        // lấy ra category id
        foreach($detail_product as $key => $value){
            $category_id = $value->category_id;
        }
    
        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        ->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();

        return view('pages.product.show_detail_product')->with('category',$category_product)->with('brand',$brand_product)->with('detail_product',$detail_product)->with('related_product',$related_product);
    }

    //Search
    public function search_product(Request $request)
    {
        $category_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();

        $keywords = $request->keywords_submit;
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();

        return view('pages.product.search_product')->with('category',$category_product)->with('brand',$brand_product)->with('search_product',$search_product);
    }

}