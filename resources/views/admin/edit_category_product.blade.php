@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục sản phẩm
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
                        @foreach($edit_category_product as $key => $edit_key)
                        <form role="form" action="{{ URL::to('/update-category-product/'.$edit_key-> category_id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Tên danh mục</label>
                                <input type="text" value="{{$edit_key -> category_name}}" class="form-control" name="category_product_name"
                                    id="exampleInputEmail1" required="" >
                            </div>
                            <div class="form-group">
                                <label>Mô tả danh mục</label>
                                <textarea style="resize: none" rows="5" class="form-control col-lg-12"
                                    name="category_product_decs" required="">{{$edit_key -> category_decs}}</textarea>
                            </div>
                            <button type="submit" name="update_category_product" class="btn btn-info">Sửa danh mục</button>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection
