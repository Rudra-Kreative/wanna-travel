<?php

namespace App\Http\Controllers;

use App\Helper\Country;
use App\Helper\Media;
use App\Models\Administrator;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\HotelImages;
use App\Models\HotelType;
use App\Models\PropertyType;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    use Country, Media;
    public function index()
    {
        $propertyTypes = (new PropertyTypeController)->getAllPropertyTypes();
        $countryList = $this->getCountryList();
        $amenities = (new AmenityController)->getAllAmenities();
        return view('administrator.hotel.index', [
            'hotels' => $this->getAllHotels(),
            'propertyTypes' => $propertyTypes,
            'countryList' => $countryList, 'amenities' => $amenities
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'property_type' => 'required',
            'hotel_type' => 'required | array',
            'name' => 'required',
            'star_rating' => 'required',
            'ownerName' => 'required',
            'contact_no' => 'required | max: 10',
            'street_address' => 'required',
            'address_line' => 'nullable',
            'country' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'amenites' => 'required | array',
            'hotel_images.*' => ['required', 'mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp', 'max:50048']
        ]);

        try {

            $currentUser = [];

            if (auth()->guard('administrator')->check()) {

                $currentUser = Administrator::find(auth()->id());
            } else {

                $currentUser = User::find(auth()->id());
            }

            if (!empty($currentUser)) {
                $hotel = new Hotel();
                $hotel->name = $request->name;
                $hotel->slug = Str::slug($request->name . Str::random(5), '-');
                $hotel->contact_name = $request->ownerName;
                $hotel->property_type_id = $request->property_type;
                $hotel->hotel_type_id = is_array($request->hotel_type) ? implode(',', $request->hotel_type) : '';
                $hotel->amenity_id = is_array($request->amenites) ? implode(',', $request->amenites) : '';
                $hotel->star_rating = $request->star_rating;
                $hotel->phone = $request->contact_no;
                $hotel->alternate_phone = $request->alternate_phone ?? null;
                $hotel->address = $request->street_address;
                $hotel->alternate_address = $request->address_line ?? null;
                $hotel->country = $request->country;
                $hotel->city = $request->city;
                $hotel->zip = $request->zip;

                $createdHotel = $currentUser->hotels()->save($hotel);

                if (!empty($createdHotel->id)) {
                    foreach ($request->hotel_images as $hotelImage) {

                        if (!empty($hotelImage) && $hotelImage instanceof UploadedFile) {
                            $fileData = $this->uploads($hotelImage, 'hotels/images/'.$createdHotel->id.'_'.strtolower(str_replace(' ','_',$request->name)).'/');

                            $creatableHotelImages = HotelImages::create([
                                'hotel_id' => $createdHotel->id,
                                'image' => $fileData['filePath'] ?? ''
                            ]);
                        }
                    }

                    $res = [
                        'key' => 'success',
                        'msg' => 'Hotel has been published successfully.'
                    ];
                } else {
                    $res = [
                        'key' => 'fail',
                        'msg' => 'Hotel could not be published.'
                    ];
                }
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Hotel could not be published.'
                ];
            }
        } catch (Exception $e) {
            
            $res = [
                'key' => 'fail',
                'msg' => 'Hotel could not be published.'
            ];
        }

        return redirect()->route('administrator.hotel.home')->with($res['key'],$res['msg']);
    }


    public function getAllHotels()
    {
        $hotels = Hotel::with(['hotelImages','creatable','propertyType'])->where('is_active',true)->get();
        $hotels->filter(
            function($k){
                $k->hotel_type = HotelType::whereIn('id',explode(',',$k->hotel_type_id))->get();
                $k->amenity = Amenity::whereIn('id',explode(',',$k->amenity_id))->get();
            });
       return $hotels;
    }

    public function getHotelImages(Hotel $hotel)
    {
        $hotelImages = $hotel->hotelImages()
                        // ->where('hotelImages',function(Builder $query){
                        //     return $query->where('is_active',1);
                        // })
                        ->get();
        if(!empty($hotelImages))
        {
            return [
                'data' => $hotelImages,
                'res' => [
                    'key' => 'success',
                    'message' => 'Fetched successfully..'
                ]
            ];
        }
        else
        {
            return [
                'data' => '',
                'res' => [
                    'key' => 'fail',
                    'message' => 'Not found'
                ]
            ];
        }
    }

    public function getThisHotel(Hotel $hotel)
    {
        $thisHotel = $hotel->with(['hotelImages','creatable'])->find($hotel->id);
       return [
        'data' => $thisHotel,
        'res' => [
            'key' => !empty($thisHotel->id) ? 'success' : 'fail',
            'msg' => !empty($thisHotel->id) ? 'Fetched successfully..' : 'Not found..'
        ]
       ];
    }
}
