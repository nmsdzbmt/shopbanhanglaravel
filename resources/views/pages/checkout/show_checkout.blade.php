@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div>
            <!--/breadcrums-->
            <div class="register-req">
                <p>Đăng kí hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
            </div>
            <!--/register-req-->

            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p>Điền thông tin địa chỉ nhận hàng</p>
                            <div class="form-one">
                                <form action="{{ URL::to('/save-checkout-customer') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="text" name="shipping_name" placeholder="Họ và tên" required="">
                                    <input type="text" placeholder="Email" name="shipping_email" required="">
                                    <input type="text" placeholder="Địa chỉ" name="shipping_address" required="">
                                    <input type="text" placeholder="Số điện thoại" name="shipping_phone" required="">
                                    <textarea name="shipping_note" placeholder="Ghi chú đơn hàng của bạn!" rows="6"></textarea>
                                    <input type="submit" value="Gửi"
                                        style="background-color: #FE980F; color:white; font-weight:bold;margin-top:10px" name="send_order"
                                        class="btn btn-default btn-sm">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="review-payment">
                <h2><a href="{{ URL::to('/show-cart') }}">XEM LẠI GIỎ HÀNG</a></h2>
            </div>

        </div>
    </section>
    <!--/#cart_items-->

@endsection
