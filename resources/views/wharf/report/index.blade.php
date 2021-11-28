@extends('wharf.master')

@section('title', 'Report')

@section('content')


    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
{{--                <a href="{!! route('spot-market.create') !!}" class="btn btn-primary">Create</a>--}}
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form>
                        <div class="row">

                            @if(getRoleName() != 'enterprise-client')
                            <div class="col-sm-3 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="spot-market" {{$type=='spot-market'?'selected':''}}>Auction</option>
                                        <option value="market-place" {{$type=='market-place'?'selected':''}}>Marketplace</option>
                                        <option value="reverse-bidding" {{$type=='reverse-bidding'?'selected':''}}>Purchase Order</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-sm-3 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label for="">Date Range</label>
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="form-control-sm form-control" name="start" value="{{$start}}"/>
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control-sm form-control" name="end" value="{{$end}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-6 col-lg-2">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="_all" {{$status == '_all'?'selected':''}}>All</option>
                                        <option value="active" {{$status == 'active'?'selected':''}}>Active</option>
                                        <option value="expired" {{$status == 'expired'?'selected':''}}>Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <div class="mt-4 pt-2">
                                        <button class="btn btn-primary" name="mode" value="generate">Generate</button>
                                        <button class="btn btn-primary" name="mode" value="download">Download</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover datatables" >
                                <thead>
                                    <tr>
                                        <th>Date/Time Created</th>
                                        <th>Expiration</th>
                                        <th data-sortable="false">Photo</th>
                                        @if($type == 'reverse-bidding')
                                            <th>Items</th>
                                        @else
                                        <th>Name</th>
                                        <th>Selling Price</th>
                                        @endif
                                        @if($type!='market-place')
                                        <th>Bought Price</th>
                                        <th>Winner</th>
                                        @endif
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($row as $col)
                                        <tr>
                                            <td>{{$col->created_at}}</td>
                                            <td>{{$col->expiration_time}}</td>
                                            <td>
                                                @if($col->hasMedia($type))
                                                    <img class='img-thumbnail bidding_photos' src='{{config('app.wharf_url').$col->getFirstMediaUrl($type)}}' width="150px">
                                                @endif
                                            </td>
                                            @if($type == 'reverse-bidding')
                                                <td>
                                                    <ol>
                                                    @foreach($col->items as $item)
                                                            <li>{{$item->item_name}} -{{$item->quantity}}{{$item->unit_of_measure_short}} </li>
                                                    @endforeach
                                                    </ol>
                                                </td>
                                            @else
                                                <td>{{$col->name}}</td>
                                                <td>{{$type == 'reverse-bidding'?$col->asking_price:$col->original_price}}</td>
                                            @endif
                                            @if($type!='market-place')
                                            <td>{{$col->winner?$col->current_bid:'No Bidder'}}</td>
                                            <td>{{$col->winner?$col->winner->name??$col->winner->email:'No Bidder'}}</td>
                                            @endif
                                            <td>{{$col->status?'Completed':'Active'}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
{{--    {!! Html::style('/css/app.css') !!}--}}
{{--    {!! Html::style('/css/template/style.css') !!}--}}

    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css') !!}
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/template/plugins/steps/jquery.steps.css') !!}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::style('/css/template/plugins/daterangepicker/daterangepicker-bs3.css') !!}
    <style>
        .page-register.page-farmers .sign-in .right .steps ul li {
            width: calc(100%/2);
        }
        #datepicker input,
        #datepicker .input-group-addon{
            height: 38px;
            line-height: 28px;
        }
        .pagination{
            justify-content: flex-end;
        }
    </style>
    {{--{!! Html::style('/js/template/plugins/') !!}--}}
@endsection

@section('scripts')
    {{--{!! Html::script('') !!}--}}
{{--    <script src="{{ URL::to('/js/app.js') }}"></script>--}}
{{--    <script src="{{ URL::to('/js/template/inspinia.js') }}"></script>--}}
{{--    <script src="{{ URL::to('/js/template/plugins/metisMenu/jquery.metisMenu.js') }}"></script>--}}

    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js') !!}
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
    {!! Html::script('/js/template/plugins/steps/jquery.steps.min.js') !!}
    {!! Html::script('/js/template/plugins/validate/jquery.validate.min.js') !!}
    {!! Html::script('/js/template/plugins/slimscroll/jquery.slimscroll.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {!! Html::script('/js/template/plugins/daterangepicker/daterangepicker.js') !!}
    {!! Html::script('/js/template/plugins/dataTables/datatables.min.js') !!}
    {!! Html::script('/js/template/moment.js') !!}
    {!! Html::script('/js/template/numeral.js') !!}
    {!! Html::script('/js/template/numeral.js') !!}


    <script>
        $(document).ready(function(){

            $('.datatables').DataTable({
                pageLength: 25,
                responsive: true,
                "order": [[ 0, "desc" ]]
            });

            $('.input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'yyyy-mm-dd',
            });
        });
    </script>

@endsection
