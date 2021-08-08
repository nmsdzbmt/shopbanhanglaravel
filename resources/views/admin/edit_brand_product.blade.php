@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật thương hiệu sản phẩm
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
                        @foreach($edit_brand_product as $key => $edit_key)
                        <form role="form" action="{{ URL::to('/update-brand-product/'.$edit_key-> brand_id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Tên thương hiệu</label>
                                <input type="text" value="{{$edit_key -> brand_name}}" class="form-control" name="brand_product_name"
                                    id="exampleInputEmail1" required="" >
                            </div>
                            <div class="form-group">
                                <label>Mô tả thương hiệu</label>
                                <textarea style="resize: none" rows="5" class="form-control col-lg-12"
                                    name="brand_product_decs" required="">{{$edit_key -> brand_decs}}</textarea>
                            </div>
                            <button type="submit" name="update_brand_product" class="btn btn-info">Sửa thương hiệu</button>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection
