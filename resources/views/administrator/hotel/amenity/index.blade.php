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
                <h1 class="m-0">Amenity</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Amenity</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <button type="button" class="btn btn-block btn-primary btn-lg mt-4" id="amenity_create"
                    style="width: 100px">Create</button>

                <div id="amenity_form_div" style="{{ $errors->any() ? 'display: block' : 'display:none' }}">
                    <form action="{{ route('administrator.hotel.amenity.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Amenity</label>
                                <input type="text" class="form-control" name="name" required id="name"
                                    placeholder="Enter amenity name">
                                @error('name')
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
     <x-admin.amenity-list :amenities="$amenities"/>
    
   {{--   <x-admin.hotel-type-edit-modal /> --}}
    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/amenity.js') }}"></script>
        
    </x-slot>
</x-administrator-app-layout>
