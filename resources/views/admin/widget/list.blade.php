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


        <div class="col-12">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Widget
                </div>
                <div class="card-body">
                    <table class="table table-striped index-js">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($widgets))
                            {{-- Duyệt các danh mục đầu tiên , parent_id = 0 --}}
                            <?php 
                            for($i = $paginate['start']; $i <= $paginate['end']; $i++){
                                if($i >= $paginate['total_row']){
                                    break;
                                }
                            ?>
                            <tr>
                                <td scope="col">{{ $paginate['index'] }}</td>
                                <td class="text-primary"><a href="" class="get-widget" data-title="{{ $widgets[$i]['title'] }}" data-url="{{ route('admin.widget.get_widget_image_ajax') }}" data-widget="{{ Str::slug($widgets[$i]['title'], "_") }}">{{ str_repeat('— ', $widgets[$i]['level']) . $widgets[$i]['title'] }}</a></td>
                                <td>{{ date('d-m-Y', strtotime($widgets[$i]['created_at'])) }}</td>
                                <td>
                                    @if ($widgets[$i]['parent_id'] != 0 and $widgets[$i]['editable'] != 0)
                                    <a href="{{ route('admin.widget.content.list', ['id' => $widgets[$i]['id']]) }}"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top"
                                        title="Thay đổi các phần tử trong widget">
                                        <i class="fas fa-keyboard"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            <?php
                            $paginate['index']++;} ?>
                            @endif

                        </tbody>
                    </table>
                    {!! get_pagging($paginate['page'], $paginate['total_page'], route('admin.widget.list', ['page' => ''])) !!}
                </div>

            </div>
        </div>

    </div>

</div>


<!-- Extra large modal -->
<style>
    .fit-img{
        width: 100%;
        height: auto;
    }
</style>
<div id="modal-widget" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myExtraLargeModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>
@endsection