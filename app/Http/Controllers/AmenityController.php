<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Exception;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index()
    {
        return view('administrator.hotel.amenity.index',['amenities'=>$this->getAllAmenities()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $res = [
            'key' => 'success',
            'msg' => 'Amenity has been created successfully.'
        ];

        try {
            $createdAmenity = Amenity::create(['name'=>$request->name]);

            if($createdAmenity->id)
            {
                $res = [
                    'key' => 'success',
                    'msg' => 'Amenity has been created successfully.'
                ];
            }
            else
            {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Amenity could not be created.'
                ];
            }
        } catch (Exception $e) {
            
            $res = [
                'key' => 'fail',
                'msg' => 'Amenity could not be created.'
            ];
        }

        return redirect()->route('administrator.hotel.amenity.home')->with($res['key'], $res['msg']);
    }


    public function getAllAmenities()
    {
        return Amenity::where('is_active',true)->get();
    }
}
