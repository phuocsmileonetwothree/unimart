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
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center flex-wrap">
            <h5 class="m-0 ">Danh sách bài viết</h5>

            {{-- NOTE --}}
            <span style="font-weight: 400;font-size: 0.85rem; font-style: italic; margin-top: 0.75rem">{{ show_note('post',
                'unknown_author') }}</span>
        </div>
        <div class="card-body">
            {{-- Filter - Search --}}
            <div class="analytic" style="display: flex; justify-content: space-between">
                <div class="filter">
                    @if (!empty($count))
                    @foreach ($count as $k => $v)
                    <a href="{{ url('admin/post/list?') . \Illuminate\Support\Arr::query(['status' => $k]) }}"
                        class="text-primary">{{ convert_filter($k) }}<span class="text-muted">({{ $v }})</span></a>
                    @endforeach
                    @endif
                </div>
                <div class="form-search" style="display: flex">
                    {{-- Search - DONE --}}
                    <form action="" method="GET">
                        <input type="text" class="form-control form-search" placeholder="Tìm kiếm" name="key"
                            value="{{ $key }}" style="margin-right: 5px">
                        <input type="submit" class="btn btn-primary">
                    </form>
                </div>
            </div>

            {!! Form::open(['method' => 'POST', 'url' => route('admin.post.action')]) !!}
            {{-- Action --}}
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" name="action">
                    <option>Chọn</option>
                    @if (!empty($posts->list_action))
                    @foreach ($posts->list_action as $item)
                    <option value="{{ $item }}">{{ convert_action($item) }}</option>
                    @endforeach
                    @endif
                </select>
                <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary">
            </div>



            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Tác giả</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($posts -> total() > 0)
                    @foreach ($posts as $post)
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $post->id }}">
                        </td>
                        <td scope="row">{{ $index }}</td>
                        <td><img width="80px" height="80px" src="{{ url($post->thumb) }}" alt=""></td>
                        <td><a href="">{{ $post->title }}</a></td>
                        <td>{{ $post->category->title }}</td>
                        <td>{{ !empty($post->user->name) ? $post->user->name : 'Không rõ tác giả' }}</td>
                        <td>{{ $post->created_at }}</td>
                        {{-- Delete Update --}}
                        <td>
                            <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.post.destroy', $post->id) }}" onclick="return confirm('{{ $posts->confirm }}')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>

                    </tr>
                    <?php $index++; ?>
                    @endforeach
                    @else
                    <tr class="bg-white">
                        <td colspan="7">Không tồn tại bài viết</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {!! Form::close() !!}
            @if ($posts -> total() > 0)
            {{ $posts->appends(request()->input())->links() }}
            @endif
        </div>
    </div>
</div>
@endsection