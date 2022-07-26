<x-administrator-app-layout>
    <x-slot name="addOnCss">

    </x-slot>

    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Contact</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Contact</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
                {{-- <button type="button" class="btn btn-block btn-primary btn-lg mt-4" id="hotel_type_create"
                    style="width: 100px">Create</button> --}}

                <div id="is_wanna_for_me_form_div" style="display:block">
                    <form action="{{ $data['data_method'] == 'update' ? route('administrator.pages.update',[$data['templates']->slug]) : route('administrator.pages.store') }}" id="is_wanna_for_me"
                        data-slug="{{ $data['templates']->slug ?? null }}" data-action="" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="page_indentifier" id="page_indentifier" value="contact">
                        @if ($data['data_method'] == 'update')
                            @method('PUT')
                            
                        @endif
                        <div class="card-body">
                            <div class="form-group">
                                <label for="heading">Page heading</label>

                                <input type="text" class="form-control" name="heading" placeholder="Enter page heading"
                                value="{{ old('heading') ? old('heading') : (!empty($data['templates']->contents[0]->heading) ? $data['templates']->contents[0]->heading : '' ) }}">
                                @error('heading')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="map">Location map</label>

                                <input type="text" class="form-control" id="maps_url" name="maps_url" placeholder="Enter google map link"
                                
                                value="{{ old('maps_url') ? old('maps_url') : (!empty($data['templates']->contents[0]->maps_url) ? $data['templates']->contents[0]->maps_url : '' ) }}">
                                @error('map_url')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="map_preview_sec" style="display: block">
                                <label for="map_preview">Preview</label>

                                <div id="map_preview" class="col-lg-6">
                                    <iframe width="600" height="450" id="map_iframe" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="{{ $data['templates']->contents[0]->maps_url ?? null }}"></iframe>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div style="padding: .75rem 1.25rem; display: flex">
                            <button type="submit" class="btn btn-primary">{{ Str::ucfirst($data['data_method']) }}</button>
                        </div>

                    </form>
                </div>
            </div><!-- /.col -->

        </div><!-- /.row -->

        <input type="hidden" name="is_wanna_data" id="is_wanna_data"
        value="{{ !empty($data['templates']->contents) ? json_encode($data['templates']->contents) : null }}">

    </x-slot>


    <x-slot name="addOnJs">
        {{-- <script src="{{ asset('admin/dist/js/pages/is_wanna_for_me.js') }}"></script> --}}

        <script type="text/javascript">
            $(document).on('keyup','#map_url',function () { 
                $('#map_iframe').attr('src',$(this).val());
             });
        </script>
    </x-slot>
</x-administrator-app-layout>
