/*Add edit Account name model*/
$(document).on('click','.editBankModal, .addBankModal', function(){
    var url         = $(this).data('url');
    var source_name  = $(this).data('source_name');
    var source_id  = $(this).data('source_id');
    var bank_name  = $(this).data('bank_name');
    var bank_id  = $(this).data('bank_id');
    var type        = $(this).data('type');

    $('#bank_update_frm').attr('action',url);
    $('#bank_update_frm .source_id').val(source_id);
    $('#bank_update_frm .bank_name').val(bank_name);
    if (type == 'add'){
        $('#source_name').text('Add new Account Name  for '+source_name);+
        $('#bank_update_frm .submit-btn').val('Save');
    }
    if (type == 'edit'){
        $('#source_name').text('Edit Account Name for '+source_name);
        $('#bank_update_frm .submit-btn').val('Save change');
    }
});

/*Add edit account method*/
$(document).on('click','.editMethodModal, .addMethodModal', function(){
    var url         = $(this).data('url');
    var source_name  = $(this).data('source_name');
    var source_id  = $(this).data('source_id');
    var method_name  = $(this).data('method_name');

    var type        = $(this).data('type');

    $('#method_add_edit_frm').attr('action',url);
    $('#method_add_edit_frm .source_id').val(source_id);
    $('#method_add_edit_frm .method_name').val(method_name);

    if (type == 'add'){
        $('#addEditMethodModal #source_name').text('Add new payment method for '+source_name);
        $('#method_add_edit_frm .submit-btn').val('Save');
    }
    if (type == 'edit'){
        $('#method_add_edit_frm .submit-btn').val('Save change');
        $('#addEditMethodModal #source_name').text('Edit payment method for '+source_name);
    }
});

/*Add edit account method*/
$(document).on('click','.editsourceModal, .addsourceModal', function(){
    var url         = $(this).data('url');
    var source_name  = $(this).data('source_name');
    var source_id  = $(this).data('source_id');

    var type        = $(this).data('type');

    $('#source_add_edit_frm').attr('action',url);
    $('#source_add_edit_frm .source_id').val(source_id);
    $('#source_add_edit_frm .source_name').val(source_name);

    if (type == 'add'){
        $('#addEditSourceModal #source_name').text('Add new Payment source');
        $('#source_add_edit_frm .submit-btn').val('Save');
    }
    if (type == 'edit'){
        $('#source_add_edit_frm .submit-btn').val('Save change');
        $('#addEditSourceModal #source_name').text('Edit Payment Source for '+source_name);
    }
});

