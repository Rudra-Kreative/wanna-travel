<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\GuestEnquery;
use Illuminate\Http\Request;

class GuestEnquiryController extends Controller
{
    public function index()
    {
        $data = GuestEnquery::orderBy('id','DESC')->get();
        
        return view('administrator.guest-enquiry.index',['data'=>$data]);
    }
}
