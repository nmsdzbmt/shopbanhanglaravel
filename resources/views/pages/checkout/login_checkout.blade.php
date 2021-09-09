@extends('layout')
@section('content')
<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Đăng nhập tài khoản</h2>
                    <form action="{{URL::to('/login-customer')}}" method="post">
                        {{ csrf_field() }}
                        <input type="email" name="email_account" placeholder="Account or Email" required=""/>
                        <input type="password" name="password_account" placeholder="Password" required=""/>
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Lưu đăng nhập
                        </span>
                        <button type="submit" class="btn btn-default">Đăng nhập</button>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng kí người dùng</h2>
                    <form action="{{URL::to('/add-customer')}}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="customer_name" placeholder="Tên hiển thị" required="" />
                        <input type="email" name="customer_email" placeholder="Account or Email" required=""/>
                        <input type="password" name="customer_password" placeholder="Password" required=""/>
                        <input type="text" name="customer_phone" placeholder="Số điện thoại" required=""/>
                        <button type="submit" class="btn btn-default">Đăng kí</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->
@endsection