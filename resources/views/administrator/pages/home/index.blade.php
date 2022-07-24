<x-administrator-app-layout>
    <x-slot name="addOnCss">

        <style>
            .previewImg {
                width: 100%;
                height: 200px;
                object-fit: cover;
                margin-bottom: 5px;
            }

            .container .btn {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                background-color: rgb(245, 102, 102);
                color: white;
                font-size: 16px;
                padding: 12px 24px;
                border: none;
                cursor: pointer;
                border-radius: 5px;
                text-align: center;
                display: none;
            }

            .container img:hover+.btn,
            .btn:hover {
                display: inline-block;

            }
        </style>
    </x-slot>
    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Home</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Home</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">


                <div id="property_type_form_div">
                    <form
                        action="{{ $data['data_method'] == 'update' ? route('administrator.pages.update',[$data['templates']->slug]) : route('administrator.pages.store') }}"
                        method="POST" enctype="multipart/form-data">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <input type="hidden" name="data_method" value="{{ $data['data_method'] ?? 'create' }}">
                        <input type="hidden" name="page_indentifier" value="home">
                        @if ($data['data_method'] == 'update')
                            @method('PUT')
                            
                        @endif
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="banner" style="text-decoration: underline">Banner Section</label>
                            </div>

                            <div class="form-group">
                                <label for="name">Banner Heading</label>
                                <input type="text" class="form-control" name="banner_section_heading" required
                                    id="banner_section_heading" placeholder="Enter banner heading"
                                    value="{{ old('banner_section_heading') ?? (!empty($data['templates']->contents->banner_section_heading) ? $data['templates']->contents->banner_section_heading : '') }}">
                                @error('banner_section_heading')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Banner Text</label>
                                <input type="text" class="form-control" name="banner_section_text"
                                    id="banner_section_text" placeholder="Enter banner text"
                                    value="{{ old('banner_section_heading') ?? (!empty($data['templates']->contents->banner_section_text) ? $data['templates']->contents->banner_section_text : '') }}">
                                @error('banner_section_text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($data['data_method'] == 'create')
                                <div class="form-group">
                                    <label for="slug">Banner Images (can select multiple)</label>

                                    <input type="file" class="form-control" name="banner_media[]"
                                        onchange="previewImages('banner_media','banner_preview','banner_preview_sec')"
                                        id="banner_media" multiple>
                                    @error('banner_media')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                            
                            <div class="form-group" id="banner_preview_sec"
                                style="display: {{ $data['data_method'] == 'update' ? 'block' : 'none' }}">
                                <label
                                    for="banner_preview">{{ $data['data_method'] == 'update' ? 'Add or Remove multiple banner images' : 'none' }}</label>

                                <div id="banner_preview">
                                    @if (!empty($data['templates']->contents->banner_media))
                                        <div class="container">
                                            <div class='row'>
                                                    @if (!empty($data['data_method']) && $data['data_method'] == 'update')
                                                        
                                                        @php
                                                            $selectedBannerMediaArr = [];
                                                        @endphp

                                                    @endif
                                                    @foreach ($data['templates']->contents->banner_media as $banner_media)
                                                        @php
                                                            $selectedBannerMediaArr[] = $banner_media[0]->fileName;
                                                        @endphp
                                                        <div class='col-md-4 previewImgDiv'>
                                                            <img src="{{ $banner_media[0]->filePath ? URL('/' . $banner_media[0]->filePath) : '' }}"
                                                                class="rounded previewImg" alt="">
                                                            <button data-name="{{ $banner_media[0]->fileName }}" class="btn banner_image_remove_btn" type="button" title="Remove Image">Remove</button>
                                                        </div>
                                                    @endforeach
                                                @if ($data['data_method'] == 'update')
                                                    
                                                        <div class="col-md-4 text-center banner_add_icon_div" style="padding-top:10%">
                                                            <input type="file" name="updated_banner_images[]"
                                                                id="updated_banner_images"
                                                                onchange="previewUpdatedImages('updated_banner_images','banner_preview','banner_preview_sec')"
                                                                style="display: none" multiple>
                                                            <i class='fas fa-plus updated_banner_image_icon'
                                                                style='font-size:48px;color:rgb(118, 223, 136);cursor: pointer;'
                                                                title="Add Image"></i>
                                                        </div>

                                                        @error('updated_banner_images')
                                                            <span style="color: red">{{ $message }}</span>
                                                        @enderror
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                           @if ($data['data_method'] == 'update')
                           <input type="hidden" name="selected_banner_image" id="selected_banner_image" value="{{ json_encode($selectedBannerMediaArr) }}">
                           @endif

                            <div class="form-group">
                                <label for="banner" style="text-decoration: underline">Section One</label>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Heading</label>
                                <input type="text" class="form-control" name="section_1_heading" required
                                    id="section_1_heading" placeholder="Enter section heading"
                                    value="{{ old('section_1_heading') ?? (!empty($data['templates']->contents->section_1_heading) ? $data['templates']->contents->section_1_heading : '') }}">
                                @error('section_1_heading')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Section Text</label>
                                <textarea name="section_1_text" id="section_1_text" cols="70" rows="5" placeholder="Enter section text"
                                    class="form-control">{!! old('section_1_text')??(!empty($data['templates']->contents->section_1_text) ? $data['templates']->contents->section_1_text : '') !!}</textarea>
                                @error('section_1_text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Section Image One</label>

                                <input type="file" class="form-control" name="section_1_image_1"
                                    onchange="previewImages('section_1_image_1','section_1_preview_1','section_1_preview_sec_1')"
                                    id="section_1_image_1">
                                @error('section_1_image_1')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="section_1_preview_sec_1"
                                style="display: {{ $data['data_method'] == 'update' ? 'block' : 'none' }}">
                                <label for="section_1_preview_1">Preview</label>

                                <div id="section_1_preview_1">
                                    @if (!empty($data['templates']->contents->section_1_image_1))
                                        <div class='col-md-4'>
                                            <img src="{{ $data['templates']->contents->section_1_image_1[0]->filePath ? URL('/' . $data['templates']->contents->section_1_image_1[0]->filePath) : '' }}"
                                                class="rounded previewImg" alt="">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slug">Section Image Two</label>

                                <input type="file" class="form-control" name="section_1_image_2"
                                    onchange="previewImages('section_1_image_2','section_1_preview_2','section_1_preview_sec_2')"
                                    id="section_1_image_2">
                                @error('section_1_image_2')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="section_1_preview_sec_2"
                                style="display: {{ $data['data_method'] == 'update' ? 'block' : 'none' }}">
                                <label for="section_1_preview_2">Preview</label>

                                <div id="section_1_preview_2">
                                    @if (!empty($data['templates']->contents->section_1_image_2))
                                        <div class='col-md-4'>
                                            <img src="{{ $data['templates']->contents->section_1_image_2[0]->filePath ? URL('/' . $data['templates']->contents->section_1_image_2[0]->filePath) : '' }}"
                                                class="rounded previewImg" alt="">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Button Text</label>
                                <input type="text" class="form-control" name="section_1_button_text" required
                                    id="section_1_button_text" placeholder="Enter section's button text"
                                    value="{{ old('section_1_button_text') ?? (!empty($data['templates']->contents->section_1_button_text) ? $data['templates']->contents->section_1_button_text : '') }}">
                                @error('section_1_button__text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Section Button Link</label>
                                <input type="text" class="form-control" name="section_1_button_link" required
                                    id="section_1_button_link" placeholder="Enter section's button text"
                                    value="{{ old('section_1_button_link') ?? (!empty($data['templates']->contents->section_1_button_link) ? $data['templates']->contents->section_1_button_link : '') }}">
                                @error('section_1_button_link')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label for="banner" style="text-decoration: underline">Section Two</label>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Heading</label>
                                <input type="text" class="form-control" name="section_2_heading" required
                                    id="section_2_heading" placeholder="Enter section heading"
                                    value="{{ old('section_2_heading') ?? (!empty($data['templates']->contents->section_2_heading) ? $data['templates']->contents->section_2_heading : '') }}">
                                @error('section_2_heading')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Section Text</label>
                                <textarea name="section_2_text" id="section_2_text" cols="70" rows="5" placeholder="Enter section text"
                                    class="form-control">{!! old('section_2_text') ??(!empty($data['templates']->contents->section_2_text) ? $data['templates']->contents->section_2_text : '') !!}</textarea>
                                @error('section_2_text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Section Image</label>

                                <input type="file" class="form-control" name="section_2_image"
                                    onchange="previewImages('section_2_image','section_2_preview','section_2_preview_sec')"
                                    id="section_2_image">
                                @error('section_2_image')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="section_2_preview_sec"
                                style="display: {{ $data['data_method'] == 'update' ? 'block' : 'none' }}">
                                <label for="section_2_preview">Preview</label>

                                <div id="section_2_preview">
                                    @if (!empty($data['templates']->contents->section_2_image))
                                        <div class='col-md-4'>
                                            <img src="{{ $data['templates']->contents->section_2_image[0]->filePath ? URL('/' . $data['templates']->contents->section_2_image[0]->filePath) : '' }}"
                                                class="rounded previewImg" alt="">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Button Text</label>
                                <input type="text" class="form-control" name="section_2_button_text" required
                                    id="section_2_button_text" placeholder="Enter section's button text"
                                    value="{{ old('section_2_button_text') ?? (!empty($data['templates']->contents->section_2_button_text) ? $data['templates']->contents->section_2_button_text : '') }}">
                                @error('section_2_button__text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Section Button Link</label>
                                <input type="text" class="form-control" name="section_2_button_link" required
                                    id="section_2_button_link" placeholder="Enter section's button text"
                                    value="{{ old('section_2_button_link') ?? (!empty($data['templates']->contents->section_2_button_link) ? $data['templates']->contents->section_2_button_link : '') }}">
                                @error('section_2_button_link')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="banner" style="text-decoration: underline">Section Three</label>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Heading</label>
                                <input type="text" class="form-control" name="section_3_heading" required
                                    id="section_3_heading" placeholder="Enter section heading"
                                    value="{{ old('section_3_heading') ?? (!empty($data['templates']->contents->section_3_heading) ? $data['templates']->contents->section_3_heading : '') }}">
                                @error('section_3_heading')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Section Text</label>
                                <textarea name="section_3_text" id="section_2_text" cols="70" rows="5" placeholder="Enter section text"
                                    class="form-control">{!! old('section_3_text') ??(!empty($data['templates']->contents->section_3_text) ? $data['templates']->contents->section_3_text : '') !!}</textarea>
                                
                                @error('section_3_text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Section Image</label>

                                <input type="file" class="form-control" name="section_3_image"
                                    onchange="previewImages('section_3_image','section_3_preview','section_3_preview_sec')"
                                    id="section_3_image">
                                @error('section_3_image')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="section_3_preview_sec"
                                style="display: {{ $data['data_method'] == 'update' ? 'block' : 'none' }}">
                                <label for="section_3_preview">Preview</label>

                                <div id="section_3_preview">
                                    @if (!empty($data['templates']->contents->section_3_image))
                                        <div class='col-md-4'>
                                            <img src="{{ $data['templates']->contents->section_3_image[0]->filePath ? URL('/' . $data['templates']->contents->section_3_image[0]->filePath) : '' }}"
                                                class="rounded previewImg" alt="">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Button Text</label>
                                <input type="text" class="form-control" name="section_3_button_text" required
                                    id="section_3_button_text" placeholder="Enter section's button text"
                                    value="{{ old('section_3_button_text') ?? (!empty($data['templates']->contents->section_3_button_text) ? $data['templates']->contents->section_3_button_text : '') }}">
                                @error('section_3_button__text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Section Button Link</label>
                                <input type="text" class="form-control" name="section_3_button_link" required
                                    id="section_3_button_link" placeholder="Enter section's button text"
                                    value="{{ old('section_3_button_link') ?? (!empty($data['templates']->contents->section_3_button_link) ? $data['templates']->contents->section_3_button_link : '') }}">
                                @error('section_3_button_link')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="banner" style="text-decoration: underline">Section Four</label>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Heading</label>
                                <input type="text" class="form-control" name="section_4_heading" required
                                    id="section_4_heading" placeholder="Enter section heading"
                                    value="{{ old('section_4_heading') ?? (!empty($data['templates']->contents->section_4_heading) ? $data['templates']->contents->section_4_heading : '') }}">
                                @error('section_4_heading')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Section Text</label>
                                <textarea name="section_4_text" id="section_4_text" cols="70" rows="5" placeholder="Enter section text"
                                    class="form-control">
                                    {!! old('section_4_text') ??
                                        (!empty($data['templates']->contents->section_4_text) ? $data['templates']->contents->section_4_text : '') !!}
                                </textarea>
                                @error('section_4_text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Section Image</label>

                                <input type="file" class="form-control" name="section_4_image"
                                    onchange="previewImages('section_4_image','section_4_preview','section_4_preview_sec')"
                                    id="section_4_image">
                                @error('section_4_image')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="section_4_preview_sec"
                                style="display: {{ $data['data_method'] == 'update' ? 'block' : 'none' }}">
                                <label for="section_4_preview">Preview</label>

                                <div id="section_4_preview">
                                    @if (!empty($data['templates']->contents->section_4_image))
                                        <div class='col-md-4'>
                                            <img src="{{ $data['templates']->contents->section_4_image[0]->filePath ? URL('/' . $data['templates']->contents->section_4_image[0]->filePath) : '' }}"
                                                class="rounded previewImg" alt="">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Button Text</label>
                                <input type="text" class="form-control" name="section_4_button_text" required
                                    id="section_4_button_text" placeholder="Enter section's button text"
                                    value="{{ old('section_4_button_text') ?? (!empty($data['templates']->contents->section_4_button_text) ? $data['templates']->contents->section_4_button_text : '') }}">
                                @error('section_4_button__text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Section Button Link</label>
                                <input type="text" class="form-control" name="section_4_button_link" required
                                    id="section_4_button_link" placeholder="Enter section's button link"
                                    value="{{ old('section_4_button_link') ?? (!empty($data['templates']->contents->section_4_button_link) ? $data['templates']->contents->section_4_button_link : '') }}">
                                @error('section_4_button_link')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                           
                            <div class="form-group">
                                <label>Section Four Destinations</label>
                                <div class="select2-purple">
                                  <select class="select2" multiple="multiple" name="destination_country[]" data-placeholder="Select upto Four Country" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                    @foreach ($data['countryList'] as $eachData)
                                        <option value="{{ $eachData['code'] }}"
                                        {{ !empty($data['templates']->contents->destination_country) ? (in_array($eachData['code'], $data['templates']->contents->destination_country) ? 'selected' : '') : '' }}
                                        >{{ $eachData['name'] }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            

                            <div class="form-group">
                                <label for="slug">Section Destination Images (can select upto four in assending
                                    order)</label>

                                <input type="file" class="form-control limitMultiple" data-limit='4'
                                    name="section_4_destination_image[]"
                                    onchange="previewImages('section_4_destination_image','section_4_destination_preview','section_4_destination_preview_sec')"
                                    id="section_4_destination_image" multiple>
                                @error('desc')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group " id="section_4_destination_preview_sec"
                                style="display: {{ $data['data_method'] == 'update' ? 'block' : 'none' }}">
                                <label for="section_4_destination_preview">Preview</label>

                                <div id="section_4_destination_preview">
                                    @if (!empty($data['templates']->contents->section_4_destination_image))
                                        <div class='row'>

                                            @foreach ($data['templates']->contents->section_4_destination_image as $section_4_destination_image)
                                                <div class='col-md-4'>
                                                    <img src="{{ $section_4_destination_image[0]->filePath ? URL('/' . $section_4_destination_image[0]->filePath) : '' }}"
                                                        class="rounded previewImg" alt="">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="banner" style="text-decoration: underline">Section Five</label>
                            </div>

                            <div class="form-group">
                                <label for="name">Section Heading</label>
                                <input type="text" class="form-control" name="section_5_heading" required
                                    id="section_5_heading" placeholder="Enter section heading"
                                    value="{{ old('section_5_heading') ?? (!empty($data['templates']->contents->section_5_heading) ? $data['templates']->contents->section_5_heading : '') }}">
                                @error('section_5_heading')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Section Text</label>
                                <textarea name="section_5_text" id="section_5_text" cols="70" rows="5" placeholder="Enter section text"
                                    class="form-control">
                                    {{ old('section_5_text') ?? (!empty($data['templates']->contents->section_5_text) ? $data['templates']->contents->section_5_text : '') }}
                                </textarea>
                                @error('section_5_text')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Section Image</label>

                                <input type="file" class="form-control" name="section_5_image"
                                    onchange="previewImages('section_5_image','section_5_preview','section_5_preview_sec')"
                                    id="section_5_image">
                                @error('section_5_image')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="section_5_preview_sec"
                                style="display: {{ $data['data_method'] == 'update' ? 'block' : 'none' }}">
                                <label for="section_5_preview">Preview</label>

                                <div id="section_5_preview">
                                    @if (!empty($data['templates']->contents->section_5_image))
                                        <div class='col-md-4'>
                                            <img src="{{ $data['templates']->contents->section_5_image[0]->filePath ? URL('/' . $data['templates']->contents->section_5_image[0]->filePath) : '' }}"
                                                class="rounded previewImg" alt="">
                                        </div>
                                    @endif
                                </div>
                            </div>



                        </div>

                        <!-- /.card-body -->

                        <div style="padding: .75rem 1.25rem;">
                            <button type="submit" class="btn btn-primary">
                                {{ Str::ucfirst($data['data_method']) ?? 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.col -->

        </div><!-- /.row -->
    </x-slot>




    <x-slot name="addOnJs">
        @if (!empty($data['data_method']) && $data['data_method'] == 'create')
            <script src="{{ asset('admin/dist/js/pages/page-home.js') }}"></script>
        @elseif (!empty($data['data_method']) && $data['data_method'] == 'update')
            <script src="{{ asset('admin/dist/js/pages/page-home-update.js') }}"></script>
        @endif
        <script type="text/javascript">
            $('.select2').select2();
        </script>
    </x-slot>
</x-administrator-app-layout>
