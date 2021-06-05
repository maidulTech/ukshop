<div class="modal fade text-left" id="mark_faulty_modal" tabindex="-1" role="dialog"
    aria-labelledby="mark_faulty_modal" aria-hidden="true" style="z-index: 9999999;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="source_name">Mark Faulty Item</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cus_add_modal">
                <label><input id="faulty_sellable" name="faulty_sellable" type="checkbox" value="1"> Mark as faulty but sellable</label>
                <br>
                <br>
                <label><input id="faulty_non_sellable" name="faulty_non_sellable" type="checkbox" value="1"> Mark as faulty and lost</label>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>
<script>
    $('#checkbox1').change(function() {
        if(this.checked) {
            $('#display_none').fadeOut();
        }else{
            $('#display_none').fadeIn();
        }
    });
</script>
