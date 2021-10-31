@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thương hiệu sản phẩm
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
                        <form role="form" action="{{ URL::to('/save-brand-product') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label >Tên thương hiệu</label>
                                <input type="text" data-validation="length" data-validation-length="min3" data-validation-error-msg="Tênthương hiệu không phù hợp" class="form-control" name="brand_product_name"
                                    id="exampleInputEmail1" required="" >
                            </div>
                            <div class="form-group">
                                <label >Mô tả thương hiệu</label>
                                <textarea style="resize: none" id="ckeditor" rows="5" class="form-control col-lg-12"
                                    name="brand_product_decs" required=""></textarea>
                            </div>
                            <div class="form-group">
                                <label>Hiển thị</label>
                                <select name="brand_product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm thương hiệu</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
