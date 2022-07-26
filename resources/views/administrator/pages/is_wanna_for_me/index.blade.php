<x-administrator-app-layout>
    <x-slot name="addOnCss">

    </x-slot>
    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Is Wanna For Me</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Is Wanna For Me</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
                {{-- <button type="button" class="btn btn-block btn-primary btn-lg mt-4" id="hotel_type_create"
                    style="width: 100px">Create</button> --}}

                <div id="is_wanna_for_me_form_div" style="display:block">
                    <form action="javscrip:void(0)" id="is_wanna_for_me"
                        data-slug="{{ $data['templates']->slug ?? null }}" data-action="" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="page_indentifier" id="page_indentifier" value="is_wanna_for_me">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Select a section</label>

                                <select name="section_select" id="section_select" class="form-control">
                                    <option value="" selected>Select a section</option>
                                    <option value="sec_one" >Section One</option>
                                    <option value="sec_two" >Section Two</option>
                                    <option value="sec_three" >Section Three</option>
                                    <option value="sec_four" >Section Four</option>
                                    <option value="sec_five" >Section Five</option>

                                    {{-- <optgroup label="Create ?">
                                        <option value="create">Create a new one +</option>
                                    </optgroup> --}}

                                    {{-- @if (!empty($data['templates']->contents))
                                        <optgroup label="Select question">
                                            @foreach ($data['templates']->contents as $content)
                                            @endforeach
                                        </optgroup>
                                    @endif --}}
                                </select>
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="section_detailed_div" style="display: none">

                                <div class="form-group">
                                    <label for="section_text">Section Text</label>

                                    <textarea name="section_text" required id="section_text" cols="70" rows="5" placeholder="Enter section text"
                                        class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="slug">Section Image</label>

                                    <input type="file" class="form-control" name="section_image"
                                        onchange="previewImages('section_image','section_image_preview','section_image_preview_sec')"
                                        id="section_image">
                                    @error('section_image')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group" id="section_image_preview_sec" style="display: none">
                                    <label for="section_1_preview_2">Preview</label>

                                    <div id="section_image_preview">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div style="padding: .75rem 1.25rem; display: flex">
                            <button type="button" id="sec_button" data-method="create" class="btn btn-primary" disabled>No action
                                permitted</button>

                            {{-- <div style="display: none" class="fac_active_button">
                                <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-on bootstrap-switch-focused"
                                    style="width: 86px;margin-left: 10px;margin-top: 5px;">
                                    <div class="bootstrap-switch-container" style="width: 126px; margin-left: 0px;">
                                        <span class="bootstrap-switch-handle-on bootstrap-switch-primary"
                                            style="width: 42px;">Active</span><span class="bootstrap-switch-label"
                                            style="width: 42px;">&nbsp;</span><span
                                            class="bootstrap-switch-handle-off bootstrap-switch-default"
                                            style="width: 42px;">Deactive</span><input type="checkbox"
                                            name="faq-active-checkbox" id="faq-active-checkbox" checked="" data-bootstrap-switch=""></div>
                                </div>
                            </div> --}}
                        </div>

                    </form>
                </div>
            </div><!-- /.col -->

        </div><!-- /.row -->

        <input type="hidden" name="is_wanna_data" id="is_wanna_data"
        value="{{ !empty($data['templates']->contents) ? json_encode($data['templates']->contents) : null }}">

    </x-slot>


    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/is_wanna_for_me.js') }}"></script>
    </x-slot>
</x-administrator-app-layout>
