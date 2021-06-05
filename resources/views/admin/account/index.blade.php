@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-tooltip.css')}}">
@endpush

@section('Payment Management','active')
@section('Accounts','open')

@section('title')
    @lang('payment.list_page_title')
@endsection
@section('page-name')
    @lang('payment.list_page_sub_title')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')    </a>
    </li>
    <li class="breadcrumb-item active">@lang('payment.breadcrumb_sub_title')
    </li>
@endsection
@push('custom_css')
@endpush
@push('custom_js')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
<!-- BEGIN: Data Table-->
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
@endpush

@php
    $roles = userRolePermissionArray()
@endphp
@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body min-height">
        <section id="pagination">
          <div class="row">
            <div class="col-12">
              <div class="card card-success">
                <div class="card-header">
                  <div class="form-group">
                    @if(hasAccessAbility('new_account_source', $roles))
                    <a class="text-white addsourceModal" href="javascript:void(0)" data-toggle="modal" data-target="#addEditSourceModal" title="Add Payment Source" data-url="{{ route('account.store')}}" data-type="add">
                      <button type="button" class="btn btn-sm btn-primary">
                        <i class="ft-plus text-white"></i> Add Payment Source
                      </button>
                    </a>
                    @endif
                  </div>
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
                  <div class="card-body card-dashboard text-center">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable">
                        <thead>
                          <tr>
                            <th style="width: 40px;">Sl.</th>
                            <th class="text-left" style="width: 420px;">Payment Source</th>
                            <th class="text-left" style="max-width: 420px;">Account Name</th>
                            <th class="text-left">Payment Method</th>
                            <th style="width: 200px;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                          <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="text-left">
                              <span title="Account Bank Name">{{ $row->NAME }}</span>
                            </td>
                              <td class="text-left" style="max-width: 200px;">
                                @if($row->bankAccountActive && $row->bankAccountActive->count() > 0 )
                                <ul class="list-group" style="max-width: 300px;">
                                  @foreach($row->bankAccountActive as $key => $model)
                                  @if($key < 2)
                                  <li class="list-group-item list-group-item-sm list-group-parent">
                                    <div class="float-right" style="display: inline-block; min-width: 50px;">
                                      <span class="float-right child-action">
                                        @if(hasAccessAbility('edit_account_name', $roles))
                                        <button class="btn btn-xs btn-primary mr-0 editBankModal" data-toggle="modal" data-target="#EditAccountname" title="EDIT NAME" data-url="{{ route('account.bank.update', [$model->PK_NO]) }}" data-source_id="{{$row->PK_NO}}" data-source_name="{{$row->NAME}}" data-bank_id="{{$model->PK_NO}}" data-bank_name="{{$model->NAME}}" data-type="edit"><i
                                            class="la la-edit"></i></button>
                                        @endif
                                        @if(hasAccessAbility('delete_account_name', $roles))
                                        <a href="{{route('account.name.delete', [$model->PK_NO])}}" class="btn btn-xs btn-danger" title="DELETE" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                        </a>
                                        @endif
                                      </span>
                                    </div>
                                    <span> {{$key+1}} . </span>

                                    <span title="Bank name">{{$model->NAME}}</span> &nbsp;

                                    {{-- <span title="Model code">({{$model->COMPOSITE_CODE}})</span> --}}
                                  </li>
                                  @endif
                                  @endforeach()

                                </ul>
                                @endif

                                @if($row->bankAccountActive && $row->bankAccountActive->count() > 2 )
                                <div class="card collapse-icon default-collapse  accordion-icon-rotate card-sm" style="max-width: 300px;">
                                  <a id="headingCollapse51" class="card-header border-primary primary collapsed" data-toggle="collapse" href="#collapseProdBank_{{$row->PK_NO}}" aria-expanded="false" aria-controls="collapseProdBank_{{$row->PK_NO}}" style="padding: 5px;">
                                    <div class="card-title lead primary">More Names</div>
                                  </a>
                                  <div id="collapseProdBank_{{$row->PK_NO}}" role="tabpanel" aria-labelledby="headingCollapse51" class="card-collapse collapse" aria-expanded="true" style="">
                                    <div class="card-content">
                                      <div class="card-body p-0">
                                        <ul class="list-group ">
                                          @foreach($row->bankAccountActive as $key => $model)
                                          @if($key > 1)
                                          <li class="list-group-item list-group-item-sm list-group-parent">
                                            <span class=" float-right child-action">
                                                @if(hasAccessAbility('edit_account_name', $roles))
                                                <button class="btn btn-xs btn-primary mr-0 editBankModal" data-toggle="modal" data-target="#EditAccountname" title="EDIT NAME" data-url="{{ route('account.bank.update', [$model->PK_NO]) }}" data-source_id="{{$row->PK_NO}}" data-source_name="{{$row->NAME}}" data-bank_id="{{$model->PK_NO}}" data-bank_name="{{$model->NAME}}" data-type="edit"><i
                                                    class="la la-edit"></i></button>
                                                @endif
                                                @if(hasAccessAbility('delete_account_name', $roles))
                                                <a href="{{route('account.name.delete', [$model->PK_NO])}}" class="btn btn-xs btn-danger" title="DELETE" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                                </a>
                                                @endif
                                              </span>
                                              <span> {{$key+1}} . </span>

                                              <span title="Bank name">{{$model->NAME}}</span> &nbsp;

                                             {{-- <span title="Model code">({{$model->COMPOSITE_CODE}})</span> --}}
                                            </li>
                                            @endif
                                            @endforeach()

                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                </td>
                                <td class="text-left" style="max-width: 200px;">
                                    @if($row->paymentMethodActive && $row->paymentMethodActive->count() > 0 )
                                    <ul class="list-group" style="max-width: 300px;">
                                      @foreach($row->paymentMethodActive as $key => $model)
                                      @if($key < 2)
                                      <li class="list-group-item list-group-item-sm list-group-parent">
                                        <div class="float-right" style="display: inline-block; min-width: 50px;">
                                          <span class="float-right child-action">
                                            @if(hasAccessAbility('edit_payment_method', $roles))
                                           <button class="btn btn-xs btn-primary mr-0 editMethodModal" data-toggle="modal" data-target="#addEditMethodModal" title="EDIT METHOD" data-url="{{ route('account.bank.method.update', [$model->PK_NO]) }}" data-source_id="{{$row->PK_NO}}" data-source_name="{{$row->NAME}}" data-method_id="{{$model->PK_NO}}" data-method_name="{{$model->NAME}}" data-type="edit"><i
                                            class="la la-edit"></i></button>
                                            @endif
                                            @if(hasAccessAbility('delete_payment_method', $roles))
                                            <a href="{{route('account.method.delete', [$model->PK_NO])}}" class="btn btn-xs btn-danger" title="DELETE" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                            </a>
                                            @endif
                                          </span>
                                        </div>
                                        <span> {{$key+1}} . </span>

                                        <span title="Method name">{{$model->NAME}}</span> &nbsp;

                                        {{-- <span title="Model code">({{$model->COMPOSITE_CODE}})</span> --}}
                                      </li>
                                      @endif
                                      @endforeach

                                    </ul>
                                    @endif

                                    @if($row->paymentMethodActive && $row->paymentMethodActive->count() > 2 )
                                    <div class="card collapse-icon default-collapse  accordion-icon-rotate card-sm" style="max-width: 300px;">
                                      <a id="headingCollapse51" class="card-header border-primary primary collapsed" data-toggle="collapse" href="#collapseProdMethod_{{$row->PK_NO}}" aria-expanded="false" aria-controls="collapseProdMethod_{{$row->PK_NO}}" style="padding: 5px;">
                                        <div class="card-title lead primary">More Methods</div>
                                      </a>
                                      <div id="collapseProdMethod_{{$row->PK_NO}}" role="tabpanel" aria-labelledby="headingCollapse51" class="card-collapse collapse" aria-expanded="true" style="">
                                        <div class="card-content">
                                          <div class="card-body p-0">
                                            <ul class="list-group ">
                                              @foreach($row->paymentMethodActive as $key => $model)
                                              @if($key > 1)
                                              <li class="list-group-item list-group-item-sm list-group-parent">
                                                <span class=" float-right child-action">
                                                    @if(hasAccessAbility('edit_payment_method', $roles))
                                                    <button class="btn btn-xs btn-primary mr-0 editMethodModal" data-toggle="modal" data-target="#viewMethodModal" title="EDIT MODEL" data-url="{{ route('account.bank.method.update', [$model->PK_NO]) }}" data-source_id="{{$row->PK_NO}}" data-source_name="{{$row->NAME}}" data-method_id="{{$model->PK_NO}}" data-method_name="{{$model->NAME}}" data-type="edit"><i class="la la-edit"></i></button>
                                                    @endif
                                                    @if(hasAccessAbility('delete_payment_method', $roles))
                                                    <a href="{{route('account.method.delete', [$model->PK_NO])}}" class="btn btn-xs btn-danger" title="DELETE" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                                    </a>
                                                    @endif
                                                  </span>
                                                  <span> {{$key+1}} . </span>

                                                  <span title="Model name">{{$model->NAME}}</span> &nbsp;

                                                 {{-- <span title="Model code">({{$model->COMPOSITE_CODE}})</span> --}}
                                                </li>
                                                @endif
                                                @endforeach

                                              </ul>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      @endif
                                    </td>
                                      <td style="width: 200px;">
                                        @if(hasAccessAbility('edit_account_source', $roles))
                                        <a href="javascript:void(0)" class="btn btn-xs btn-info mr-0 mb-1 editsourceModal"  data-toggle="modal" data-target="#addEditSourceModal" title="Edit Payment Source" data-url="{{ route('account.source.update', [$row->PK_NO]) }}" data-source_id="{{$row->PK_NO}}" data-source_name="{{$row->NAME}}" data-type="edit"><i class="la la-edit"></i></a>
                                        @endif
                                        @if(hasAccessAbility('delete_account_source', $roles))
                                        <a href="{{ route('account.source.delete', [$row->PK_NO]) }}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs btn-danger mr-0 mb-1" title="Delete Payment Source"><i class="la la-trash"></i>
                                        </a>
                                        @endif
                                        @if(hasAccessAbility('new_account_name', $roles))
                                        <a href="javascript:void(0)" class="btn btn-xs btn-success mr-0 mb-1 addBankModal" title="ADD ACCOUNT NAME" data-toggle="modal" data-target="#EditAccountname" data-url="{{ route('account.bank.store.single') }}" data-source_id="{{$row->PK_NO}}" data-source_name="{{$row->NAME}}" data-type="add">&nbsp;+ A&nbsp;</a>
                                        @endif
                                        @if(hasAccessAbility('new_payment_method', $roles))
                                        <a href="javascript:void(0)" class="btn btn-xs btn-warning mr-0 mb-1 addMethodModal" title="ADD METHOD" data-toggle="modal" data-target="#addEditMethodModal" data-url="{{ route('account.method.store') }}" data-source_id="{{$row->PK_NO}}" data-source_name="{{$row->NAME}}" data-type="add">&nbsp;+ P&nbsp;</a>
                                        @endif
                                      </td>
                                    </tr>
                                    @endforeach()
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


      @include('admin.account._account_edit_modal')

    <!--/ Alternative pagination table -->
@endsection
@push('custom_js')

<!--script only for brand page-->
<script type="text/javascript" src="{{ asset('app-assets/pages/account.js')}}"></script>


@endpush('custom_js')
