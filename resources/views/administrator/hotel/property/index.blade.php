<x-administrator-app-layout>
    <x-slot name="addOnCss">

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
                    <form action="{{ route('administrator.hotel.property.store') }}" method="POST">
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
                                
                                <textarea name="desc" id="desc" cols="70" rows="5" placeholder="Enter some description of this property type" class="form-control"></textarea>
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
  
    <x-admin.property-type-listing :propertyTypes="$propertyTypes"/>

    
    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/property-type.js') }}"></script>
    </x-slot>
</x-administrator-app-layout>
