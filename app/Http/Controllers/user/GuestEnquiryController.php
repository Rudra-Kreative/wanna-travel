<?php

namespace App\Http\Controllers\user;

use App\Events\user\GuestEnquired;
use App\Http\Controllers\Controller;
use App\Models\GuestEnquery;
use Exception;
use Illuminate\Http\Request;

class GuestEnquiryController extends Controller
{
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'subject'=>'required',
            'enquery'=>'required'
        ]);

        $res = [
            'key' => 'success',
            'msg' => 'Your query has successfully been submitted!!'
        ];
        try {
            $createdEnquery = GuestEnquery::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'subject' => $request->subject,
                'query' => $request->enquery,
            ]);

            if(!empty($createdEnquery->id))
            {
                
                $res = [
                    'key' => 'success',
                    'msg' => 'Your query has successfully been submitted!!'
                ];

                $payload = [
                    'name' => $request->fname . ' ' . $request->lname,
                    'subject' => $request->subject,
                    'fromEmail' => $request->email,
                    'enquiry' => $request->enquery
                ];
                
                event(new GuestEnquired($payload));
            }
            else
            {
                $res = [
                    'key' => 'fail',
                    'msg' => 'Something went wrong. Please try again later'
                ];
            }
        } catch (Exception $e) {
            dd($e);
            $res = [
                'key' => 'fail',
                'msg' => 'Something went wrong. Please try again later'
            ];
        }

        return $res;
    }
}
