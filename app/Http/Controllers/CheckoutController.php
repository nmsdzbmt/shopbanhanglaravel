<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();
class CheckoutController extends Controller
{
    public function login_checkout(){
        $category_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        return view('pages.checkout.login_checkout')->with('category',$category_product)->with('brand',$brand_product);
    }

    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;

        $customer_id = DB::table('tbl_customer')->insertGetId($data);

        Session::put('customer_id',$customer_id);//lay id customer
        Session::put('customer_name',$request->customer_name);//lay ten customer

        return Redirect::to('/checkout');
    }


    public function checkout(){
        $category_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        return view('pages.checkout.show_checkout')->with('category',$category_product)->with('brand',$brand_product);
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_note'] = $request->shipping_note;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);

        return Redirect::to('/payment');
    }


    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login-checkout');
    }
//login customer
    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();
        if($result){
            Session::put('customer_id',$result->customer_id);//lay id customer
            return Redirect::to('/checkout');
        }else{
            return Redirect::to('/login-checkout');
        }
    }

    
    public function payment(){
        $category_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();


        return view('pages.checkout.payment')->with('category',$category_product)->with('brand',$brand_product);
    }

    public function order_place(Request $request){
        $category_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        //insert  payment method
        $payment_data = array();
        $payment_data['payment_method'] = $request->payment_option;
        $payment_data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($payment_data);

        //insert order method
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        $content = Cart::content();
        //insert order detail method
        foreach($content as $v_content){
            $order_d = array();
            $order_d['order_id'] = $order_id;
            $order_d['product_id'] = $v_content->id;
            $order_d['product_name'] = $v_content->name;
            $order_d['product_price'] = $v_content->price;
            $order_d['product_sales_quality'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_d);
        }
        if($payment_data['payment_method']==1){
            echo 'Trả bằng thẻ ATM';
        }else{
            Cart::destroy();
            return view('pages.checkout.handcash')->with('category',$category_product)->with('brand',$brand_product);
        }

         
    }
}
