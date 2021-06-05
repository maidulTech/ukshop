@extends('admin.layout.master')
@section('Accounts','open')
@section('payment_bank','active')
@section('title')
    Create payment bank account
@endsection
@section('page-name')
    Create payment bank account
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')  </a></li>
    <li class="breadcrumb-item active">@lang('payment.breadcrumb_sub_title')    </li>
@endsection

@section('content')

<section id="basic-form-layouts">
    <div class="row match-height min-height">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-content collapse show">
                    <div class="card-body">
                        {!! Form::open([ 'route' => 'admin.payment_bank.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('bank_name') ? 'error' : '' !!}">
                                        <label>Bank Name<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('bank_name', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter bank name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1 ]) !!}
                                            {!! $errors->first('bank_name', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('bank_acc_name') ? 'error' : '' !!}">
                                        <label>Bank Account Name<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('bank_acc_name', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter bank account name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 2 ]) !!}
                                            {!! $errors->first('bank_acc_name', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group {!! $errors->has('bank_acc_no') ? 'error' : '' !!}">
                                        <label>Account Number<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::number('bank_acc_no', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter account number', 'data-validation-required-message' => 'This field is required', 'tabindex' => 3 ]) !!}
                                            {!! $errors->first('bank_acc_no', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-actions text-center mt-3">
                                        <a href="{{ route('admin.payment_bank.list') }}" title="Cancel" class="btn btn-warning mr-1"><i class="ft-x"></i>@lang('form.btn_cancle') </a>
                                        <button type="submit" class="btn btn-primary" title="Save" title="Save"><i class="la la-check-square-o"></i>@lang('form.btn_save') </button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
