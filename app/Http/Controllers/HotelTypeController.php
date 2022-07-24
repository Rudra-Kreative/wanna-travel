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
            'desc' => ['required'],
            'avatar' => ['nullable', 'mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp', 'max:50048']
        ]);


        if ($request->hasFile('avatar') && ($request->file('avatar') instanceof UploadedFile)) {
            $fileData = $this->uploads($request->file('avatar'), 'hotels/types/');
        }

        $res = [
            'key' => 'success',
            'msg' => 'Hotel type has been created successfully.'
        ];

        try {
            $hotelTypeData = HotelType::create([
                'name' => $request->name,
                'slug' => !empty($request->slug) ? $request->slug : Str::slug($request->name . Str::random(5), '-'),
                'desc' => $request->desc,
                'avatar' => $fileData['filePath'] ?? null

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


        return view(
            'administrator.hotel.type.index',
            [
                'hotelTypes' => $this->getAllHotelTypes(),
                'res' => $res
            ]
        );
    }

    public function getAllHotelTypes()
    {
        return HotelType::where('is_active',true)->orderBy('created_at','DESC')->get();
    }
}
