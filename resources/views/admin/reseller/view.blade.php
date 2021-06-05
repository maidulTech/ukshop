@extends('admin.layout.master')


@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/file_upload/image-uploader.min.css')}}">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-tooltip.css')}}">
    <link rel="stylesheet" href="{{ asset('app-assets/lightgallery/dist/css/lightgallery.min.css') }}">
@endpush('custom_css')

@section('dashboard','active')

@section('title') Reseller | View @endsection

@section('page-name') Reseller | View @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active"> Reseller view    </li>
@endsection

<?php
    $roles = userRolePermissionArray();
    $active_tab = request('tab') ?? 1;
    $variant_id = request('variant_id') ?? null;
    $type = request('type') ?? null;
    $balance = 0;
    $html = array();
    $balance     = 0;

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
                                <a class="nav-link {{$active_tab == 1 ? 'active' : ''}}" id="productBasic-tab1" data-toggle="tab" href="#productBasic" aria-controls="productBasic" aria-expanded="true">Reseller Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{$active_tab == 2 ? 'active' : ''}}" id="productVariant-tab1" data-toggle="tab" href="#productVariant" aria-controls="linkIcon1" aria-expanded="false">Customers</a>
                            </li>
                            <li class="nav-item {{$active_tab == 3 ? 'active' : ''}}">
                                <a class="nav-link" id="linkIconOpt1-tab1" data-toggle="tab" href="#linkIconOpt1" aria-controls="linkIconOpt1">Reseller History</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-1">
                            <div role="tabpanel" class="tab-pane {{$active_tab == 1 ? 'active' : ''}}" id="productBasic" aria-labelledby="productBasic-tab1" aria-expanded="true">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Name </th>
                                                    <th>Phone</th>
                                                    <th>
                                                        {{ $reseller->F_RESELLER_NO == 0 ? 'Customer Under' : 'Reseller' }}
                                                    </th>
                                                    <th>Details</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td>1.</td>
                                                <td width="150px;" class="pinfo">
                                                   <div><strong>{{ $reseller->NAME }}</strong></div>
                                                </td>
                                                <td class="pinfo">
                                                    <div><strong>Phone:&nbsp;</strong><i>{{ $reseller->DIAL_CODE }} {{ $reseller->MOBILE_NO }}</i></div>
                                                    <div><strong>Alternative Phone:&nbsp;</strong><i>{{ $reseller->ALTERNATE_NO }}</i></div>
                                                </td>
                                                <td class="pinfo">
                                                    <div><strong>{{ $reseller->F_RESELLER_NO == 0 ? "AZURAMART" : $reseller->reseller->NAME }}</strong></div>
                                                </td>
                                                <td>
                                                   <div><strong>Email:&nbsp;</strong>{{ $reseller->EMAIL }}</div>
                                                   <div><strong>Facebook ID:&nbsp;</strong>{{ $reseller->FB_ID }}</div>
                                                   <div><strong>Instagram ID:&nbsp;</strong>{{ $reseller->IG_ID }}</div>
                                                   <div><strong>Customer No. :&nbsp;</strong>{{ $reseller->CUSTOMER_NO }}</div>
                                                </td>
                                                <td style="width: 120px;">

                                                    <div class="wrap-td-action">
                                                        @if(hasAccessAbility('edit_reseller', $roles))
                                                        <a href="{{ route('admin.reseller.edit',$reseller->PK_NO) }}" class="btn btn-xs btn-primary" title="EDIT"><i class="la la-edit"></i></a>
                                                        @endif

                                                        @if(hasAccessAbility('delete_reseller', $roles))
                                                        <a href="{{ route('admin.reseller.delete', [$reseller->PK_NO]) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete the reseller ?')" title="DELETE"><i class="la la-trash"></i></a>
                                                        @endif
                                                    </div>

                                                </td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                             </div>

                            <!--##################product variant tab ##########################-->
                             <div class="tab-pane {{$active_tab == 2 ? 'active' : ''}}" id="productVariant" role="tabpanel" aria-labelledby="productVariant-tab1" aria-expanded="false">
                                @if(hasAccessAbility('new_customer_address', $roles))
                                <a class="btn btn-sm btn-primary text-white mb-1" href="{{route('admin.customer-address.create',$reseller->PK_NO)}}" title="ADD NEW ADDRESS"><i class="ft-plus text-white"></i> @lang('customer.customer_address_btn')</a>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Customer No</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Address Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($address) && count($address) > 0 )
                                                @foreach($address as $row)
                                                <tr>
                                                <td style="width:2%">{{$loop->index + 1}}</td>
                                                <td style="width:2%">{{$reseller->CUSTOMER_NO }}</td>
                                                <td width="25%;" class="pinfo">
                                                   <div><strong>{{ $row->NAME }}</strong></div>
                                                   <br>
                                                   <div><i class="ft-phone-call"></i> {{ $row->DIAL_CODE }} {{ $row->TEL_NO }}</div>
                                                </td>
                                                <td>
                                                   <div>{{ $row->ADDRESS_LINE_1 }}</div>
                                                   <div>{{ $row->ADDRESS_LINE_2 }}</div>
                                                   <div>{{ $row->ADDRESS_LINE_3 }}</div>
                                                   <div>{{ $row->ADDRESS_LINE_4 }}</div>
                                                   <div>{{ $row->city->CITY_NAME ?? '' }} {{ $row->POST_CODE ?? '' }}</div>
                                                   <div>{{ $row->state->STATE_NAME ?? '' }}, {{ $row->country->NAME ?? '' }}</div>
                                                </td>
                                                <td>
                                                    <div>{{ $row->addressType->NAME ?? '' }}
                                                    </div>
                                                </td>
                                                <td style="width: 120px;">
                                                    <div class="wrap-td-action">
                                                        @if(hasAccessAbility('edit_customer_address', $roles))
                                                        <a href="{{ route('admin.customer-address.edit',$row->PK_NO) }}" class="btn btn-xs btn-primary" title="EDIT"><i class="la la-edit"></i></a>
                                                        @endif
                                                        @if(hasAccessAbility('delete_customer_address', $roles))
                                                        <a href="{{ route('admin.customer-address.delete',$row->PK_NO) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete?')" title="DELETE"><i class="la la-trash"></i></a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach()
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--############ product variant tab end ##################-->
                            <div class="tab-pane {{$active_tab == 3 ? 'active' : ''}}" id="linkIconOpt1" role="tabpanel" aria-labelledby="linkIconOpt1-tab1" aria-expanded="false">

                                <div class="content-body">
                                    <section id="pagination">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-sm">
                                                    <div class="card-header">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="pull-right customer-info">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                {{-- <div class="btn-group" role="group">
                                                                    <button type="button" class="btn btn-sm btn-danger">Add Payment</button>
                                                                    <button type="button" class="btn btn-sm btn-info">Add Order</button>
                                                                    <button type="button" class="btn btn-sm btn-success">Export</button>
                                                                </div> --}}
                                                                <p class="pull-right" style="color:blue;">

                                                                    <button type="button" class="btn btn-sm btn-success "><i class="la la-eye"></i></button>
                                                                    Credit Amount (RM) : {{  number_format($reseller->CUM_BALANCE,2) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                    <div class="card-content collapse show">
                                                        <div class="card-body card-dashboard">
                                                            <div class="table-responsive ">
                                                                <table class="table table-striped table-bordered table-sm" >
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center" style="width: 40px;">SL</th>
                                                                        <th class="text-center" style="width: 120px;">Date</th>
                                                                        <th class="text-center" style="width: 120px;">Created By</th>
                                                                        <th class="text-center" >Transaction</th>
                                                                        <th class="text-center" style="width: 120px;">Amount</th>
                                                                        <th class="text-center" style="width: 120px;">Balance</th>
                                                                        <th class="text-center" style="width: 120px;">Status</th>
                                                                        <th class="text-center" style="width: 120px;">Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

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
