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
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            {{-- Search --}}
            <div class="form-search form-inline">
                <form action="" method="GET">
                    <input type="" class="form-control form-search" name="key" value="{{ $key }}" placeholder="Nhập tên sản phẩm hoặc danh mục">
                    <input type="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            {{-- Filter --}}
            <div class="analytic">
                @foreach ($count as $k => $v)
                <a href="{{ route('admin.product.list', ['status' => $k]) }}" class="text-primary">{{ convert_filter($k)
                    }}<span class="text-muted">({{ $v }})</span></a>
                @endforeach
            </div>
            {{-- Action --}}

            {!! Form::open(['url' => route('admin.product.action'), 'method' => 'POST']) !!}
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" name="action">
                    <option value="">Chọn</option>
                    @if (!empty($products -> list_action))
                    @foreach ($products -> list_action as $item)
                    <option value="{{ $item }}">{{ convert_action($item) }}</option>
                    @endforeach
                    @endif
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Tồn kho</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products -> total() > 0)
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $product->id }}">
                        </td>
                        <td>{{ $index }}</td>
                        <td><img src="{{ !empty($product->images[0]->url) ? url($product->images[0]->url) : " NONE" }}"
                                alt="" width="80px" height="80px"></td>
                        <td><a href="">{{ $product->name }}</a></td>
                        <td>{{ number_format($product->price, 0, ',', '.') }}₫</td>
                        <td>{{ $product->category->title }}</td>
                        <td>{{ $product->created_at->format('d-m-Y') }}</td>
                        <td><span class="badge badge-{{ convert_class_status($product->status) }}">{{
                                strtoupper($product->status) }}</span></td>
                        <td><span class="badge badge-{{ convert_class_status($product->stocking) }}">{{
                                strtoupper($product->stocking) }}</span></td>
                        <td>
                            <a href="{{ route('admin.product.edit', $product->id) }}"
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('admin.product.destroy', $product->id) }}"
                                onclick="return confirm('{{ $products->confirm }}')"
                                class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php $index++; ?>
                    @endforeach
                    @else
                    <tr class="bg-white">
                        <td>Không tồn tại sản phẩm</td>
                    </tr>
                    @endif

                </tbody>
            </table>
            {!! Form::close() !!}
            @if ($products -> total() > 0)
            {{ $products->appends(request()->input())->links() }}
            @endif
        </div>
    </div>
</div>
@endsection