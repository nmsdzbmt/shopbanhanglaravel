@extends('layout')
@section('content')
<div class="features_items">
    <!--features_items-->
    @foreach ($brand_name as $name => $bra_name)
    <h2 class="title text-center">{{$bra_name->brand_name}}</h2>
    @endforeach
    @foreach ( $brand_by_id as $key => $pro ) 
    <a href="{{URL::to('/chi-tiet-san-pham/'.$pro->product_id)}}">
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img src="{{URL::to('public/upload/product/'.$pro->product_image)}}" height="250" alt="" />
                    <h2>{{number_format($pro->product_price).' '.'VND'}}</h2>
                    <p>{{$pro->product_name}}</p>
                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                </div>
                <div class="product-overlay">
                    <div class="overlay-content">
                        <h2>{{number_format($pro->product_price).' '.'VND'}}</h2>
                        <p>{{$pro->product_name}}</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </a>
    @endforeach
</div>
<!--features_items-->
@endsection