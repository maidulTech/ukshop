@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">

@endpush
@section('product_list','active')
@section('Product Management','open')

@section('title')
    @lang('product.list_page_title')
@endsection

@section('page-name')
    @lang('product.list_page_sub_title')
@endsection

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')    </a>
    </li>
    <li class="breadcrumb-item active">@lang('product.breadcrumb_sub_title')
    </li>
@endsection

@php
    $roles = userRolePermissionArray()
@endphp

@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm card-success">
                        <div class="card-header">
                            @if(hasAccessAbility('new_product', $roles))
                            <a class="btn btn-sm btn-primary text-white" href="{{url('product/new')}}" title="ADD NEW PRODUCT MASTER"><i class="ft-plus text-white"></i> @lang('product.product_create_btn')</a>
                            @endif

                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive ">
                                    <table class="table table-striped table-bordered alt-pagination50 table-sm" id="indextable">
                                        <thead>
                                        <tr>
                                            <th class="text-center">@lang('tablehead.sl')</th>
                                            <th>@lang('tablehead.category')</th>
                                            <th>@lang('tablehead.brand')</th>
                                            <th>@lang('tablehead.model')</th>
                                            <th>@lang('tablehead.sku_prefix')</th>
                                            <th>@lang('tablehead.name')</th>
                                            <th>@lang('tablehead.image')</th>
                                            <th style="width: 120px;">@lang('tablehead.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @if(isset($rows) && ($rows->count() > 0))
                                        @foreach($rows as $row)
                                            <tr>
                                                <td class="text-center">{{$loop->index + 1}}</td>
                                                <td>
                                                    {{$row->subcategory->category->NAME ?? ''}}
                                                    <br>
                                                    -> {{$row->subcategory->NAME ?? ''}}
                                                </td>
                                                <td>{{$row->BRAND_NAME}}</td>
                                                <td>{{$row->MODEL_NAME}}</td>
                                                <td>{{$row->COMPOSITE_CODE}}</td>
                                                <td>{{$row->DEFAULT_NAME}}</td>
                                                <td class="text-center">
                                                    @if($row->PRIMARY_IMG_RELATIVE_PATH)
                                                    <img src="{{asset($row->PRIMARY_IMG_RELATIVE_PATH)}}" class="img-responsive" style="height: 50px;">
                                                    @else
                                                    <img src="{{asset('app-assets/images/no_image.jpg')}}" class="img-responsive" style="height: 50px;">
                                                    @endif
                                                </td>

                                                <td style="width: 120px;" class="text-center">
                                                    @if(hasAccessAbility('edit_product', $roles))
                                                    <a href="{{ route('admin.product.edit', [$row->PK_NO]) }}" class="btn btn-xs  btn-info" title="EDIT"><i class="la la-edit"></i></a>
                                                    @endif

                                                    @if(hasAccessAbility('view_product', $roles))
                                                    <a href="{{ route('admin.product.view', [$row->PK_NO]) }}" class="btn btn-xs  btn-success text-white" title="VIEW"><i class="la la-eye"></i></a>
                                                    @endif

                                                    @if(hasAccessAbility('delete_product', $roles))
                                                    <a href="{{ route('admin.product.delete', [$row->PK_NO]) }}" class="btn btn-xs btn-danger text-white" onclick="return confirm('Are you sure you want to delete the product with it\'s variant product ?')" title="DELETE"><i class="la la-trash"></i></a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach()
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('custom_js')
<script src="{{ asset('app-assets/js/scripts/tooltip/tooltip.js')}}"></script>
@endpush
