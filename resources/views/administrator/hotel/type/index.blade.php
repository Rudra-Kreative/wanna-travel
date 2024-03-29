<x-administrator-app-layout>
    <x-slot name="addOnCss">
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
        </style>
    </x-slot>
    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Hotel Type</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hotel-Type</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <button type="button" class="btn btn-block btn-primary btn-lg mt-4" id="hotel_type_create"
                    style="width: 100px">Create</button>

                <div id="hotel_type_form_div" style="{{ $errors->any() ? 'display: block' : 'display:none' }}">
                    <form action="{{ route('administrator.hotel.type.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" required id="name"
                                    placeholder="Enter category name">
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
                                
                                <textarea name="desc" id="desc" cols="70" rows="5" placeholder="Enter some description of this type" class="form-controle"></textarea>
                                @error('desc')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
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
    <x-admin.hotel-type-listing :hotelTypes="$hotelTypes"/>
    
    <x-admin.hotel-type-edit-modal />
    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/hotel-type.js') }}"></script>
        
    </x-slot>
</x-administrator-app-layout>
