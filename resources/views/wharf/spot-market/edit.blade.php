@extends(subdomain_name().'.master')

@section('title', 'Add Listing')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('spot-market.index') }}">Lists</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <button type="button" class="btn btn-primary btn-action" data-action="store">Update</button>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">
        {{ Form::open(['route'=>['spot-market.update', $data->id],'id'=>'form','method'=>'put','files'=>true]) }}
            <div class="row">
                <div class="col-sm-12">
                    @csrf
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Product Listing
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <div>
                                    <img src="{{$data->getFirstMediaUrl('spot-market')}}" alt="" id="image_preview" width="250px">
                                </div>
                                <label>Photo</label>
                                <input accept="image/*" type="file" class="form-control" id="image" name="image">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{$data->name}}">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="summernote" name="description">
                                {!! $data->description !!}
                            </textarea>
                            </div>
                            <div class="form-group">
                                <label>Original Price</label>
                                <input type="text" class="form-control money" name="original_price" value="{{$data->original_price}}">
                            </div>
                            <div class="form-group">
                                <label>Selling Price</label>
                                <input type="text" class="form-control money" name="selling_price" value="{{$data->selling_price}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{ Form::close() }}

    </div>

    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category="" data-variant="" data-bal="">
        <div id="modal-size">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/template/plugins/summernote/summernote-bs4.css') !!}
    {{--    {!! Html::style('/css/template/plugins/dropzone/dropzone.css') !!}--}}
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/plugins/summernote/summernote-bs4.js') !!}
    {{--    {!! Html::script('/js/template/plugins/dropzone/dropzone.js') !!}--}}
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>

        // Dropzone.options.dropz
        function numberWithCommas(x) {
            return x.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).ready(function () {
            $('.summernote').summernote();


            var imgInp = document.getElementById('image');
            var imgPre = document.getElementById('image_preview');

            imgInp.onchange = evt => {
                const [file] = imgInp.files
                if (file) {
                    imgPre.src = URL.createObjectURL(file)
                }
            }

            $('.money').mask("#,##0.00", {reverse: true});

            $(document).on('click', '.btn-action', function () {
                switch ($(this).data('action')) {
                    case 'store':
                        $('#form').submit();

                        // console.log($('input[name=four_ps]').val());
                        // console.log($('input[name=pwd]').val());
                        // console.log($('input[name=indigenous]').val());
                        // console.log($('input[name=livelihood]').val());
                        break;
                }
            });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


            {{--var modal = $('#modal');--}}
            {{--$(document).on('click', '', function(){--}}
            {{--    modal.modal({backdrop: 'static', keyboard: false});--}}
            {{--    modal.modal('toggle');--}}
            {{--});--}}

            {{-- var table = $('#table').DataTable({--}}
            {{--     processing: true,--}}
            {{--     serverSide: true,--}}
            {{--     ajax: {--}}
            {{--         url: '{!! route('') !!}',--}}
            {{--         data: function (d) {--}}
            {{--             d.branch_id = '';--}}
            {{--         }--}}
            {{--     },--}}
            {{--     columnDefs: [--}}
            {{--         { className: "text-right", "targets": [ 0 ] }--}}
            {{--     ],--}}
            {{--     columns: [--}}
            {{--         { data: 'name', name: 'name' },--}}
            {{--         { data: 'action', name: 'action' }--}}
            {{--     ]--}}
            {{-- });--}}

            {{--table.ajax.reload();--}}

        });
    </script>
@endsection
