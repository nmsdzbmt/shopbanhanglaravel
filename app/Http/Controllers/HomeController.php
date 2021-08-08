<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();
class HomeController extends Controller
{
    public function index(){
        $category_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id', 'desc')->get();
        $all_product = DB::table('tbl_product')->where('product_status','1')->orderby('product_id', 'desc')->limit(3)->get();

        return view('pages.home')->with('category',$category_product)->with('brand',$brand_product)->with('product',$all_product);
    }
}
