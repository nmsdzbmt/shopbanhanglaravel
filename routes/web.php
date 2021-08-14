<?php

use Illuminate\Support\Facades\Route;

//frontend
Route::get('/', 'HomeController@index');
Route::get('/trangchu', 'HomeController@index');
//Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}', 'CategoryProduct@show_category');
//Thuong hieu san pham trang chu
Route::get('/thuong-hieu-san-pham/{brand_id}', 'BrandProduct@show_brand');
//chi tiet san pham
Route::get('/chi-tiet-san-pham/{product_id}', 'ProductController@detail_product');


//backend
Route::get('/admin', 'AdminController@index');
Route::get('/logout', 'AdminController@index');
Route::get('/dashboard', 'AdminController@show_dashboard');
Route::post('/admin-dashboard', 'AdminController@dashboard');

//Category product
Route::get('/add-category-product', 'CategoryProduct@add_category_product');
Route::get('/all-category-product', 'CategoryProduct@all_category_product');

Route::post('/save-category-product', 'CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}', 'CategoryProduct@update_category_product');

Route::get('/edit-category-product/{category_product_id}', 'CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}', 'CategoryProduct@delete_category_product');

Route::get('/unactive-category-product/{category_product_id}', 'CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}', 'CategoryProduct@active_category_product');

//Brand product
Route::get('/add-brand-product', 'BrandProduct@add_brand_product');
Route::get('/all-brand-product', 'BrandProduct@all_brand_product');

Route::post('/save-brand-product', 'BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}', 'BrandProduct@update_brand_product');

Route::get('/edit-brand-product/{brand_product_id}', 'BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}', 'BrandProduct@delete_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}', 'BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}', 'BrandProduct@active_brand_product');

//Product
Route::get('/add-product', 'ProductController@add_product');
Route::get('/all-product', 'ProductController@all_product');

Route::post('/save-product', 'ProductController@save_product');
Route::post('/update-product/{brand_product_id}', 'ProductController@update_product');

Route::get('/edit-product/{product_id}', 'ProductController@edit_product');
Route::get('/delete-product/{product_id}', 'ProductController@delete_product');

Route::get('/unactive-product/{product_id}', 'ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'ProductController@active_product');

// Cart
Route::post('/save-cart', 'CartController@save_cart');//add cart
Route::post('/update-cart-quantity', 'CartController@update_cart_quantity');//update quantity
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/delete-to-cart/{rowId}', 'CartController@delete_to_cart');//delete product with cart

//Checkout
Route::get('/login-checkout', 'CheckoutController@login_checkout');