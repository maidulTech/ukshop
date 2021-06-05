<!--Add Color Modal html-->
<div class="modal fade text-left" id="colorAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel35"> Add New Color for <strong id="brand_name"></strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open([ 'route' => 'admin.product.color.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    @csrf

                {!! Form::hidden('brand', null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'brand_id' ]) !!}

                <div class="modal-body">
                    <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                        <label>{{trans('form.name')}}<span class="text-danger">*</span></label>
                        <div class="controls">
                            {!! Form::text('name', null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter color for the brand', 'tabindex' => 1 ]) !!}
                            {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                    <br>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
                    <input type="submit" class="btn btn-primary btn-sm" value="Save">
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
<!--End Add Color Modal html-->


<!--Add Size Modal html-->
<div class="modal fade text-left" id="sizeAddModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel36" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel36"> Add New Size for <strong id="brand_name1"></strong></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open([ 'route' => 'admin.product-size.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    @csrf

                {!! Form::hidden('brand', null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'brand_id1' ]) !!}

                <div class="modal-body">
                    <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                        <label>{{trans('form.name')}}<span class="text-danger">*</span></label>
                        <div class="controls">
                            {!! Form::text('name', null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter size for the brand', 'tabindex' => 1 ]) !!}
                            {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                    <br>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
                    <input type="submit" class="btn btn-primary btn-sm" value="Save">
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
<!--End Add Size Modal html-->
