<?php

namespace App\Http\Controllers;

use App\Helper\Media;
use App\Models\Amenity;
use App\Models\HotelType;
use App\Models\PropertyType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    use Media;

    public function index()
    {
        return view('administrator.hotel.property.index', [
            'propertyTypes' => $this->getAllPropertyTypes(),
            'hotelTypes' => (new HotelTypeController)->getAllHotelTypes()
        ]);
    }

    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name' => ['required'],
            'slug' => ['nullable', 'unique:property_types,slug'],
            'desc' => ['required'],
            'hotelTypes'=>['required','array'],
            'avatar' => ['required', 'mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp', 'max:50048']
        ]);

        $res = [
            'key' => 'success',
            'msg' => 'Property type has been created successfully.'
        ];


        try {

            if ($request->hasFile('avatar') && ($request->file('avatar') instanceof UploadedFile)) {
                $fileData = $this->uploads($request->file('avatar'), 'hotels/property/types/');
            }
            
            $propertyTypeData = PropertyType::create([
                'name' => $request->name,
                'slug' => !empty($request->slug) ? $request->slug : Str::slug($request->name . Str::random(5), '-'),
                'desc' => $request->desc,
                'hotel_type' => is_array($request->hotelTypes) ? implode(',',$request->hotelTypes) : '',
                'avatar' => $fileData['filePath'] ?? null
            ]);

            
            if (!empty($propertyTypeData->id)) {
                $res = [
                    'key' => 'success',
                    'msg' => 'Property type has been created successfully.'
                ];
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Property type could not be created.'
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'fail',
                'msg' => 'Property type could not be created.'
            ];
        }



        return redirect()->route('administrator.hotel.property.home')->with($res['key'], $res['msg']);
    }

    public function edit(PropertyType $propertyType)
    {
        if (!empty($propertyType->id)) {
            $propertyType->hotel_type = HotelType::whereIn('id',explode(',',$propertyType->hotel_type))->get();

            return [
                'data' => [
                    'propertyType' => $propertyType,
                    'allHotelType' => (new HotelTypeController)->getAllHotelTypes()
                ],

                'res' => [
                    'key' => 'success',
                    'msg' => 'Successfully fetched'
                ]
            ];
        } else {
            return [
                'data' => '',
                'res' => [
                    'key' => 'success',
                    'msg' => 'Not found'
                ]
            ];
        }
    }

    public function update(PropertyType $propertyType, Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            //'slug' => ['nullable', 'unique:property_types,slug,'.$propertyType->id.''],
            'desc' => ['required'],
            'hotelTypes'=>['required'],
            'avatar' => ['nullable', 'mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp', 'max:50048']
        ]);

        $res = [
            'key' => 'success',
            'msg' => 'Property type has been updated successfully.'
        ];

        try {

            if ($request->hasFile('avatar') && ($request->file('avatar') instanceof UploadedFile)) {
                $fileData = $this->uploads($request->file('avatar'), 'hotels/property/types/');

                if (Storage::exists('public/' . substr($propertyType->avatar, strpos($propertyType->avatar, '/') + 1))) {
                    Storage::delete('public/' . substr($propertyType->avatar, strpos($propertyType->avatar, '/') + 1));
                }
            }

            $propertyType->name = $request->name;
            //$propertyType->slug = $request->slug ?? $propertyType->slug;
            $propertyType->desc = $request->desc;
            $propertyType->hotel_type = $request->hotelTypes;
            $propertyType->avatar = $fileData['filePath'] ?? $propertyType->avatar;
            $isPropertyUpdated = $propertyType->save();

            if ($isPropertyUpdated) {
                $res = [
                    'key' => 'success',
                    'msg' => 'Property type has been updated successfully.'
                ];
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Property type could not be updated'
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'fail',
                'msg' => 'Property type could not be updated'
            ];
        }

        return [
            'data' => $this->getAllPropertyTypes(),
            'res' => $res
        ];
    }

    public function destroy(PropertyType $propertyType)
    {
        $res = [
            'key' => 'success',
            'msg' => 'Property type has been deleted successfully.'
        ];

        try {
            $propertyType->delete();

            if ($propertyType->trashed()) {
                $res = [
                    'key' => 'success',
                    'msg' => 'Property type has been deleted successfully.'
                ];
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Property type could not be deleted.'
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'fail',
                'msg' => 'Property type could not be deleted.'
            ];
        }

        return [
            'data' => $this->getAllPropertyTypes(),
            'res' => $res
        ];
    }
    public function getAllPropertyTypes()
    {
        $allPropertyTypes = PropertyType::where('is_active', TRUE)->orderBy('created_at', 'DESC')->get();
       
        $allPropertyTypes->filter(
            function($k){
                $k->hotel_type = HotelType::whereIn('id',explode(',',$k->hotel_type))->get();
            });
         return $allPropertyTypes;
    }
}
