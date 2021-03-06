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
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    
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
        $payment_data['payment_status'] = '??ang ch??? x??? l??';
        $payment_id = DB::table('tbl_payment')->insertGetId($payment_data);

        //insert order method
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = Cart::total();
        $order_data['order_status'] = '??ang ch??? x??? l??';
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
            echo 'Tr??? b???ng th??? ATM. Ch???c n??ng ??ang update';
        }else{
            Cart::destroy();
            return view('pages.checkout.handcash')->with('category',$category_product)->with('brand',$brand_product);
        }    
    }

//Show don hang
    public function manage_order(){
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->select('tbl_order.*', 'tbl_customer.customer_name')
            ->orderby('tbl_order.order_id', 'desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }
//view chi tiet don hang
    public function view_order($orderId){
        $this->AuthLogin();
        $all_order_by_id = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->select('tbl_order.*', 'tbl_customer.*', 'tbl_shipping.*', 'tbl_order_details.*')->first();
        $manager_order_by_id = view('admin.view_order')->with('all_order_by_id', $all_order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }
//Delete don hang
    public function delete_order($orderId){
        $this->AuthLogin();
        DB::table('tbl_order')->where('order_id', $order_id)->delete();
        Session::put('message', 'X??a s???n ph???m th??nh c??ng');
        return Redirect::to('all-order');
    }
}
