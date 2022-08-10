<div class="modal fade editModal" id="modal-lg" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Hotel Type</h4>
                <button type="button" class="close closeEditModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript" data-actionURI="" id='hotel_type_edit_form' enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" required id="edit_name"
                            placeholder="Enter property type name">
                    </div>
                    <div class="form-group">
                        <label for="slug">Description</label>
                        <textarea name="desc" id="edit_desc" cols="70" rows="5"
                            placeholder="Enter some description of this hotel type" class="form-control"></textarea>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default closeEditModal" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary updateHotelType">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
