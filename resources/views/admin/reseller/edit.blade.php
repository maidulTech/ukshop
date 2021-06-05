@extends('admin.layout.master')

@section('Customer Management','open')
@section('reseller_list','active')

@section('title') Reseller | Update @endsection
@section('page-name') Update Reseller @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Update Reseller</li>
@endsection

<!--push from page-->
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
    <style>
        #scrollable-dropdown-menu2 .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
        .twitter-typeahead{display: block !important;}
        .tt-hint {color: #999 !important;}
    </style>
@endpush('custom_css')

@section('content')
    <div class="card card-success min-height">
        <div class="card-header">
            <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i> Update
            Reseller</h4>
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
            <div class="card-body">
                {!! Form::open([ 'route' => ['admin.reseller.update',$reseller->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('agent') ? 'error' : '' !!}">
                                    <label>{{trans('form.agent')}}<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('agent', $data['agent_combo'], $reseller->agent->PK_NO, ['class'=>'form-control mb-1 select2', 'id' => 'agent', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select agent', 'tabindex' => 1]) !!}
                                        {!! $errors->first('agent', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                    <label>@lang('reseller.name')<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('name', $reseller->NAME,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter name', 'tabindex' => 2 ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
                                    <label>@lang('reseller.email')<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('email', $reseller->EMAIL,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter email', 'tabindex' => 3 ]) !!}
                                        {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('alt_phone') ? 'error' : '' !!}">
                                    <label>@lang('reseller.alt_phone')</label>
                                    <div class="controls">
                                        {!! Form::text('alt_phone', $reseller->ALTERNATE_NO,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter alternate phone number', 'tabindex' => 4 ]) !!}
                                        {!! $errors->first('alt_phone', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('fb_id') ? 'error' : '' !!}">
                                    <label>@lang('reseller.fb_id')</label>
                                    <div class="controls">
                                        {!! Form::text('fb_id', $reseller->FB_ID,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter facebook id', 'tabindex' => 5 ]) !!}
                                        {!! $errors->first('fb_id', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('ig_id') ? 'error' : '' !!}">
                                    <label>@lang('reseller.ig_id')</label>
                                    <div class="controls">
                                        {!! Form::text('ig_id', $reseller->IG_ID,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter instagram id', 'tabindex' => 6 ]) !!}
                                        {!! $errors->first('ig_id', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('uk_id') ? 'error' : '' !!}">
                                    <label>@lang('reseller.uk_id')</label>
                                    <div class="controls">
                                        {!! Form::text('uk_id', $reseller->UKSHOP_ID,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter ukshop id', 'tabindex' => 7 ]) !!}
                                        {!! $errors->first('uk_id', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('uk_pass') ? 'error' : '' !!}">
                                    <label>@lang('reseller.uk_pass')<span class="text-danger">*</span> <small class="">(Leave it blank if you do not want to change the password)</small></label>
                                    <div class="controls">
                                        {!! Form::password('uk_pass', [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter ukshop password', 'tabindex' => 8 ]) !!}
                                        {!! $errors->first('uk_pass', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('discount') ? 'error' : '' !!}">
                                    <label>@lang('reseller.discount')</label>
                                    <div class="controls">
                                        {!! Form::text('discount', $reseller->DISCOUNT_PERCENTAGE,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter discount', 'tabindex' => 9 ]) !!}
                                        {!! $errors->first('discount', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <?php
                            $fetched_country = isset($reseller->F_COUNTRY_NO) ? $reseller->F_COUNTRY_NO : 2;
                            ?>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('country') ? 'error' : '' !!}">
                                    <label>{{trans('reseller.country')}}</label>
                                    <div class="controls">
                                        <select name="country" id="country" class="form-control mb-1 select2" tabindex="10">
                                            @foreach ($data['country'] as $item)
                                                <option value="{{ $item->PK_NO }}" data-dial_code="{{ $item->DIAL_CODE }}" {{ $item->PK_NO == $fetched_country ? "selected='selected'" : '' }}>{{ $item->NAME }} ({{ $item->DIAL_CODE }})</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('country', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>{{trans('reseller.phone')}}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="phonecode2">+60</span>
                                    </div>
                                    {!! Form::text('phone',$reseller->MOBILE_NO ?? null,[ 'class' => 'form-control', 'placeholder' => 'Enter mobile no.', 'id' => 'mobilenoadd', 'tabindex' => 11]) !!}
                                    {!! $errors->first('phone', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('post_code') ? 'error' : '' !!}">
                                    <label>{{trans('reseller.postcode')}}</label>
                                    <div class="controls" id="scrollable-dropdown-menu2">
                                        <input type="search" name="post_code" id="post_code_" class="form-control search-input4" placeholder="Post code" autocomplete="off" value="{{ $reseller->POST_CODE ?? '' }}" required tabindex="12">

                                        {!! $errors->first('post_code', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                    <div id="post_code_appended_div">
                                        {!! Form::hidden('postcode', $reseller->POST_CODE, ['id'=>'post_code_hidden']) !!}
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
                                    <label>{{trans('reseller.city')}}</label>
                                    <div class="controls">
                                    {!! Form::select('city', $data['city'] ?? array(), $reseller->CITY ?? null, ['class'=>'form-control mb-1 select2', 'data-validation-required-message' => 'Select City', 'id' => 'city','tabindex' =>
                                    13,  isset($reseller->CITY) ? '' : 'placeholder' =>'Select city' ]) !!}
                                        {!! $errors->first('city', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            {{-- STATE 1 --}}
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('state') ? 'error' : '' !!}">
                                    <label>{{trans('reseller.state')}}</label>
                                    <div class="controls">
                                        {!! Form::select('state', $data['state'] ?? array(), $reseller->STATE ?? null, ['class'=>'form-control mb-1 select2','data-validation-required-message' => 'Select State', isset($reseller->CITY) ? '' : 'placeholder' => 'Select state', 'id' => 'state','tabindex' => 14 ]) !!}
                                        {!! $errors->first('state', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('address1') ? 'error' : '' !!}">
                                    <label>@lang('reseller.address1')</label>
                                    <div class="controls">
                                        {!! Form::text('address1', $reseller->ADDRESS_LINE_1,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter address 1', 'tabindex' => 15 ]) !!}
                                        {!! $errors->first('address1', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('address2') ? 'error' : '' !!}">
                                    <label>@lang('reseller.address2')</label>
                                    <div class="controls">
                                        {!! Form::text('address2', $reseller->ADDRESS_LINE_2,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter address 2', 'tabindex' => 16 ]) !!}
                                        {!! $errors->first('address2', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('address3') ? 'error' : '' !!}">
                                    <label>@lang('reseller.address3')</label>
                                    <div class="controls">
                                        {!! Form::text('address3', $reseller->ADDRESS_LINE_3,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter address 3', 'tabindex' => 17 ]) !!}
                                        {!! $errors->first('address3', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('address4') ? 'error' : '' !!}">
                                    <label>@lang('reseller.address4')</label>
                                    <div class="controls">
                                        {!! Form::text('address4', $reseller->ADDRESS_LINE_4,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter address 4', 'tabindex' => 18 ]) !!}
                                        {!! $errors->first('address4', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-actions mt-10 text-center">
                        <a href="{{ route('admin.reseller.list')}}" class="btn btn-warning mr-1" title="Cancel"> <i class="ft-x"></i> Cancel </a>
                        <button type="submit" class="btn btn-primary"> <i class="la la-check-square-o"></i> Update </button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

<!--push from page-->
@push('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('app-assets/pages/country.js') }}"></script>
 <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
 <script src="{{ asset('app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
@endpush('custom_js')
