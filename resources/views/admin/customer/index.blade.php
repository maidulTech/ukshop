@extends('admin.layout.master')

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-tooltip.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@section('Customer Management','open')
@section('customer_list','active')

@section('title') @lang('customer.list_page_title') @endsection

@section('page-name') @lang('customer.list_page_sub_title') @endsection

@push('custom_js')
    <!-- BEGIN: Data Table-->
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
    <!-- END: Data Table-->
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">@lang('customer.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('customer.breadcrumb_sub_title')</li>
@endsection

@php
    $roles = userRolePermissionArray();
@endphp


@push('custom_css')

    <style>
        #scrollable-dropdown-menu .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
        #scrollable-dropdown-menu2 .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
        .twitter-typeahead{display: block !important;}
        #warehouse th, #availble_qty th {border: none;border-bottom: 1px solid #333;font-size: 12px;font-weight: normal;padding-bottom: 7px;    padding-bottom: 11px;}
        #book_qty th { border: none;font-size: 12px;font-weight: normal;padding-bottom: 5px;padding-top: 0;}
        .tt-hint {color: #999 !important;}
    </style>

@endpush('custom_css')

@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm card-success">
                        <div class="card-header">

                            @if(hasAccessAbility('new_customer', $roles))
                            <a class="btn btn-sm btn-primary" href="{{route('admin.customer.create')}}" title="ADD NEW PRODUCT CUSTOMER"><i class="ft-plus text-white"></i> @lang('customer.customer_create_btn')</a>
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
                                    <table class="table table-striped table-bordered table-sm" id="process_data_table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">@lang('tablehead.sl')</th>
                                            <th>@lang('tablehead.tbl_head_name')</th>
                                            <th>Customer No</th>
                                            <th>@lang('tablehead.tbl_head_email')</th>
                                            <th>@lang('tablehead.tbl_head_phn_no')</th>
                                            <th title="Sum of only unverified payments">Unverified(RM)</th>
                                            <th title="All payments">All Payments(RM)</th>
                                            <th>@lang('tablehead.customer_due')(RM)</th>
                                            <th title="Customer actual credit balance (only verified)">Credit(RM)</th>
                                            <th style="width: 15%" class="text-center">@lang('tablehead.action')</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal animated zoomIn text-left balanceTrans" tabindex="-1" role="dialog" aria-labelledby="balanceTrans" aria-hidden="true" id="balanceTrans">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-content">
                {!! Form::open([ 'route' => 'admin.customer.blance_transfer', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate','id' => 'balanceTransFrm']) !!}
                <input type="hidden" name="from_customer" value="" id="from_customer" />
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel23"><i class="la la-tree"></i> Balance Transfer from <span id="customer_name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
              <div class="modal-body">

                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('payment_no') ? 'error' : '' !!}">
                            <label>Customer Balance</label>
                            <div class="controls">
                                {!! Form::select('payment_no', [], null, ['class'=>'form-control mb-1 ', 'data-validation-required-message' => 'This field is required', 'id' => 'payment_no']) !!}
                                {!! $errors->first('payment_no', '<label class="help-block text-danger">:message</label>') !!}

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="form-group {!! $errors->has('to_customer') ? 'error' : '' !!}">
                            <label>To</label>
                            <div class="controls" id="scrollable-dropdown-menu2">
                                <input type="search" name="q" id="to_customer" class="form-control search_to_customer" placeholder="Enter Customer Name" autocomplete="off" required>
                                <input type="hidden" name="to_customer_hidden" id="to_customer_hidden" >
                                {!! $errors->first('to_customer', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('amount_to_trans') ? 'error' : '' !!}">
                            <label>Amount to be transfer</label>
                            <div class="controls">


                                {!! Form::number('amount_to_trans', null, ['class'=>'form-control mb-1 ', 'data-validation-required-message' => 'This field is required', 'id' => 'amount_to_trans', 'step' => '0.01']) !!}

                                {!! $errors->first('amount_to_trans', '<label class="help-block text-danger">:message</label>') !!}

                            </div>
                        </div>
                    </div>




              </div>
              <div class="modal-footer">
                <button type="button" class="btn grey btn-secondary" data-dismiss="modal" title="Close"><i class="ft-x"></i> Close</button>
                <button type="submit" class="btn btn-primary" title="Save"><i class="la la-save"></i> Save changes</button>
            </div>
            {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>


@endsection

@push('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var get_url = $('#base_url').val();

jQuery(document).ready(function($) {
    typeahead('customer');
})

$('#scrollable-dropdown-menu2 .search_to_customer').bind('typeahead:select', function(ev, suggestion) {
        $('#to_customer_hidden').val(suggestion.pk_no1);

});

function typeahead(type) {
    var get_url = $('#base_url').val();
    var engine = new Bloodhound({
        remote: {
            url: get_url+'/get-customer-info?q=%QUERY%&type='+type,
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $(".search_to_customer").typeahead({
        hint: true,
        highlight: true,
        minLength: 1,

    }, {
        source: engine.ttAdapter(),
        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        display: 'NAME',
        limit: 20,
        // the key from the array we want to display (name,id,email,etc...)
        templates: {
            // empty: [
            //     // '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
            // ],
            empty: function(context){
                $(".tt-dataset").html('<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>');
            },
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
                if (type == 'customer') {
                        return '<span class="list-group-item" style="cursor: pointer;" data-id="'+data.pk_no1+'" >' + data.NAME +'- Mobile : '+ data.MOBILE_NO +'- ID : '+ data.CUSTOMER_NO +'</span>';

                }else{
                    return '<span class="list-group-item" style="cursor: pointer;" data-id="'+data.pk_no1+'" >' + data.NAME +'- Mobile : '+ data.MOBILE_NO +'- ID : '+ data.RESELLER_NO +'</span>';
                }
            },
            updater: function (data) {
            //print the id to developer tool's console
            console.log(data);
            }
        }
    });
}

$(document).on('click', '.balanceTransBtn', function(e){
    var id = $(this).data('id');
    var pageurl = get_url+'/get/'+id+'/remainingcustomerbalance';
    $.ajax({
        type:'get',
        url:pageurl,
        async :true,
        beforeSend: function () {
            $("body").css("cursor", "progress");
        },
        success: function (data) {
            console.log(data);
            if(data != '' ){
                $('#payment_no').html(data);
            } else {
                $('#payment_no').html("<option value=''>data not found</option>");
            }
        },
        complete: function (data) {
            $("body").css("cursor", "default");

        }
    });

    var name = $(this).data('name');
    var payment_no = $(this).data('payment_no');
    $('#customer_name').text(name);
    // $('#payment_no').val(payment_no);
    $('#from_customer').val(id);
    $('#to_customer').val('');
//    $('#amount_to_trans').attr('max', payment_no);

})
    $(document).ready(function() {
        var value = getCookie('customer_list');

        if (value !== null ) {
            var value = (value-1)*10;
            // table.fnPageChange(value,true);
        }else{
            var value = 0;
        }
        var table = callDatatable(value);

    });
    function callDatatable(value) {
        var table =
        $('#process_data_table').dataTable({
            processing: false,
            serverSide: true,
            paging: true,
            pageLength: 25,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            iDisplayStart: value,
            ajax: {
                url: 'customer/all_customer',
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {
                    data: 'PK_NO',
                    name: 'PK_NO',
                    searchable: false,
                    sortable:false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {
                    data: 'NAME',
                    name: 'c.NAME',
                    searchable: true
                },
                {
                    data: 'CUSTOMER_NO',
                    name: 'c.CUSTOMER_NO',
                    searchable: true,
                    className: 'text-center'
                },
                {
                    data: 'EMAIL',
                    name: 'c.EMAIL',
                    searchable: true,
                    render: function(data, type, row) {
                        if (row.EMAIL == null) {
                            return '----------------------------';
                        } else {
                            return row.EMAIL;
                        }
                    }
                },
                {
                    data: 'mobile',
                    name: 'c.MOBILE_NO',
                    searchable: true,
                },
                /*{
                    data: 'reseller',
                    name: 'r.NAME',
                    searchable: true,
                    render: function(data, type, row) {
                        if (row.reseller == null) {
                            return 'AZURAMART';
                        } else {
                            return row.reseller;
                        }
                    }
                },*/
                {
                    data: 'total_unverified',
                    name: 'total_unverified',
                    searchable: false,
                    className: 'text-right',
                },
                {
                    data: 'balance',
                    name: 'balance',
                    searchable: false,
                    className: 'text-right',
                },

                {
                    data: 'due',
                    name: 'due',
                    searchable: true,
                    className: 'text-right'

                },
                {
                    data: 'credit',
                    name: 'c.CUM_BALANCE',
                    searchable: true,
                    className: 'text-right'

                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false
                },
                // {
                //     data: 'PK_NO',
                //     id: 'PK_NO',
                //     searchable: false,
                //     render: function(data, type, row) {
                //         // return "<a href='javascript:void(0)'data-toggle='modal' data-target='#sms_send' onclick='sms_pop_up(\"" + row.id + "\",\"" + row.id + "\")' class='btn-hover-shine btn-shadow btn btn-alternate btn-sm'>Send sms</a>|<a href='guest-update/" + row.id + "' class='btn-hover-shine btn-shadow btn btn-warning btn-sm' target='_blank'>Detils</a>";
                //         var alert = "Are you sure you want to delete the customer ?";
                //         return "<a href='customer/" + row.id + "'/edit' class='btn btn-xs btn-success mr-1' title='EDIT'><i class='la la-edit'></i></a><a href='customer/" + row.id + "'/view' class='btn btn-xs btn-primary mr-1' title='VIEW'><i class='la la-eye'></i></a><a href='customer/" + row.id + "'/delete' class='btn btn-xs btn-danger mr-1' onclick='return confirm("+ '"' +"Are you sure you want to delete the customer ?"+ '"' +")' title='DELETE'><i class='la la-trash'></i></a>";

                //     }
                // },
            ]
        });
        return table;
    }
</script>

<script>
    $(document).on('click','.page-link', function(){
        var pageNum = $(this).text();
        setCookie('customer_list',pageNum);
    });

    function setCookie(customer_list,pageNum) {
        var today = new Date();
        var name = customer_list;
        var elementValue = pageNum;
        var expiry = new Date(today.getTime() + 30 * 24 * 3600 * 1000); // plus 30 days

        document.cookie = name + "=" + elementValue + "; path=/; expires=" + expiry.toGMTString();
    }
    function getCookie(name) {
        var re = new RegExp(name + "=([^;]+)");
        var value = re.exec(document.cookie);
        return (value != null) ? unescape(value[1]) : null;
    }
</script>
@endpush
