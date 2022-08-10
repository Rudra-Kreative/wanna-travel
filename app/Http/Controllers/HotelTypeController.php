<?php

namespace App\Http\Controllers;

use App\Helper\Media;
use App\Models\HotelType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class HotelTypeController extends Controller
{
    use Media;

    public function index()
    {
        return view('administrator.hotel.type.index',['hotelTypes'=>$this->getAllHotelTypes()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'slug' => ['nullable', 'unique:hotel_types,slug'],
            'desc' => ['required']    
            ]);

        $res = [
            'key' => 'success',
            'msg' => 'Hotel type has been created successfully.'
        ];

        try {
            $hotelTypeData = HotelType::create([
                'name' => $request->name,
                'slug' => !empty($request->slug) ? $request->slug : Str::slug($request->name . Str::random(5), '-'),
                'desc' => $request->desc

            ]);

            if (!$hotelTypeData->id) {
                $res = [
                    'key' => 'failed',
                    'msg' => 'Hotel type could not be created.'
                ];
            }
            else{
                $res = [
                    'key' => 'failed',
                    'msg' => 'Hotel type could not be created.'
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'failed',
                'msg' => 'Hotel type could not be created.'
            ];
        }


        return redirect()->route('administrator.hotel.type.home')->with($res['key'], $res['msg']);
    }

    public function edit(HotelType $hotelType)
    {
        if (!empty($hotelType->id)) {
            return [
                'data' => $hotelType,
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

    public function update(HotelType $hotelType, Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'desc' => ['required']
        ]);


        if(!empty($hotelType->id))
        {
            try {
                $hotelType->name = $request->name;
                $hotelType->desc = $request->desc;

                $isUpdated = $hotelType->save();

                if($isUpdated)
                {
                    $res = [
                        'key' => 'success',
                        'msg' => 'Hotel type has been updated successfully.'
                    ];
                }
                else
                {
                    $res = [
                        'key' => 'fail',
                        'msg' => 'Hotel type could not be updated.'
                    ];
                }
            } catch (Exception $e) {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Hotel type could not be updated.'
                ];
            }


        }
        else
        {
            $res = [
                'key' => 'fail',
                'msg' => 'Hotel type could not be updated.'
            ];
        }

           return [
            'data' => $this->getAllHotelTypes(),
            'res' => $res
        ];
    }

    public function destroy(HotelType $hotelType)
    {
        $res = [
            'key' => 'success',
            'msg' => 'Hotel type has been deleted successfully.'
        ];

        try {
            $hotelType->delete();

            if ($hotelType->trashed()) {
                $res = [
                    'key' => 'success',
                    'msg' => 'Hotel type has been deleted successfully.'
                ];
            } else {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Hotel type could not be deleted.'
                ];
            }
        } catch (Exception $e) {
            $res = [
                'key' => 'fail',
                'msg' => 'Hotel type could not be deleted.'
            ];
        }

        return [
            'data' => $this->getAllHotelTypes(),
            'res' => $res
        ];
    }
    public function getAllHotelTypes()
    {
        return HotelType::where('is_active',true)->orderBy('created_at','DESC')->get();
    }
}
