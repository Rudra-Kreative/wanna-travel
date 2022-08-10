<div class="modal fade viewHotelModal" id="modal-lg" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title hotelName">Hotel Details</h4>
                <button type="button" class="close closeEditModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4" style="display: inline-flex;">
                            <label for="name">Name</label>
                            <p id="detail_name" style="margin-left: 10px"></p>
                        </div>
                        <div class="col-md-4" style="display: inline-flex;">
                            <label for="ownerName">Hotelier/Contact Name</label>
                            <p id="detail_ownerName" style="margin-left: 10px"></p>
                        </div>
                        <div class="col-md-4" style="display: inline-flex;">
                            <label for="detail_creatable_type">Posted By</label>
                            <p id="detail_creatable_type" style="margin-left: 10px"></p>
                        </div>
                        <div class="col-md-4" style="display: inline-flex;">
                            <label for="detail_phone">Contact: </label>
                            <p id="detail_phone" style="margin-left: 10px"></p>
                        </div>
                        <div class="col-md-4" style="display: inline-flex;">
                            <label for="detail_address">Address: </label>
                            <p id="detail_address" style="margin-left: 10px"></p>
                        </div>
                        <div class="col-md-4" style="display: inline-flex;">
                            <label for="detail_alternate_address">Address Line 2: </label>
                            <p id="detail_alternate_address" style="margin-left: 10px"></p>
                        </div>
                        

                    </div>
                    

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
