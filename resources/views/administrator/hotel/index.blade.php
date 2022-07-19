<x-administrator-app-layout>
    <x-slot name="addOnCss">
        <style>
            .row {
            display: flex;
          }
          
          /* Create three equal columns that sits next to each other */
          .column {
            flex: 33.33%;
            padding: 5px;
          }
        </style>
    </x-slot>
    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Hotels</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hotels</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <button type="button" class="btn btn-block btn-primary btn-lg mt-4" id="hotel_create"
                    style="width: 100px">Create</button>

                <div id="hotel_form_div" style="{{ $errors->any() ? 'display: block' : 'display:none' }}">
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

                            <div class="form-group">
                                <label for="avatar">Choose images for hotel (atleast one)</label>
                                <input type="file" class="form-control" name="avatars[]" onchange="previewHotelImages()" id="avatars" multiple>
                            </div>

                            <div class="form-group" id="avatar_preview_sec" style="display: none">
                                <label for="avatar_preview">Preview</label>

                                <div id="avatar_preview">

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
   

    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/hotel.js') }}"></script>
    </x-slot>
</x-administrator-app-layout>
