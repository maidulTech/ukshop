@extends('admin.layout.master')
<!--push from page-->
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/file_upload/image-uploader.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/editors/summernote.css')}}">


<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
@endpush('custom_css')

@section('Product Management','open')
@section('product_list','active')

@section('title') @lang('product.add_new_product') @endsection

@section('page-name') @lang('product.add_new_product') @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">@lang('admin_role.breadcrumb_sub_title')    </li>
@endsection
<?php
$categories_combo = $data['category_combo'] ?? [];
$vat_class_combo = $data['vat_class_combo'] ?? [];
$brand_combo = $data['brand_combo'] ?? [];

$roles = userRolePermissionArray();
$active_tab = request('tab') ?? 1;
$variant_id = request('variant_id') ?? null;
$type = request('type') ?? null;
$method_name = request()->route()->getActionMethod();


$shipping_method_combo = [
 'AIR' => 'AIR',
 'SEA' => 'SEA'
];

?>
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <!--?php vError($errors) ?-->
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified no-border">
                            <li class="nav-item">
                                <a class="nav-link active" id="productBasic-tab1" data-toggle="tab" href="#productBasic" aria-controls="productBasic" aria-expanded="true">@lang('product.product_info')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="linkIcon1-tab1" @if($method_name == 'getEdit') data-toggle="tab" href="#linkIcon1" aria-controls="linkIcon1" aria-expanded="false" @endif >@lang('product.product_variant')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="linkIconOpt1-tab1" data-toggle="tab" href="#linkIconOpt1" aria-controls="linkIconOpt1">@lang('product.stock_info')</a>
                            </li>
                        </ul>
                        <div class="tab-content border-tab-content">
                            <div role="tabpanel" class="tab-pane active" id="productBasic" aria-labelledby="productBasic-tab1" aria-expanded="true">
                                {!! Form::open([ 'route' => 'admin.product.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                            <label>{{trans('form.category')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('category', $categories_combo, null, ['class'=>'form-control mb-1 select2', 'id' => 'category', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select category', 'tabindex' => 1, 'data-url' => URL::to('prod_subcategory') ]) !!}
                                                {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('sub_category') ? 'error' : '' !!}">
                                            <label>{{trans('form.sub_category')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('sub_category', array(), null, ['class'=>'form-control mb-1 select2', 'id' => 'sub_category', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select sub category', 'data-url' => URL::to('get_hscode_by_scat'), 'tabindex' => 2] ) !!}
                                                {!! $errors->first('sub_category', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
                                            <label>{{trans('form.brand')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('brand', $brand_combo, null, ['class'=>'form-control mb-1 select2', 'id' => 'brand','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select brand', 'tabindex' => 3, 'data-url' => URL::to('prod_model')]) !!}
                                                {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('prod_model') ? 'error' : '' !!}">
                                            <label>{{trans('form.model')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('prod_model', array(), null, ['class'=>'form-control mb-1 select2 prod_model_add', 'id' => 'prod_model','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select model', 'tabindex' => 4]) !!}
                                                {!! $errors->first('prod_model', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                            <label>{{trans('form.generic_name')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text('name', null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter product name', 'tabindex' => 5]) !!}
                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('vat_class') ? 'error' : '' !!}">
                                            <label>{{trans('form.vat_class')}}</label>
                                            <div class="controls">
                                                {!! Form::select('vat_class', $vat_class_combo, 3, ['class'=>'form-control mb-1 ', 'placeholder' => 'Select vat class', 'tabindex' => 6]) !!}
                                                {!! $errors->first('vat_class', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('hs_code') ? 'error' : '' !!}">
                                            <label>{{trans('form.default_hs_code')}}</label>
                                            <div class="controls">
                                                {!! Form::select('hs_code', array(), null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product HS code', 'tabindex' => 7, 'id' => 'hs_code']) !!}
                                                {!! $errors->first('hs_code', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <br>
                                            <div class="controls">
                                                <label><input type="checkbox" name="is_barcode_by_mfg" checked="true" tabindex="8"> <small>{{ trans('form.is_barcode_by_manufacturer') }} </small></label>
                                                {!! $errors->first('is_barcode_by_mfg', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group {!! $errors->has('def_narration') ? 'error' : '' !!}">
                                            <label>{{trans('form.default_description')}}</label>
                                            <div class="controls">

                                                {!! Form::textarea('def_narration', null, [ 'class' => 'form-control mb-1 summernote', 'placeholder' => 'Enter short description about the product', 'tabindex' => 9, 'rows' => 3 ]) !!}
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
                                                {!! Form::select('new_arrival', ['1' =>'Yes','0' => 'NO'], 1, ['class'=>'form-control mb-1','tabindex' => 10,'id'=>'new_arrival']) !!}
                                                {!! $errors->first('new_arrival', '<label class="help-block text-danger">:message</label>') !!}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active" for="is_feature">Is Feature</label>
                                                {!! Form::select('is_feature', ['1' =>'Yes','0' => 'NO'], 1, ['class'=>'form-control mb-1','tabindex' =>11,'id'=>'is_feature' ]) !!}
                                                {!! $errors->first('is_feature', '<label class="help-block text-danger">:message</label>') !!}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                    <h6 class="text-bold bold">SEO META</h6>
                                    <hr class="mt-0">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active" for="meta_title">Meta Title</label>
                                                {!! Form::text('meta_title',null, ['class'=>'form-control mb-1','tabindex' =>13, 'placeholder' => 'Meta title']) !!}
                                                {!! $errors->first('meta_title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active" for="meta_keywards">Meta Keyward</label>
                                                {!! Form::text('meta_keywards',null, ['class'=>'form-control mb-1','tabindex' =>14 , 'placeholder' => 'Meta keywords']) !!}
                                                {!! $errors->first('meta_keywards', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <label class="active">Meta description</label>
                                                {!! Form::textarea('meta_description',null, ['class'=>'form-control mb-1','tabindex' =>15 ,'rows'=>3, 'placeholder' => 'Meta description']) !!}
                                                {!! $errors->first('meta_description', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-actions text-center">
                                            <a href="{{route('admin.product.list')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                                            <button type="submit" class="btn btn-primary bg-darken-1 text-white">
                                             <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                                         </div>
                                     </div>
                                 </div>
                                 {!! Form::close() !!}
                             </div>
                             <div class="tab-pane" id="linkIcon1" role="tabpanel" aria-labelledby="linkIcon1-tab1" aria-expanded="false">
                                <p>Chocolate bar gummies sesame snaps. Liquorice cake sesame snaps cotton candy cake sweet brownie.
                                    Cotton candy candy canes brownie. Biscuit pudding sesame snaps pudding pudding sesame snaps biscuit
                                    tiramisu.
                                </p>
                            </div>
                            <div class="tab-pane" id="linkIconOpt1" role="tabpanel" aria-labelledby="linkIconOpt1-tab1" aria-expanded="false">
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
<!--/ Recent Transactions -->
</div>



@endsection

<!--push from page-->
@push('custom_js')
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript" src="{{ asset('app-assets/file_upload/image-uploader.min.js')}}"></script>


<script src="{{ asset('app-assets/vendors/js/editors/summernote/summernote.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/editors/editor-summernote.js') }}"></script>

<script type="text/javascript" src="{{ asset('app-assets/pages/product.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('app-assets/js/select2-tabindex.js') }}"></script> --}}

<script>
$('.select2').on('select2:select', function (e) {
    $(this).focus();
//     $(this).prop('tabindex', tabindex);
});
   $(function () {
        $('.prod_def_photo_upload').imageUploader();
    });
 </script>

 @endpush('custom_js')
