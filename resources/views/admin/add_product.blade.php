@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm sản phẩm
                </header>
               
                <div class="panel-body">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span style="margin-left:42%;color:red;font-weight:bold">'.$message.'</span>';
                        Session::put('message', null);
                    }
                    ?>
                   
                    <div class="position-center">
                        <form role="form" action="{{ URL::to('/save-product') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label >Tên sản phẩm</label>
                                <input type="text" class="form-control" name="product_name"
                                    id="exampleInputEmail1" required="" >
                            </div>
                            <div class="form-group">
                                <label >Giá sản phẩm</label>
                                <input type="text" class="form-control" name="product_price"
                                    id="exampleInputEmail1" required="" >
                            </div>
                            <div class="form-group">
                                <label >Hình ảnh sản phẩm</label>
                                <input type="file" class="form-control" name="product_image"
                                    id="exampleInputEmail1" required="" >
                            </div>
                            <div class="form-group">
                                <label >Mô tả sản phẩm</label>
                                <textarea style="resize: none" rows="5" class="form-control col-lg-12"
                                    name="product_decs" required=""></textarea>
                            </div>

                            <div class="form-group">
                                <label >Nội dung sản phẩm</label>
                                <textarea style="resize: none" rows="5" class="form-control col-lg-12"
                                    name="product_content" required=""></textarea>
                            </div>
                           
                            <div class="form-group">
                                <label>Danh mục sản phẩm</label>
                                <select name="category_product" class="form-control input-sm m-bot15">
                                    @foreach ( $category_product as $key => $cate )
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Thương hiệu sản phẩm</label>
                                <select name="brand_product" class="form-control input-sm m-bot15">
                                    @foreach ( $brand_id as $key => $brand )
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Hiển thị</label>
                                <select name="product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm sản phẩm</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
