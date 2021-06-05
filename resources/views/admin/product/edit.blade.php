@extends('admin.layout.master')
<!--push from page-->
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('app-assets/file_upload/image-uploader.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/summernote.css')}}">

<!--for file uploads-->
<link rel="stylesheet" href="{{ asset('app-assets/file_upload/image-uploader.min.css')}}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<!--for tooltip-->
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-tooltip.css')}}">

<!--for image gallery-->
<link rel="stylesheet" href="{{ asset('app-assets/lightgallery/dist/css/lightgallery.min.css') }}">

@endpush('custom_css')

@section('product_list','active')
@section('Product Management','open')

@section('title') @lang('product.product_edit') @endsection

@section('page-name') @lang('product.product_edit') @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">@lang('product.breadcrumb_sub_title')    </li>
@endsection

<?php
    $categories_combo       = $data['category_combo'] ?? [];
    $vat_class_combo        = $data['vat_class_combo'] ?? [];
    $brand_combo            = $data['brand_combo'] ?? [];
    $subcategory_combo      = $data['subcategory_combo'] ?? array();
    $prod_model_combo       = $data['prod_model_combo'] ?? array();
    $prod_size_combo        = $data['prod_size_combo'] ?? array();
    $prod_color_combo       = $data['prod_color_combo'] ?? array();
    $hscode_combo           = $data['hscode_combo'] ?? array();

    $shipping_method_combo = [
        'AIR' => 'AIR',
        'SEA' => 'SEA'
    ];

    $roles = userRolePermissionArray();
    $active_tab = request('tab') ?? 1;
    $variant_id = request('variant_id') ?? null;
    $type = request('type') ?? null;

    $variant_info = $product;
    if ($variant_id) {
        //for update product variant data
        if ($product->allVariantsProduct) {
            foreach ($product->allVariantsProduct as $key => $variant) {

                if ($variant->PK_NO == $variant_id) {
                    $variant_info->allVariantPhotos = $variant->allVariantPhotos;

                    $variant_info->DEFAULT_NAME                     = $variant->VARIANT_NAME;
                    $variant_info->DEFAULT_CUSTOMS_NAME             = $variant->VARIANT_CUSTOMS_NAME;
                    $variant_info->CODE                             = $variant->CODE;
                    $variant_info->F_DEFAULT_VAT_CLASS              = $variant->F_VAT_CLASS;
                    $variant_info->DEFAULT_HS_CODE                  = $variant->HS_CODE;
                    $variant_info->DEFAULT_AIR_FREIGHT_CHARGE       = $variant->AIR_FREIGHT_CHARGE;
                    $variant_info->DEFAULT_SEA_FREIGHT_CHARGE       = $variant->SEA_FREIGHT_CHARGE;
                    $variant_info->DEFAULT_PRICE                    = $variant->REGULAR_PRICE;
                    $variant_info->DEFAULT_INSTALLMENT_PRICE        = $variant->INSTALLMENT_PRICE;
                    $variant_info->DEFAULT_LOCAL_POSTAGE            = $variant->LOCAL_POSTAGE;
                    $variant_info->DEFAULT_INTERDISTRICT_POSTAGE    = $variant->INTER_DISTRICT_POSTAGE;
                    $variant_info->DEFAULT_PREFERRED_SHIPPING_METHOD = $variant->PREFERRED_SHIPPING_METHOD;
                    $variant_info->IS_BARCODE_BY_MFG                = $variant->IS_BARCODE_BY_MFG;
                    $variant_info->DEFAULT_NARRATION                = $variant->NARRATION;
                    $variant_info->SHORT_NARRATION                  = $variant->SHORT_NARRATION;
                    $variant_info->PROMOTIONAL_MESSAGE              = $variant->PROMOTIONAL_MESSAGE;
                    $variant_info->F_COLOR_NO                       = $variant->F_COLOR_NO;
                    $variant_info->F_SIZE_NO                        = $variant->F_SIZE_NO;
                    $variant_info->BARCODE                          = $variant->BARCODE;


                }

            }
        }



    }

?>

@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-header">
                    <h4 class="card-title"><b>@lang('product.update_product')</b></h4>
                    <!--?php vError($errors) ?-->
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
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified no-border">
                            <li class="nav-item">
                                <a class="nav-link {{$active_tab == 1 ? 'active' : ''}}" id="productBasic-tab1" data-toggle="tab" href="#productBasic" aria-controls="productBasic" aria-expanded="true">@lang('product.product_info')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{$active_tab == 2 ? 'active' : ''}}" id="productVariant-tab1" data-toggle="tab" href="#productVariant" aria-controls="linkIcon1" aria-expanded="false">@lang('product.product_variant')</a>
                            </li>
                            <li class="nav-item {{$active_tab == 3 ? 'active' : ''}}">
                                <a class="nav-link" id="linkIconOpt1-tab1" data-toggle="tab" href="#linkIconOpt1" aria-controls="linkIconOpt1">@lang('product.stock_info')</a>
                            </li>
                        </ul>
                        <div class="tab-content border-tab-content">
                            <div role="tabpanel" class="tab-pane fade {{$active_tab == 1 ? 'show active' : ''}}" id="productBasic" aria-labelledby="productBasic-tab1" aria-expanded="true">
                                {!! Form::open([ 'route' => ['admin.product.update',$product->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                @csrf

                                {!! Form::hidden('pk_no', $product->PK_NO, ) !!}

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                            <label>{{trans('form.category')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('category', $categories_combo, $product->subcategory->F_PRD_CATEGORY_NO ?? '', ['class'=>'form-control mb-1 select2', 'id' => 'category', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select category', 'tabindex' => 1, 'data-url' => URL::to('prod_subcategory') ]) !!}
                                                {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('sub_category') ? 'error' : '' !!}">
                                            <label>{{trans('form.sub_category')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('sub_category', $subcategory_combo, $product->F_PRD_SUB_CATEGORY_ID, ['class'=>'form-control mb-1 select2', 'id' => 'sub_category', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select sub_category', 'tabindex' => 2, 'data-url' => URL::to('get_hscode_by_scat'),]) !!}
                                                {!! $errors->first('sub_category', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
                                            <label>{{trans('form.brand')}}</label>
                                            <div class="controls">
                                                {!! Form::select('brand', $brand_combo, $product->F_BRAND, ['class'=>'form-control mb-1 select2', 'id' => 'brand', 'placeholder' => 'Select brand', 'tabindex' => 3, 'data-url' => URL::to('prod_model') ]) !!}
                                                {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('prod_model') ? 'error' : '' !!}">
                                            <label>{{trans('form.model')}}</label>
                                            <div class="controls">
                                                {!! Form::select('prod_model', $prod_model_combo, $product->F_MODEL, ['class'=>'form-control mb-1 select2', 'id' => 'prod_model', 'placeholder' => 'Select model', 'tabindex' => 4]) !!}
                                                {!! $errors->first('prod_model', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                            <label>{{trans('form.generic_name')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text('name', $product->DEFAULT_NAME, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter product name', 'tabindex' => 5 ]) !!}
                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('vat_class') ? 'error' : '' !!}">
                                            <label>{{trans('form.vat_class')}}</label>
                                            <div class="controls">
                                                {!! Form::select('vat_class', $vat_class_combo, $product->F_DEFAULT_VAT_CLASS, ['class'=>'form-control mb-1 ', 'placeholder' => 'Select vat_class', 'tabindex' => 6]) !!}
                                                {!! $errors->first('vat_class', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('hs_code') ? 'error' : '' !!}">
                                            <label>{{trans('form.default_hs_code')}}</label>
                                            <div class="controls">
                                                {!! Form::select('hs_code', $hscode_combo, $product->DEFAULT_HS_CODE, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product HS code', 'tabindex' => 7, 'id' => 'hs_code']) !!}
                                                {!! $errors->first('hs_code', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <br>
                                            <div class="controls">
                                                <label><input type="checkbox" name="is_barcode_by_mfg" tabindex="8" {{ $product->IS_BARCODE_BY_MFG == 1 ? 'checked' : '' }} > <small>{{ trans('form.is_barcode_by_manufacturer') }} </small></label>
                                                {!! $errors->first('is_barcode_by_mfg', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>


                                    @if($product->allDefaultPhotos && $product->allDefaultPhotos->count() > 0)
                                     <p style="margin-left: 15px;">All Default Photos</p>
                                    <div class="col-md-12">
                                        <div class="row">

                                            @foreach($product->allDefaultPhotos as $photo)
                                            <div class="col-md-3" id="photo_div_{{$photo->PK_NO}}">
                                                <div class="form-group">
                                                    <div class="img-box" style="border: 2px solid #ccc; display: inline-block;">
                                                        <img src="{{asset($photo->RELATIVE_PATH)}}" class="img-fluid" style="width: 200px; height: 200px;">
                                                        <div class="img-box-child">
                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                            <button type="button" class="btn btn-danger photo-delete" data-id="{{$photo->PK_NO}}"><i class="la la-smile-o"></i>
                                                                Delete</button>

                                                        </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-12">
                                    <div class="form-group {!! $errors->has('def_narration') ? 'error' : '' !!}">
                                        <label>{{trans('form.default_description')}}</label>
                                        <div class="controls">
                                            {!! Form::textarea('def_narration', $product->DEFAULT_NARRATION, [ 'class' => 'form-control mb-1 summernote',  'placeholder' => 'Enter short description about the product', 'tabindex' => 9, 'rows' => 3 ]) !!}
                                            {!! $errors->first('def_narration', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active">{{trans('form.default_product_photos')}}</label>
                                                <div class="prod_def_photo_upload" style="padding-top: .5rem;" title="Click for photo upload"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="new_arrival">New Arrival</label>
                                                {!! Form::select('new_arrival', ['1' =>'Yes','0' => 'NO'],$product->NEW_ARRIVAL, ['class'=>'form-control mb-1','tabindex' => 11,'id'=>'new_arrival']) !!}
                                                {!! $errors->first('new_arrival', '<label class="help-block text-danger">:message</label>') !!}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active" for="is_feature">Is Feature</label>
                                                {!! Form::select('is_feature', ['1' =>'Yes','0' => 'NO'], $product->IS_FEATURE, ['class'=>'form-control mb-1','tabindex' =>12,'id'=>'is_feature' ]) !!}
                                                {!! $errors->first('is_feature', '<label class="help-block text-danger">:message</label>') !!}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active" for="max_order">Max Order</label>
                                                {!! Form::number('max_order',$product->MAX_ORDER, ['class'=>'form-control mb-1','tabindex' =>12,'min' => 1,'id'=>'max_order' ]) !!}
                                                {!! $errors->first('max_order', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                    <h6 class="text-bold bold">SEO META</h6>
                                    <hr>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active" for="meta_title">Meta Title</label>
                                                {!! Form::text('meta_title',$product->META_TITLE, ['class'=>'form-control mb-1','tabindex' =>12 ]) !!}
                                                {!! $errors->first('meta_title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active" for="meta_keywards">Meta Keyward</label>
                                                {!! Form::text('meta_keywards',$product->META_KEYWARDS, ['class'=>'form-control mb-1','tabindex' =>12 ]) !!}
                                                {!! $errors->first('meta_keywards', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active">Meta DESCRIPTION</label>
                                                {!! Form::textarea('meta_description',$product->META_DESCRIPTION, ['class'=>'form-control mb-1','tabindex' =>12 ,'rows'=>3]) !!}
                                                {!! $errors->first('meta_description', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-actions text-center">
                                            <a href="{{route('admin.product.list')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                                            <button type="submit" class="btn bg-primary bg-darken-1 text-white">
                                             <i class="la la-check-square-o"></i> {{ trans('form.btn_update') }} </button>
                                        </div>
                                    </div>
                                 </div>
                                 {!! Form::close() !!}
                             </div>

                            <!--##################product variant tab ##########################-->
                             <div class="tab-pane fade {{$active_tab == 2 ? 'show active' : ''}}" id="productVariant" role="tabpanel" aria-labelledby="productVariant-tab1" aria-expanded="false">



                    <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-sm card-smart">
                                <div class="card-header">
                                    <h4 class="card-title"><span title="Product category name">{{$product->subcategory->category->NAME ?? ''}}</span>&nbsp;>&nbsp;<span title="Product subcategory name">{{$product->subcategory->NAME ?? ''}}</span>&nbsp;>&nbsp;<span title="Product brand name">{{$product->BRAND_NAME ?? ''}}</span>&nbsp;>&nbsp;<span title="Product model name">{{$product->MODEL_NAME}}</span>&nbsp;:: Variants List
                                        {{-- @if($type == 'variant') --}}
                                        <a class="btn btn-round btn-xs btn-primary text-white" style="display: inline;" href="{{ route('admin.product.edit', [$product->PK_NO]) }}?type=variant&tab=2" ><i class="ft-plus text-white" ></i> New Variant</a>
                                        {{-- @endif --}}
                                    </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis font-medium-3"></i></a>
                                    <div class="heading-elements" style="top: 10px;">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show" style="">
                                    <div class="card-body card-body-sm">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-sm table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">@lang('tablehead.sl')</th>
                                                            <th class="text-center">{{trans('tablehead.variant_photos')}}</th>
                                                            <th>{{trans('tablehead.variant_name')}}</th>
                                                            <th>{{trans('tablehead.igcode')}}</th>
                                                            <th>{{trans('tablehead.sku')}}</th>
                                                            <th>{{trans('tablehead.variant_size')}}</th>
                                                            <th>{{trans('tablehead.variant_color')}}</th>
                                                            <th>{{trans('tablehead.variant_price')}}</th>
                                                            <th style="width: 100px;" class="text-center">{{trans('tablehead.action')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @if($product->allVariantsProduct &&  $product->allVariantsProduct->count() > 0)
                                                        @foreach($product->allVariantsProduct as $key => $row )
                                                        <tr class="{{$variant_id == $row->PK_NO ? 'active_tr' : '' }}">
                                                            <td class="text-center">{{$key+1}}</td>
                                                            <td width="80px;" class="text-center img_td">
                                                                @php $img_count = 0; @endphp
                                                                @if($row->allVariantPhotos && $row->allVariantPhotos->count() > 0)
                                                                <div class="lightgallery" style="margin:0px  auto; text-align: center; ">
                                                                    @php $img_count = $row->allVariantPhotos->count(); @endphp
                                                                    @for($i = 0; $i < $img_count; $i++ )
                                                                    @php $vphoto = $row->allVariantPhotos[$i]; @endphp
                                                                    <a class="img_popup " href="{{ asset($vphoto->RELATIVE_PATH)}}" style="{{ $i>0 ? 'display: none' : ''}}" title="{{$row->MRK_ID_COMPOSITE_CODE}}"><img style="width: 40px !important; height: 40px;" data-src="{{ asset($vphoto->RELATIVE_PATH)}}" alt="{{$row->MRK_ID_COMPOSITE_CODE}}" src="{{asset($vphoto->RELATIVE_PATH)}}" class="unveil"></a>
                                                                    @endfor
                                                                </div>


                                                                @endif
                                                                <span class="badge badge-pill badge-primary badge-square img_c" title="Total {{$img_count}} photos for the product">{{$img_count}}</span>
                                                            </td>
                                                            <td>{{$row->VARIANT_NAME}}</td>
                                                            <td>{{$row->MRK_ID_COMPOSITE_CODE}}</td>
                                                            <td>{{$row->COMPOSITE_CODE}}</td>
                                                            <td>{{$row->SIZE_NAME}}</td>
                                                            <td>{{$row->COLOR}}</td>
                                                            <td style="width: 120px;">
                                                                <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" data-html="true" class="w-tooltip" data-title="<h5>Local Postage Cost</h5><pre>SM : RM {{number_format($row->LOCAL_POSTAGE,2)}} </pre><pre>SS : RM {{number_format($row->INTER_DISTRICT_POSTAGE,2)}} </pre><pre>Airfreight : {{number_format($row->AIR_FREIGHT_CHARGE,2)}} </pre><pre>Seafreight : {{number_format($row->SEA_FREIGHT_CHARGE,2)}} </pre>" data-original-title="" title="" data-popup="tooltip-custom"  data-bg-color="white">(RM) {{ number_format($row->REGULAR_PRICE,2)}}/{{ number_format($row->INSTALLMENT_PRICE,2)}}</a>
                                                            </td>
                                                            <td style="width: 100px;" class="text-center">
                                                                @if(hasAccessAbility('edit_product', $roles))
                                                                <a href="{{ route('admin.product.edit', [$product->PK_NO]) }}?variant_id={{$row->PK_NO}}&type=variant&tab=2"  class="btn btn-xs btn-info mr-1" ><i class="la la-edit" title="Edit product variant"></i></a>
                                                                @endif

                                                                @if(hasAccessAbility('delete_product', $roles))
                                                                <a href="{{ route('admin.product_variant.delete', [$row->PK_NO]) }}" class="btn btn-xs btn-danger mr-1" onclick="return confirm('Are you sure you want to delete the product variant ?')" title="DELETE"><i class="la la-trash"></i></a>


                                                                @endif

                                                            </td>
                                                        </tr>
                                                        @endforeach()
                                                        @else
                                                        <tr>
                                                            <td colspan="9" class="text-center">Data not found</td>

                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                @if($variant_id)
                {!! Form::open([ 'route' => ['admin.product_variant.update',$variant_id], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                {!! Form::hidden('variant_pk_no', $variant_id, ) !!}
                @else
                {!! Form::open([ 'route' => ['admin.product_variant.store'], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                @endif

                @csrf

                {!! Form::hidden('pk_no', $product->PK_NO, ) !!}
                    <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-sm card-smart">
                                <div class="card-header" >
                                    <h4 class="card-title">@lang('product.product_variant')</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis font-medium-3"></i></a>
                                    <div class="heading-elements" style="top: 10px;">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="{{$type == 'ft-minus' ? 'show' : 'ft-plus'}} "></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse {{$type == 'variant' ? 'show' : 'hide'}}" style="">
                                    <div class="card-body card-body-sm">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('color') ? 'error' : '' !!}">
                                                    <div>
                                                        <label>{{trans('form.color')}}<span class="text-danger">*</span></label>
                                                        @if(hasAccessAbility('new_color', $roles))
                                                        <button type="button" class="btn btn-icon btn-info btn-xs pull-right" title="ADD COLOR FOR THE BRAND" data-toggle="modal" data-target="#colorAddModal" data-brand_name="{{$product->BRAND_NAME ?? ''}}" data-brand_id="{{$product->F_BRAND ?? ''}}" id="colorAdd">&nbsp;+ C&nbsp;</button>
                                                        @endif
                                                    </div>
                                                    <div class="controls">
                                                        {!! Form::select('color', $prod_color_combo, $variant_info->F_COLOR_NO ?? null, ['class'=>'form-control mb-1 select2 set_variant_name', 'id' => 'color', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select color', 'tabindex' => 10]) !!}

                                                        {!! $errors->first('color', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('color') ? 'error' : '' !!}">
                                                    <div>
                                                        <label>{{trans('form.size')}}<span class="text-danger">*</span></label>
                                                        @if(hasAccessAbility('new_size', $roles))
                                                        <button type="button" class="btn btn-icon btn-info btn-xs pull-right" title="ADD SIZE FOR THE BRAND" data-toggle="modal" data-target="#sizeAddModal" data-brand_name="{{$product->BRAND_NAME ?? ''}}" data-brand_id="{{$product->F_BRAND ?? ''}}" id="sizeAdd">&nbsp;+ S&nbsp;</button>
                                                        @endif
                                                    </div>
                                                    <div class="controls">
                                                        {!! Form::select('size', $prod_size_combo, $variant_info->F_SIZE_NO ?? null, ['class'=>'form-control mb-1 select2 set_variant_name', 'id' => 'size', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select size', 'tabindex' => 11]) !!}
                                                        {!! $errors->first('size', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('color') ? 'error' : '' !!}">
                                                    <label>{{trans('form.barcode')}}</label>
                                                    <div class="controls">
                                                        {!! Form::text('barcode', $variant_info->BARCODE ?? null, [ 'class' => 'form-control mb-1', 'id' => 'barcode', 'placeholder' => 'Enter product barcode', 'tabindex' =>12  ]) !!}
                                                        {!! $errors->first('barcode', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <br>
                                                    <div class="controls mt-1">
                                                        <label>

                                                            <input id="barcode_by_mfg" type="checkbox" name="is_barcode_by_mfg" tabindex="13" {{ $variant_info->IS_BARCODE_BY_MFG == 1 ? 'checked' : '' }} >

                                                            <small>{{ trans('form.is_barcode_by_manufacturer') }} </small></label>
                                                        {!! $errors->first('is_barcode_by_mfg', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                                    <label>{{trans('form.name')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::text('name', $variant_info->DEFAULT_NAME, [ 'class' => 'form-control mb-1', 'id' => 'variant_name',  'data-variant_name' => $variant_info->DEFAULT_NAME,  'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter product name', 'tabindex' => 14 ]) !!}
                                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('vat_class') ? 'error' : '' !!}">
                                                    <label>{{trans('form.vat_class')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('vat_class', $vat_class_combo, $variant_info->F_DEFAULT_VAT_CLASS ?? 3, ['class'=>'form-control mb-1 ','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select vat_class', 'tabindex' => 15]) !!}
                                                        {!! $errors->first('vat_class', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('hs_code') ? 'error' : '' !!}">
                                                    <label>{{trans('form.hs_code')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::text('hs_code', $variant_info->DEFAULT_HS_CODE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter product HS code', 'tabindex' => 16 ]) !!}
                                                        {!! $errors->first('hs_code', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <h5><strong>PRODUCT PRICE -------------------</strong></h5>
                                                <hr>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group  {!! $errors->has('price') ? 'error' : '' !!}">
                                                    <label>{{trans('form.price')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('price', $variant_info->DEFAULT_PRICE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter price for fixed', 'tabindex' => 17, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point' ]) !!}
                                                        {!! $errors->first('price', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('price_ins') ? 'error' : '' !!}">
                                                    <label>{{trans('form.price_ins')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('price_ins', $variant_info->DEFAULT_INSTALLMENT_PRICE, ['class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter price for installment', 'tabindex' => 18, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                                        {!! $errors->first('price_ins', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('air_freight') ? 'error' : '' !!}">
                                                    <label>{{trans('form.air_freight')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('air_freight', $variant_info->DEFAULT_AIR_FREIGHT_CHARGE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter air freight cost', 'tabindex' => 19, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                                        {!! $errors->first('air_freight', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('sea_freight') ? 'error' : '' !!}">
                                                    <label>{{trans('form.sea_freight')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('sea_freight', $variant_info->DEFAULT_SEA_FREIGHT_CHARGE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter sea freight cost', 'tabindex' => 20,'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point' ]) !!}
                                                        {!! $errors->first('sea_freight', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('local_postage') ? 'error' : '' !!}">
                                                    <label>{{trans('form.local_postage')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('local_postage', $variant_info->DEFAULT_LOCAL_POSTAGE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter postage cost for local', 'tabindex' => 21, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                                        {!! $errors->first('local_postage', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('int_postage') ? 'error' : '' !!}">
                                                    <label>{{trans('form.interdistric_postage')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('int_postage', $variant_info->DEFAULT_INTERDISTRICT_POSTAGE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter postage cost for interdistrict', 'tabindex' => 22, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point' ]) !!}
                                                        {!! $errors->first('int_postage', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {!! $errors->has('def_shipping_method') ? 'error' : '' !!}">
                                                    <label>{{trans('form.preffered_shipping_method')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('def_shipping_method', $shipping_method_combo, $variant_info->DEFAULT_PREFERRED_SHIPPING_METHOD, ['class'=>'form-control mb-1','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select preffered shipping method', 'tabindex' => 23]) !!}
                                                        {!! $errors->first('def_shipping_method', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('promotional_message') ? 'error' : '' !!}">
                                                    <label>Promotional Message</label>
                                                    <div class="controls">
                                                        {!! Form::textarea('promotional_message', $variant_info->PROMOTIONAL_MESSAGE, [ 'class' => 'form-control mb-1 summernote', 'tabindex' => 24, 'rows' => 1 ]) !!}
                                                        {!! $errors->first('promotional_message', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('def_narration') ? 'error' : '' !!}">
                                                    <label>{{trans('form.description')}}</label>
                                                    <div class="controls">
                                                        {!! Form::textarea('narration', $variant_info->DEFAULT_NARRATION, [ 'class' => 'form-control mb-1 summernote', 'data-validation-required-message' => 'This field is required', 'tabindex' => 24, 'rows' => 3 ]) !!}
                                                        {!! $errors->first('def_narration', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('short_narration') ? 'error' : '' !!}">
                                                    <label>{{trans('form.short_description')}}</label>
                                                    <div class="controls">
                                                        {!! Form::textarea('short_narration', $variant_info->SHORT_NARRATION, [ 'class' => 'form-control mb-1 summernote', 'tabindex' => 24, 'rows' => 2 ]) !!}
                                                        {!! $errors->first('short_narration', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>


                                            @if($variant_info->allVariantPhotos && $variant_info->allVariantPhotos->count() > 0)
                                             <p style="margin-left: 15px;">All Variant Photos</p>
                                            <div class="col-md-12">
                                                <div class="row">

                                                    @foreach($product->allVariantPhotos as $photo)
                                                    <div class="col-md-2" id="photo_div_{{$photo->PK_NO}}">
                                                        <div class="form-group">
                                                            <div class="img-box" style="border: 2px solid #ccc; display: inline-block;">
                                                                <img src="{{asset($photo->RELATIVE_PATH)}}" class="img-fluid">
                                                                <div class="img-box-child">
                                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                    <button type="button" class="btn btn-success"><i class="la la-search"></i>
                                                                        Show</button>
                                                                    <button type="button" class="btn btn-danger photo-delete" data-id="{{$photo->PK_NO}}"><i class="la la-smile-o"></i>
                                                                        Delete</button>

                                                                </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif




                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <label class="active">{{trans('form.product_variant_photos')}}</label>
                                                        <div class="product_variant_photos" style="padding-top: .5rem;" title="Click for photo upload"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-actions text-center">
                                                    <a href="{{route('admin.product.list')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> Cancel</a>
                                                    <button type="submit" class="btn bg-primary bg-darken-1 text-white">
                                                     <i class="la la-check-square-o"></i> Save @if($variant_id) change @endif</button>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                {!! Form::close() !!}
                            </div>
                            <!--############ product variant tab end ##################-->

                            <div class="tab-pane fade {{$active_tab == 3 ? 'show active' : ''}}" id="linkIconOpt1" role="tabpanel" aria-labelledby="linkIconOpt1-tab1" aria-expanded="false">
                                <p>Cookie icing tootsie roll cupcake jelly-o sesame snaps. Gummies cookie dragée cake jelly marzipan
                                    donut pie macaroon. Gingerbread powder chocolate cake icing. Cheesecake gummi bears ice cream
                                    marzipan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@include('admin.product._color_size_add_modal')




@endsection
<!--push from page-->
@push('custom_js')

<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js')}}"></script>

<!--for image upload-->
<script type="text/javascript" src="{{ asset('app-assets/file_upload/image-uploader.min.js')}}"></script>

<script src="{{ asset('app-assets/vendors/js/editors/summernote/summernote.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/editors/editor-summernote.js') }}"></script>


<!--script only for product page-->
<script type="text/javascript" src="{{ asset('app-assets/pages/product.js')}}"></script>

<!--for tooltip-->
<script src="{{ asset('app-assets/js/scripts/tooltip/tooltip.js')}}"></script>

<!--for image gallery-->
<script src="{{ asset('app-assets/lightgallery/dist/js/lightgallery.min.js')}}"></script>


<script type="text/javascript">

    //for image gallery
    $(".lightgallery").lightGallery();

   //product photo delete
   $(document).on('click','.photo-delete', function(e){
    var id = $(this).attr('data-id');
    if (!confirm('Are you sure you want to delete the photo')) {
        return false;
    }
    if ('' != id) {
        var pageurl = `{{ URL::to('prod_img_delete')}}/`+id;
        $.ajax({
            type:'get',
            url:pageurl,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
                //blockUI();
            },
            success: function (data) {
                // console.log(data.status);
                if(data.status == true ){
                    $('#photo_div_'+id).hide();
                } else {
                    alert('something wrong please you should reload the page');
                }

            },
            complete: function (data) {
                $("body").css("cursor", "default");
                //$.unblockUI();
            }
        });
    }


})

</script>

<script>
    $(function () {
        $('.prod_def_photo_upload').imageUploader({
            extensions:[".jpg",".jpeg",".png",".gif",".svg", ".pdf",".JPG",".JPEG",".PNG",".GIF",".SVG", ".PDF"],
            mimes:["image/jpeg","image/png","image/gif","image/svg+xml","application/pdf"]
        });
        $('.product_variant_photos').imageUploader({
            extensions:[".jpg",".jpeg",".png",".gif",".svg", ".pdf",".JPG",".JPEG",".PNG",".GIF",".SVG", ".PDF"],
            mimes:["image/jpeg","image/png","image/gif","image/svg+xml","application/pdf"]
        });

    });

 </script>

<script type="text/javascript" src="{{ asset('app-assets/js/select2-tabindex.js') }}"></script>

 @endpush('custom_js')
