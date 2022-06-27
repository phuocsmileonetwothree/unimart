@extends('layouts.admin')
@section('wp-content')
<div id="content" class="container-fluid">
    <div class="message">
        @if (session('success') !== null)
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error') !== null)
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('warning') !== null)
        <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
    </div>
    <div class="row">

        <div class="col-4" style="padding-right: 0!important">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm danh mục
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.cat.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tên danh mục</label>
                            <input type="text" name="title" id="title"
                                class="form-control <?php if(!empty($errors->first('title'))) echo " is-invalid" ?>"
                            value="{{ old('title') }}">
                            @error('title')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Đường dẫn</label>
                            <input type="text" name="slug" id="slug"
                                class="form-control <?php if(!empty($errors->first('slug'))) echo " is-invalid" ?>"
                            value="{{ old('slug') }}">
                            @error('slug')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description"
                                class="form-control <?php if(!empty($errors->first('description'))) echo " is-invalid"
                                ?>" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Danh mục cha</label>
                            <select name="parent_id" id="parent_id" class="form-control  <?php if(!empty($errors->first('parent_id'))) echo " is-invalid" ?>">
                                <option value="">Chọn</option>
                                <option value="0" style="font-weight: bold">(Trống) Không có danh mục cha</option>
                                @if (!empty($list_category))
                                @foreach ($list_category as $category)
                                <option value="{{ $category['id'] }}">{{ str_repeat('— ', $category['level']) . $category['title']}}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('parent_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="brand_id">Thương hiệu phụ thuộc <small class="text-success">Mục đích : khách hàng lọc sản phẩm dễ dàng</small></label>
                            <select multiple name="brand_id[]" id="brand_id" class="form-control  <?php if(!empty($errors->first('brand_id'))) echo " is-invalid" ?>" style="height:300px">
                                <option value="0" style="font-weight: bold">Không thương hiệu con phụ thuộc</option>
                                @if (!empty($list_brand))
                                @foreach ($list_brand as $brand)
                                <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('brand_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" name="btn_create" value="Create" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>



        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục
                </div>
                <div class="card-body">
                    <table class="table table-striped index-js">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Đường dẫn</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($categories))
                            {{-- Duyệt các danh mục đầu tiên , parent_id = 0 --}}
                            <?php 
                            for($i = $paginate['start']; $i <= $paginate['end']; $i++){
                                if($i >= $paginate['total_row']){
                                    break;
                                }
                            ?>
                            <tr>
                                <td scope="col">{{ $paginate['index'] }}</td>
                                <td class="text-primary">{{ str_repeat('— ', $categories[$i]['level']) .
                                    $categories[$i]['title'] }}</td>
                                <td>{{ !empty($categories[$i]['description']) ? $categories[$i]['description'] : '—' }}</td>
                                <td>{{ $categories[$i]['slug'] }}</td>
                                <td>{{ date('d-m-Y', strtotime($categories[$i]['created_at'])) }}</td>
                                <td>
                                    <a href="{{ route('admin.product.cat.edit', $categories[$i]['id']) }}"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.product.cat.destroy', $categories[$i]['id']) }}"
                                        onclick="return confirm('{{ $confirm }}')"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            $paginate['index']++;} ?>
                            @endif

                        </tbody>
                    </table>
                    {{-- {{ $categories -> links() }} --}}
                    {{-- <nav>
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link"
                                    href="http://localhost/Back-End/LARAVELPro/Lesson/unimart/admin/page/list?page=1"
                                    rel="prev" aria-label="« Previous">‹</a>
                            </li>
                            <li class="page-item"><a class="page-link"
                                    href="http://localhost/Back-End/LARAVELPro/Lesson/unimart/admin/page/list?page=1">1</a>
                            </li>
                            <li class="page-item active" aria-current="page"><span class="page-link">2</span></li>


                            <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
                                <span class="page-link" aria-hidden="true">›</span>
                            </li>
                        </ul>
                    </nav> --}}
                    {!! get_pagging($paginate['page'], $paginate['total_page'], route('admin.product.cat.list', ['page' => ''])) !!}
                </div>
            </div>
        </div>

    </div>

</div>
@endsection