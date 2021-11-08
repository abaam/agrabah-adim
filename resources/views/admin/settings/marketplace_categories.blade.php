@extends('admin.master')

@section('title', 'Categories')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4 col-md-6">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="\">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            {{--            <div class="title-action">--}}
            {{--                <a href="#" class="btn btn-primary">This is action area</a>--}}
            {{--            </div>--}}
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">

                @include('alerts.validation')
                <div class="ibox float-e-margins">
                    <div class="ibox-title p-2">
                        <h5>Categories</h5>
                        <button type="button" class="btn btn-success btn-xs float-right btn-action"
                                data-action="create-user">Create
                        </button>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive table-borderless">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th class="text-right"><i class="fa fa-cogs"></i></th>
                                </tr>
                                </thead>
                                <tbody id="tbody-users">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-right">
                                        <div class="btn-group text-right">
                                            <button class="btn-white btn btn-xs btn-action" data-action="user-edit"><i
                                                        class="fa fa-pencil text-success"></i> edit
                                            </button>
                                            <button class="btn-white btn btn-xs btn-action" data-action="user-delete"><i
                                                        class="fa fa-times text-danger"></i> delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div id="modal-size" class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{route('marketplace-categories-store')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-header" style="padding: 15px;">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add Category</h4>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Parent <small>(Required for Sub Categories)</small></label>
                            <select name="parent_id" class="form-control">
                                <option disabled selected>--</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="modal-save-btn">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal inmodal fade" id="edit_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div id="modal-size" class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{route('marketplace-categories-edit')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header" style="padding: 15px;">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
                        <h4 class="modal-title">Edit Category</h4>
                    </div>
                    <div class="modal-body bg-white">
                        <div class="form-group">
                            <label>Logo <small>(Leave blank to use existing)</small></label><br>
                            <div class="box">
                                <img src="" alt="" id="edit_image" width="18px">
                            </div>

                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="form-group">
                            <label>Parent <small>(Required for Sub Categories)</small></label>
                            <select name="parent_id" class="form-control" id="edit_parent">
                                <option disabled selected>--</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="modal-save-btn">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}

{{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
{{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
   {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}

    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>
        $(document).ready(function () {
            var modal = $('#modal');
            var modalEdit = $('#edit_modal');
            $(document).on('click', '.btn-action', function () {
                modal.modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
            $(document).on('click', '.btn-delete', function () {
                var deleteId = $(this).data('id');
                swal({
                    title: "Confirm Delete",
                    text: "Are you sure you want to delete?",
                    type: "error",
                    confirmButtonColor: "#5563dd",
                    confirmButtonText: "Confirm",
                    closeOnConfirm: true
                },function (isConfirm) {
                    if (isConfirm) {
                        $.get('{!! route('marketplace-categories-delete') !!}', {
                            id: deleteId,
                        }, function(res){
                            list();
                        });
                    }
                });
            });
            $(document).on('click', '.btn-edit', function () {
                var dataInfo = $(this).data();
                console.log(dataInfo)
                $("#edit_id").val(dataInfo.id)
                $("#edit_image").attr('src',dataInfo.logo)
                $("#edit_name").val(dataInfo.name);
                $("#edit_parent").val('');
                if(dataInfo.parent){
                    $("#edit_parent option[value='"+dataInfo.parent+"']").prop('selected',true);
                }
                modalEdit.modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });

            list();

            function list() {
                var box = $('#tbody-users');
                $.get('{!! route('marketplace-categories-list') !!}', function (data) {
                    if (data.length > 0) {
                        box.empty();
                        for (var a = 0; a < data.length; a++) {
                            let logo = '';
                            if(data[a].logo){
                                logo = '<img src="'+ data[a].logo + '" alt="' + data[a].name + '">';
                            }
                            box.append('' +
                                '<tr>' +
                                '<td>' +
                                logo +
                                '</td>' +
                                '<td>' + (data[a].parent_id?data[a].parent_cat.display_name+' - ':'') + data[a].display_name + '</td>' +
                                '<td class="text-right">' +
                                '<div class="btn-group text-right">' +
                                '<button class="btn-white btn btn-xs btn-edit" data-action="user-edit" data-id="' + data[a].id + '" data-name="' + data[a].display_name + '" data-parent="' + data[a].parent_id + '" data-logo="' + data[a].logo + '"><i class="fa fa-pencil text-success"></i> edit</button>' +
                                '<button class="btn-white btn btn-xs btn-delete" data-action="user-delete" data-id="' + data[a].id + '"><i class="fa fa-times text-danger"></i> delete</button>' +
                                '</div>' +
                                '</td>' +
                                '</tr>' +
                                '');
                        }
                    }
                });
            }
        });
    </script>
@endsection
