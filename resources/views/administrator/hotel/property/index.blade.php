<x-administrator-app-layout>
    <x-slot name="addOnCss">
        {{-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> --}}
        <style>
            .swal2-container.swal2-top-end>.swal2-popup,
            .swal2-container.swal2-top-right>.swal2-popup {
                grid-column: 3;
                align-self: start;
                justify-self: end;
                position: fixed;
                top: 10px;
                width: 22% !important;
            }

            tbody#property_type_body tr td:nth-child(3) span:not(:last-child) {
                margin-right: 4px;
            }
        </style>
    </x-slot>
    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Property Type</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Property-Type</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <button type="button" class="btn btn-block btn-primary btn-lg mt-4" id="property_type_create"
                    style="width: 100px">Create</button>

                <div id="property_type_form_div" style="{{ $errors->any() ? 'display: block' : 'display:none' }}">
                    <form action="{{ route('administrator.hotel.property.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" required id="name"
                                    placeholder="Enter property type name">
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug (optional)</label>
                                <input type="text" class="form-control" name="slug" id="slug"
                                    placeholder="Enter unique slug">
                                @error('slug')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Description</label>

                                <textarea name="desc" id="desc" cols="70" rows="5"
                                    placeholder="Enter some description of this property type" class="form-control"></textarea>
                                @error('desc')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Select hotel type under this property</label>
                                <div class="row">
                                    <div class="col-md-5">
                                        <select name="from" id="multiselect" class="form-control" size="8"
                                            multiple="multiple">

                                            @foreach ($hotelTypes as $hotelType)
                                                <option value="{{ $hotelType->id }}">{{ $hotelType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="multiselect_rightAll" class="btn btn-block"><i
                                                class="fas fa-angle-double-right"></i></button>
                                        <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i
                                                class="fas fa-angle-right"></i></button>
                                        <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i
                                                class="fas fa-angle-left"></i></button>
                                        <button type="button" id="multiselect_leftAll" class="btn btn-block"><i
                                                class="fas fa-angle-double-left"></i></button>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="hotelTypes[]" id="multiselect_to" class="form-control"
                                            size="8" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="avatar">Choose an avatar for this type (optional)</label>
                                <input type="file" class="form-control" name="avatar" id="avatar"
                                    onchange="previewImages('avatar','property_image_preview','property_image_preview_sec')"
                                    id="avatar">
                            </div>

                            <div class="form-group" id="property_image_preview_sec" style="display: none">
                                <label for="property_image_preview">Preview</label>

                                <div id="property_image_preview">

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div style="padding: .75rem 1.25rem;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </x-slot>

    <x-admin.property-type-listing :propertyTypes="$propertyTypes" />
    <x-admin.property-edit-modal :hotelTypes="$hotelTypes" />
    <input type="hidden" name="allHotelTypesData" id="allHotelTypesData"
        value="{{ $hotelTypes ? json_encode($hotelTypes) : '' }}" />
    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/property-type.js') }}"></script>
        <script src="{{ asset('admin/plugins/multiselect/multiselect.min.js') }}"></script>
    </x-slot>
</x-administrator-app-layout>
