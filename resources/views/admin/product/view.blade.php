@extends('admin.layout.master')

@section('product_list','active')
@section('Product Management','open')

<!--push from page-->
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">

<link rel="stylesheet" href="{{ asset('app-assets/file_upload/image-uploader.min.css')}}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" href="{{ asset('app-assets/lightgallery/dist/css/lightgallery.min.css') }}">
<style>
    td table{width: auto !important;}
</style>

@endpush('custom_css')

@section('title') @lang('product.product_view') @endsection
@section('page-name')Product @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">Product View </li>
@endsection

<?php
    $roles = userRolePermissionArray();
    $active_tab = request('tab') ?? 1;
    $variant_id = request('variant_id') ?? null;
    $type = request('type') ?? null;

?>

@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success" >
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
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
                        <div class="tab-content mt-1">
                            <div role="tabpanel" class="tab-pane {{$active_tab == 1 ? 'active' : ''}}" id="productBasic" aria-labelledby="productBasic-tab1" aria-expanded="true">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%">Default Photo </th>
                                                    <th style="width: 20%">Default Marketing Info</th>
                                                    <th style="width: 20%">Default Logistics Info</th>
                                                    {{-- <th>Default Cost (RM)</th> --}}
                                                    <th style="width: 50%">Default Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td style="width: 10%" class="text-center img_td">
                                                    @php $img_count = 0; @endphp
                                                    @if($product->allDefaultPhotos && $product->allDefaultPhotos->count() > 0)
                                                    <div class="lightgallery" style="margin:0px  auto; text-align: center; ">
                                                        @php $img_count = $product->allDefaultPhotos->count(); @endphp
                                                        @for($i = 0; $i < $img_count; $i++ )
                                                        @php $vphoto = $product->allDefaultPhotos[$i]; @endphp
                                                        <a class="img_popup " href="{{ asset($vphoto->RELATIVE_PATH)}}" style="{{ $i>0 ? 'display: none' : ''}}" title="{{$product->DEFAULT_NAME}}"><img style="width: 140px !important; height: 140px;" data-src="{{ asset($vphoto->RELATIVE_PATH)}}" alt="{{$product->DEFAULT_NAME}}" src="{{asset($vphoto->RELATIVE_PATH)}}" class="unveil"></a>
                                                        @endfor
                                                    </div>


                                                    @endif
                                                    <span class="badge badge-pill badge-primary badge-square img_c" title="Total {{$img_count}} photos for the product">{{$img_count}}</span>
                                                </td>
                                                <td class="pinfo" style="width: 20%">
                                                    <div><strong>Name :</strong> <i>{{$product->DEFAULT_NAME}}</i> </div>

                                                    <div><strong>Category :</strong> <i>{{$product->subcategory->category->NAME ?? ''}}</i></div>
                                                    <div><strong>Subcategory :</strong> <i>{{$product->subcategory->NAME ?? ''}}</i></div>
                                                    <div><strong>Brand :</strong> <i>{{$product->BRAND_NAME ?? ''}}</i></div>
                                                    <div><strong>Model :</strong> <i>{{$product->MODEL_NAME ?? ''}}</i></div>

                                                </td>
                                                <td class="pinfo" style="width: 20%">
                                                    <div><strong>Barcode :</strong> <i>{{$product->BARCODE}}</i></div>
                                                    {{-- <div><strong>Default Shipping Method :</strong> <i>{{$product->DEFAULT_PREFERRED_SHIPPING_METHOD}}</i></div> --}}

                                                    {{-- <div><strong>Default Code :</strong> <i>{{$product->DEFAULT_CODE}}</i></div> --}}

                                                    <div><strong>SKU Prefix :</strong> <i>{{$product->COMPOSITE_CODE}}</i></div>
                                                    <div><strong>Default HS Code :</strong> <i>{{$product->DEFAULT_HS_CODE}}</i></div>
                                                    <div><strong>VAT Class :</strong> <i>{{$product->vatclass->NAME ?? ''}} </i></div>
                                                </td>
                                                {{--<td class="pinfo">
                                                <div><strong>Price :</strong> <i>{{number_format($product->DEFAULT_PRICE,2)}}</i></div>
                                                    <div><strong>Price (Ins) :</strong> <i>{{number_format($product->DEFAULT_INSTALLMENT_PRICE,2)}}</i></div>

                                                    <div><strong>AIR Freight :</strong> <i>{{number_format($product->DEFAULT_AIR_FREIGHT_CHARGE,2)}}</i></div>
                                                    <div><strong>SEA Freight :</strong> <i>{{number_format($product->DEFAULT_SEA_FREIGHT_CHARGE,2)}}</i></div>
                                                    <div><strong>Postage for SS :</strong><i>{{number_format($product->DEFAULT_LOCAL_POSTAGE,2)}}</i></div>
                                                    <div><strong>Postage for SM :</strong> <i>{{number_format($product->DEFAULT_INTERDISTRICT_POSTAGE,2)}}</i></div>


                                                </td> --}}
                                                <td style="width: 50%">
                                                   <div><?=$product->DEFAULT_NARRATION?></div>
                                                </td>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                             </div>

                            <!--##################product variant tab ##########################-->
                             <div class="tab-pane {{$active_tab == 2 ? 'active' : ''}}" id="productVariant" role="tabpanel" aria-labelledby="productVariant-tab1" aria-expanded="false">



                    <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-sm card-smart">
                                <div class="card-header">
                                    <h4 class="card-title"><span title="Product category name">{{$product->subcategory->category->NAME ?? ''}}</span>&nbsp;>&nbsp;<span title="Product subcategory name">{{$product->subcategory->NAME ?? ''}}</span>&nbsp;>&nbsp;<span title="Product brand name">{{$product->BRAND_NAME ?? ''}}</span>&nbsp;>&nbsp;<span title="Product model name">{{$product->MODEL_NAME}}</span>&nbsp;:: Variants List
                                        @if($type == 'variant')
                                        <a class="btn btn-xs btn-primary text-white" style="display: inline;" href="{{ route('admin.product.edit', [$product->PK_NO]) }}?type=variant&tab=2" ><i class="ft-plus text-white" ></i> New Variant</a>
                                        @endif
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
                                                            <th style="width: 5%">SL</th>
                                                            <th style="width: 10%">Photo </th>
                                                            <th style="width: 30%">Info</th>

                                                            <th style="width: 20%">Cost (RM)</th>
                                                            <th style="width: 35%">Description</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($product->allVariantsProduct &&  $product->allVariantsProduct->count() > 0)
                                                        @foreach($product->allVariantsProduct as $key => $row )
                                                        <tr class="{{$variant_id == $row->PK_NO ? 'active_tr' : '' }}">
                                                            <td class="text-center" style="width: 5%">{{$key+1}}</td>
                                                            <td class="text-center img_td" style="width: 10%">
                                                                @php $img_count = 0; @endphp
                                                                @if($row->allVariantPhotos && $row->allVariantPhotos->count() > 0)
                                                                <div class="lightgallery" style="margin:0px  auto; text-align: center; ">
                                                                    @php $img_count = $row->allVariantPhotos->count(); @endphp
                                                                    @for($i = 0; $i < $img_count; $i++ )
                                                                    @php $vphoto = $row->allVariantPhotos[$i]; @endphp
                                                                    <a class="img_popup " href="{{ asset($vphoto->RELATIVE_PATH)}}" style="{{ $i>0 ? 'display: none' : ''}}" title="{{$row->VARIANT_NAME}}"><img style="width: 80px !important; height: 80px;" data-src="{{ asset($vphoto->RELATIVE_PATH)}}" alt="{{$row->VARIANT_NAME}}" src="{{asset($vphoto->RELATIVE_PATH)}}" class="unveil"></a>
                                                                    @endfor
                                                                </div>


                                                                @endif
                                                                <span class="badge badge-pill badge-primary badge-square img_c" title="Total {{$img_count}} photos for the product">{{$img_count}}</span>
                                                            </td>
                                                            <td class="pinfo" style="width: 30%">
                                                                <div><strong>Name :</strong> <i>{{$row->VARIANT_NAME}}</i> </div>

                                                                <div><strong>Color :</strong> <i>{{$row->COLOR}}</i></div>
                                                                <div><strong>Size :</strong> <i>{{$row->SIZE_NAME}}</i></div>
                                                                {{--<div><strong>MKT_CODE :</strong> <i>{{$row->MKT_CODE}}</i></div> --}}
                                                                <div><strong>IG Code :</strong> <i>{{$row->MRK_ID_COMPOSITE_CODE}}</i></div>
                                                                <div><strong>Barcode :</strong> <i>{{$row->BARCODE}}</i></div>
                                                                <div><strong>Shipping Method :</strong> <i>{{$row->PREFERRED_SHIPPING_METHOD}}</i></div>

                                                                {{-- <div><strong>Code :</strong> <i>{{$row->CODE}}</i></div> --}}
                                                                <div><strong>SKU :</strong> <i>{{$row->COMPOSITE_CODE}}</i></div>
                                                                <div><strong>HS Code :</strong> <i>{{$row->HS_CODE}}</i></div>
                                                                <div><strong>VAT Class :</strong> <i>{{$row->vatclass->NAME ?? 'N/A'}}</i></div>




                                                            </td>
                                                            <td class="pinfo" style="width: 20%">

                                                                <div><strong>Price :</strong> <i>{{number_format($row->REGULAR_PRICE,2)}}</i></div>
                                                                <div><strong>Price (Ins) :</strong> <i>{{number_format($row->INSTALLMENT_PRICE,2)}}</i></div>
                                                                <div><strong>AIR Freight :</strong> <i>{{number_format($row->AIR_FREIGHT_CHARGE,2)}}</i></div>
                                                                <div><strong>SEA Freight :</strong> <i>{{number_format($row->SEA_FREIGHT_CHARGE,2)}}</i></div>
                                                                <div><strong>Postage for SS :</strong><i>{{number_format($row->LOCAL_POSTAGE,2)}}</i></div>
                                                                <div><strong>Postage for SM :</strong> <i>{{number_format($row->INTER_DISTRICT_POSTAGE,2)}}</i></div>
                                                            </td>

                                                            <td style="width: 35%">
                                                              <div>{!! $row->NARRATION !!}</div>
                                                            </td>


                                                        </tr>
                                                        @endforeach()
                                                        @else
                                                        <tr>
                                                            <td colspan="5" class="text-center">Data not found</td>

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


                            </div>
                            <!--############ product variant tab end ##################-->

                            <div class="tab-pane {{$active_tab == 3 ? 'active' : ''}}" id="linkIconOpt1" role="tabpanel" aria-labelledby="linkIconOpt1-tab1" aria-expanded="false">
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

@endsection
<!--push from page-->
@push('custom_js')
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js')}}"></script>

<!--for image upload-->
<script type="text/javascript" src="{{ asset('app-assets/file_upload/image-uploader.min.js')}}"></script>

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
        $('.prod_def_photo_upload').imageUploader();

    });

 </script>



 @endpush('custom_js')
