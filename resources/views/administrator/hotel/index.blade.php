<x-administrator-app-layout>
    <x-slot name="addOnCss">
        <style>
 .viewmoreimg {
    position: absolute;
    top: 10px;
    right: 0;
    left: 17px;
    width: 100%;    line-height: 10px;

    text-align: center;
}
.previewImg {
    width: 100%;
    height: 200px;
    object-fit: cover;
    margin-bottom: 5px;
    position: relative;
}
.viewmoreimg p {
    font-size: 11px;
    font-weight: 500;
}
.viewmoreimg  i.fas.fa-eye.fa-xs {
    font-size: 20px;
}
 .container .btn {
    position: absolute;
    top: 50%;
    left: 18%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    border: none;
    cursor: pointer;
    border-radius: 5px;
    text-align: center;
    display: block;
    color: black;
    font-size: 20px;
}

            /* .container img:hover+.btn,
            .btn:hover {
                display: inline-block;

            } */
          .previewImg {
                width: 100%;
                height: 200px;
                object-fit: cover;
                margin-bottom: 5px;
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
                    <form action="{{ route('administrator.hotel.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="hotelRegFormStepOne">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="property_type">Select Property Type</label>
                                    <select class="form-control" name="property_type" id="property_type">
                                        <option value="">Select your property type</option>
                                        @foreach ($propertyTypes as $propertyType)
                                            <option value="{{ $propertyType->id }}">{{ $propertyType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('property_type')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div> 
                                <div class="form-group hotelTypeDiv" style="display: none">
                                    <label for="hotel_type">Hotel type</label>
                                    <div class="hotelTypeDivSec">
                                        
                                    </div>

                                    @error('hotelType')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
                            {{-- <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" required id="name"
                                    placeholder="Enter  name">
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            
                            <div class="form-group">
                                <label for="name">Name <span style="font-size: 10px">**This will be your display name for hotel</span></label>
                                <input type="text" class="form-control" name="name" required id="name"
                                    placeholder="Enter hotel name">
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Star Rating</label>
                                <select name="star_rating" class="form-control" id="star_rating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                @error('star_rating')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="ownerName">Hotelier Name</label>
                                <input type="text" class="form-control" name="ownerName" required id="ownerName"
                                    placeholder="Enter hotelier name">
                                @error('ownerName')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact_no">Contact number</label>
                                <input type="text" class="form-control numbersOnly" name="contact_no" required id="contact_no"
                                    placeholder="Enter contact number">
                                @error('contact_no')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact_no">Alternate contact number (optional)</label>
                                <input type="text" class="form-control numbersOnly" name="alternate_phone" id="alternate_phone"
                                    placeholder="Enter alternate contact number">
                                @error('alternate_phone')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="street_address">Street Address</label>
                                <input type="text" class="form-control" name="street_address" required id="street_address"
                                    placeholder="Enter street address">
                                @error('street_address')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address_line">Address Line 2 (optional)</label>
                                <input type="text" class="form-control" name="address_line" id="address_line"
                                    placeholder="Enter address line 2">
                                @error('address_line')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <select class="form-control" name="country" id="country">
                                    <option value="">Select a country</option>
                                    @foreach ($countryList as $country)
                                        <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="city" required id="city"
                                    placeholder="Enter city">
                                @error('city')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="zip">Zip Code</label>
                                <input type="text" class="form-control numbersOnly" name="zip" required id="zip"
                                    placeholder="Enter zipcode">
                                @error('zip')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Select Amenities that are available </label>
                                <div class="select2-purple">
                                  <select class="select2" multiple="multiple" name="amenites[]" data-placeholder="Select amenitees available in your hotal" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                    @foreach ($amenities as $amenity)
                                        <option value="{{ $amenity->id }}" >{{ $amenity->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                                @error('amenites')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                              </div>
                            <div class="form-group">
                                <label for="avatar">Choose images for property</label>
                                <input type="file" class="form-control" name="hotel_images[]" onchange="previewHotelImages()" id="avatars" multiple>
                                @error('hotel_images')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" id="avatar_preview_sec" style="display: none">
                                <label for="avatar_preview">Preview</label>

                                <div id="avatar_preview">

                                </div>
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
        <input type="hidden" id="property_data" name="property_data" value="{{ !empty($propertyTypes) ? json_encode($propertyTypes) : '' }}"> 
    </x-slot>
   
    <x-admin.hotel-list :hotels="$hotels"/>
    <x-admin.hotel-image-gallery />
    <x-admin.hotel-details-modal />
    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/hotel.js') }}"></script>
        <script type="text/javascript">
            $('.select2').select2();
        </script>
    </x-slot>
</x-administrator-app-layout>
