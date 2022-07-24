<?php

namespace App\Http\Controllers;

use App\Models\PropertyType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    public function index()
    {
        return view('administrator.hotel.property.index',[
            'propertyTypes' => $this->getAllPropertyTypes()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'slug' => ['nullable', 'unique:property_types,slug']
        ]);

        $res = [
            'key' => 'success',
            'msg' => 'Property type has been created successfully.'
        ];


        try {

            $propertyTypeData = PropertyType::create([
                'name' => $request->name,
                'slug' => !empty($request->slug) ? $request->slug : Str::slug($request->name . Str::random(5), '-'),
                'desc' => $request->desc
            ]);


            if (!$propertyTypeData->id) {
                $res = [
                    'key' => 'failed',
                    'msg' => 'Property type could not be created.'
                ];
            } else {
                $res = [
                    'key' => 'failed',
                    'msg' => 'Property type could not be created.'
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'failed',
                'msg' => 'Property type could not be created.'
            ];
        }

        return view('administrator.hotel.property.index', [
            'propertyTypes' => $this->getAllPropertyTypes(),
            'res' => $res
        ]);
    }


    public function getAllPropertyTypes()
    {
        return PropertyType::where('is_active',TRUE)->orderBy('created_at','DESC')->get();
    }
}
