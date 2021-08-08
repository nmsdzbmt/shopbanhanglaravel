@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật sản phẩm
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
                        @foreach ($edit_product as $key => $pro )
                        <form role="form" action="{{ URL::to('/update-product/'.$pro->product_id)}}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label >Tên sản phẩm</label>
                                <input type="text" class="form-control" name="product_name"
                                    id="exampleInputEmail1" required="" value="{{$pro->product_name}}" >
                            </div>
                            <div class="form-group">
                                <label >Giá sản phẩm</label>
                                <input type="text" class="form-control" name="product_price"
                                    id="exampleInputEmail1" required="" value="{{$pro->product_price}}">
                            </div>
                            <div class="form-group">
                                <label >Hình ảnh sản phẩm</label>
                                <input type="file" class="form-control" name="product_image" id="exampleInputEmail1" >
                                <img src="{{URL::to('public/upload/product/'.$pro->product_image)}}" height="100" width="100" alt="">
                            </div>
                            <div class="form-group">
                                <label >Mô tả sản phẩm</label>
                                <textarea style="resize: none" rows="5" class="form-control col-lg-12"
                                    name="product_decs" required="">{{$pro->product_decs}}</textarea>
                            </div>

                            <div class="form-group">
                                <label >Nội dung sản phẩm</label>
                                <textarea style="resize: none" rows="5" class="form-control col-lg-12"
                                    name="product_content" required="">{{$pro->product_content}}</textarea>
                            </div>
                           
                            <div class="form-group">
                                <label>Danh mục sản phẩm</label>
                                <select name="category_product" class="form-control input-sm m-bot15">
                                    @foreach ( $category_product as $key => $cate )
                                        @if ($cate->category_id==$pro->category_id)
                                            <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @else
                                            <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Thương hiệu sản phẩm</label>
                                <select name="brand_product" class="form-control input-sm m-bot15">
                                    @foreach ( $brand_id as $key => $brand )
                                        @if ($brand->brand_id==$pro->brand_id)
                                            <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @else
                                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endif 
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Cập nhật sản phẩm</button>
                        </form>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
