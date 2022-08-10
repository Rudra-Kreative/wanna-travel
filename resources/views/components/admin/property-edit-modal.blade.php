@props(['hotelTypes'=>$hotelTypes])
<div class="modal fade editModal" id="modal-lg" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Property Type</h4>
                <button type="button" class="close closeEditModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript" data-actionURI="" id='property_edit_form' enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" required id="edit_name"
                            placeholder="Enter property type name">
                    </div>
                    {{-- <div class="form-group">
                        <label for="slug">Slug (optional)</label>
                        <input type="text" class="form-control" name="slug" id="edit_slug"
                            placeholder="Enter unique slug">
                    </div> --}}
                    <div class="form-group">
                        <label for="slug">Description</label>
                        <textarea name="desc" id="edit_desc" cols="70" rows="5"
                            placeholder="Enter some description of this property type" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="slug">Select hotel type under this property</label>
                        <div class="row">
                            <div class="col-md-5">
                              <select name="from" id="multiselect_edit" class="form-control" size="8" multiple="multiple">
                                
                                @foreach ($hotelTypes as $hotelType)
                                <option value="{{ $hotelType->id }}">{{ $hotelType->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-2">
                              <button type="button" id="multiselect_rightAll_edit" class="btn btn-block"><i class="fas fa-angle-double-right"></i></button>
                              <button type="button" id="multiselect_rightSelected_edit" class="btn btn-block"><i class="fas fa-angle-right"></i></button>
                              <button type="button" id="multiselect_leftSelected_edit" class="btn btn-block"><i class="fas fa-angle-left"></i></button>
                              <button type="button" id="multiselect_leftAll_edit" class="btn btn-block"><i class="fas fa-angle-double-left"></i></button>
                            </div>
                            <div class="col-md-5">
                              <select name="edit_hotelTypes[]" id="multiselect_to_edit" class="form-control edit_hotelTypes" size="8" multiple="multiple">
                              </select>
                            </div>
                          </div>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Choose an avatar for this type (optional)</label>
                        <input type="file" class="form-control" name="avatar" id="edit_avatar"
                            onchange="previewImages('edit_avatar','edit_property_image_preview','edit_property_image_preview_sec')"
                            id="avatar">
                    </div>
                    <div class="form-group" id="edit_property_image_preview_sec" style="display: none">
                        <label for="edit_property_image_preview">Preview</label>
    
                        <div id="edit_property_image_preview">
    
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default closeEditModal" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary updateProperty">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
