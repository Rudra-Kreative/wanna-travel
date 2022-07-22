<?php

namespace App\Http\Controllers;

use App\Helper\Country;
use App\Helper\Media;
use App\Models\Page;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class PageController extends Controller
{
    use Country, Media;

    public function index(Request $request)
    {
        $this->validate($request, [
            'name' => ['required']
        ]);

        if (!empty($request->name)) {

            $requestedView = $this->getView($request->name);
            //dd($requestedView);
            if (!empty($requestedView)) {
                return view($requestedView['view'], ['data' => $requestedView['data']]);
            } else {
                throw new ModelNotFoundException();
            }
        }
    }

    public function store(Request $request)
    {

        if (!empty($request->page_indentifier)) {
            switch ($request->page_indentifier) {
                case 'home':

                    $requestedView = $this->handleHomePage($request);

                    if (!empty($requestedView)) {
                        return view($requestedView['view'], ['data' => $requestedView['data']]);
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;
                case 'faq':

                    $requestedView = $this->createFAQ($request);
                    if (!empty($requestedView)) {
                        return  ['data' => $requestedView['data']];
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
    }


    public function update(Request $request, Page $page)
    {
        if (!empty($request->page_indentifier)) {
            switch ($request->page_indentifier) {
                case 'home':
                    $requestedView = $this->handleHomePage($request, $page);

                    if (!empty($requestedView)) {
                        return view($requestedView['view'], ['data' => $requestedView['data']]);
                    } else {
                        throw new ModelNotFoundException();
                    }
                    //return $this->handleHomePage($request,$page);
                    break;
                case 'faq':
                    $requestedView = $this->updateFAQ($request,$page);
                    if (!empty($requestedView)) {
                        return  ['data' => $requestedView['data']];
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
    }


    private function handleHomePage($request, $page = null)
    {

        if ((!empty($request->data_method))) {

            switch ($request->data_method) {
                case 'create':
                    return $this->createHomePage($request);
                    break;
                case 'update':
                    return $this->updateHomePage($request, $page);
                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    private function createHomePage($request)
    {
        $this->validate($request, [
            'banner_section_heading' => 'required',
            'banner_section_text' => 'required',
            'section_1_heading' => 'required',
            'section_1_text' => 'required',
            'section_1_button_text' => 'required',
            'section_1_button_link' => 'required | url',
            'section_2_heading' => 'required',
            'section_2_text' => 'required',
            'section_2_button_text' => 'required',
            'section_2_button_link' => 'required | url',
            'section_3_heading' => 'required',
            'section_3_text' => 'required',
            'section_3_button_text' => 'required',
            'section_3_button_link' => 'required | url',
            'section_4_heading' => 'required',
            'section_4_text' => 'required',
            'section_4_button_text' => 'required',
            'section_4_button_link' => 'required | url',
            'destination_country' => 'required | max:4',
            'section_5_heading' => 'required',
            'section_5_text' => 'required',
            'section_1_image_1' => 'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_1_image_2' => 'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_2_image' => 'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_3_image' => 'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_4_image' => 'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_4_destination_image.*' => 'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'banner_media.*' => 'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048'
        ]);

        //store banner media
        $bannerMedia = [];
        foreach ($request->banner_media as $val) {

            $bannerMedia[] = $this->uploadMedia($val, 'pages/home/banner_media/');
        }

        //store section_1_image_1
        $section_1_image_1 = $this->uploadMedia($request->section_1_image_1, 'pages/home/section_1_image_1/');
        //store section_1_image_2
        $section_1_image_2 = $this->uploadMedia($request->section_1_image_2, 'pages/home/section_1_image_2/');
        //store section_2_image
        $section_2_image = $this->uploadMedia($request->section_2_image, 'pages/home/section_2_image/');
        //store section_3_image
        $section_3_image = $this->uploadMedia($request->section_3_image, 'pages/home/section_3_image/');
        //store section_4_image
        $section_4_image = $this->uploadMedia($request->section_4_image, 'pages/home/section_4_image/');

        //store banner media
        $section_4_destination_image = [];
        foreach ($request->section_4_destination_image as $val) {

            $section_4_destination_image[] = $this->uploadMedia($val, 'pages/home/section_4_destination_image/');
        }

        //store section_5_image
        $section_5_image = $this->uploadMedia($request->section_5_image, 'pages/home/section_5_image/');


        $temlateArray = [
            'banner_section_heading' => $request->banner_section_heading,
            'banner_section_text' => $request->banner_section_text,
            'banner_media' => $bannerMedia,
            'section_1_heading' => $request->section_1_heading,
            'section_1_text' => $request->section_1_text,
            'section_1_image_1' => $section_1_image_1,
            'section_1_image_2' => $section_1_image_2,
            'section_1_button_text' => $request->section_1_button_text,
            'section_1_button_link' => $request->section_1_button_link,
            'section_2_heading' => $request->section_2_heading,
            'section_2_text' => $request->section_2_text,
            'section_2_image' => $section_2_image,
            'section_2_button_text' => $request->section_2_button_text,
            'section_2_button_link' => $request->section_2_button_link,
            'section_3_heading' => $request->section_3_heading,
            'section_3_text' => $request->section_3_text,
            'section_3_image' => $section_3_image,
            'section_3_button_text' => $request->section_3_button_text,
            'section_3_button_link' => $request->section_3_button_link,
            'section_4_heading' => $request->section_4_heading,
            'section_4_text' => $request->section_4_text,
            'section_4_image' => $section_4_image,
            'section_4_button_text' => $request->section_4_button_text,
            'section_4_button_link' => $request->section_4_button_link,
            'destination_country' => $request->destination_country,
            'section_4_destination_image' => $section_4_destination_image,
            'section_5_heading' => $request->section_5_heading,
            'section_5_text' => $request->section_5_text,
            'section_5_image' => $section_5_image
        ];

        try {
            $createdContent = Page::create([
                'name' => $request->page_indentifier,
                'contents' => json_encode($temlateArray)
            ]);

            if (!empty($createdContent->id)) {

                return $this->getView($request->page_indentifier);
                
            } else {
            }
        } catch (Exception $e) {
            dd($e);
        }


    }


    private function updateHomePage($request, $page)
    {

        $this->validate($request, [
            'banner_section_heading' => 'required',
            'banner_section_text' => 'required',
            'section_1_heading' => 'required',
            'section_1_text' => 'required',
            'section_1_button_text' => 'required',
            'section_1_button_link' => 'required | url',
            'section_2_heading' => 'required',
            'section_2_text' => 'required',
            'section_2_button_text' => 'required',
            'section_2_button_link' => 'required | url',
            'section_3_heading' => 'required',
            'section_3_text' => 'required',
            'section_3_button_text' => 'required',
            'section_3_button_link' => 'required | url',
            'section_4_heading' => 'required',
            'section_4_text' => 'required',
            'section_4_button_text' => 'required',
            'section_4_button_link' => 'required | url',
            'destination_country' => 'required | max:4',
            'section_5_heading' => 'required',
            'section_5_text' => 'required',
            'section_1_image_1' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_1_image_2' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_2_image' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_3_image' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_4_image' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'section_4_destination_image.*' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'updated_banner_images.*' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/webp | max:50048',
            'selected_banner_image' => 'required'
        ]);

        $existingPageContents = json_decode($page->contents);

        //update banner media
        if (!empty($request->selected_banner_image)) {
            $selected_banner_image = json_decode($request->selected_banner_image);
            $existingBannerArr = $existingPageContents->banner_media;

            $existingBanner = [];
            foreach ($existingBannerArr as $key => $value) {

                if (!in_array($value[0]->fileName, $selected_banner_image)) {
                    if (Storage::exists('public/' . substr($value[0]->filePath, strpos($value[0]->filePath, '/') + 1))) {
                        Storage::delete('public/' . substr($value[0]->filePath, strpos($value[0]->filePath, '/') + 1));
                    }
                    unset($existingBannerArr[$key]);
                } else {
                    $existingBanner[count($existingBanner)] = $existingBannerArr[$key][0]->fileName;
                }
            }

            $bannerMedia = [];
            if ($request->hasFile('updated_banner_images')) {
                foreach ($request->updated_banner_images as $val) {
                    if (!empty($val) && (in_array($val->getClientOriginalName(), $selected_banner_image)) && (!in_array($val->getClientOriginalName(), $existingBanner)))
                        $bannerMedia[] = $this->uploadMedia($val, 'pages/home/banner_media/');
                }

                foreach ($existingBannerArr as $key => $value) {
                    $bannerMedia[count($bannerMedia)] = $val[0];
                }
                //array_push($bannerMedia,$existingBannerArr);
            } else {
                $bannerMedia = $existingBannerArr;
            }
        }

        //$bannerMedia[] = $existingBannerArr;

        $existingPageContents->banner_media = $bannerMedia;

        //update section_1_image_1
        if ($request->hasFile('section_1_image_1')) {
            $section_1_image_1 = $this->uploadMedia($request->section_1_image_1, 'pages/home/section_1_image_1/');
            $existingPageContents->section_1_image_1 = $section_1_image_1;
        }

        //update section_1_image_2
        if ($request->hasFile('section_1_image_2')) {
            $section_1_image_2 = $this->uploadMedia($request->section_1_image_2, 'pages/home/section_1_image_2/');
            $existingPageContents->section_1_image_2 = $section_1_image_2;
        }

        //update section_2_image
        if ($request->hasFile('section_2_image')) {
            $section_2_image = $this->uploadMedia($request->section_2_image, 'pages/home/section_2_image/');
            $existingPageContents->section_2_image = $section_2_image;
        }

        //update section_3_image
        if ($request->hasFile('section_3_image')) {
            $section_3_image = $this->uploadMedia($request->section_3_image, 'pages/home/section_3_image/');
            $existingPageContents->section_3_image = $section_3_image;
        }
        //update section_4_image
        if ($request->hasFile('section_4_image')) {
            $section_4_image = $this->uploadMedia($request->section_4_image, 'pages/home/section_4_image/');
            $existingPageContents->section_4_image = $section_4_image;
        }

        //update section_4_destination_image 
        if ($request->hasFile('section_4_destination_image')) {
            $section_4_destination_image = [];
            foreach ($request->section_4_destination_image as $val) {

                $section_4_destination_image[] = $this->uploadMedia($val, 'pages/home/section_4_destination_image/');
            }

            $existingPageContents->section_4_destination_image = $section_4_destination_image;
        }

        //store section_5_image
        if ($request->hasFile('section_5_image')) {
            $section_5_image = $this->uploadMedia($request->section_5_image, 'pages/home/section_5_image/');
            $existingPageContents->section_5_image = $section_5_image;
        }

        $existingPageContents->banner_section_heading = $request->banner_section_heading;
        $existingPageContents->banner_section_text = $request->banner_section_text;
        $existingPageContents->section_1_heading = $request->section_1_heading;
        $existingPageContents->section_1_text = $request->section_1_text;
        $existingPageContents->section_1_button_text = $request->section_1_button_text;
        $existingPageContents->section_1_button_link = $request->section_1_button_link;
        $existingPageContents->section_2_heading = $request->section_2_heading;
        $existingPageContents->section_2_text = $request->section_2_text;
        $existingPageContents->section_2_button_text = $request->section_2_button_text;
        $existingPageContents->section_2_button_link = $request->section_2_button_link;
        $existingPageContents->section_3_heading = $request->section_3_heading;
        $existingPageContents->section_3_text = $request->section_3_text;
        $existingPageContents->section_3_button_text = $request->section_3_button_text;
        $existingPageContents->section_3_button_link = $request->section_3_button_link;
        $existingPageContents->section_4_heading = $request->section_4_heading;
        $existingPageContents->section_4_text = $request->section_4_text;
        $existingPageContents->section_4_button_text = $request->section_4_button_text;
        $existingPageContents->section_4_button_link = $request->section_4_button_link;
        $existingPageContents->destination_country = $request->destination_country;
        $existingPageContents->section_5_heading = $request->section_5_heading;
        $existingPageContents->section_5_text = $request->section_5_text;

        $page->contents = json_encode($existingPageContents);

        try {
            $page->save();
        } catch (Exception $e) {
            dd($e);
        }

        return $this->getView('home');
    }


    public function createFAQ($request)
    {
        $this->validate($request, [
            'ques' => 'required',
            'answer' => 'required',
            'is_active' => 'required'
        ]);

        
        $templates = [
            [
            'ques' => $request->ques,
            'answer' => $request->answer,
            'is_active' => $request->is_active
            ]
        ];


        try {
            $existingTemplates = Page::where('name', 'faq')->first();
            if (!empty($existingTemplates->contents)) {
                
                $existingTemplates->contents = json_decode($existingTemplates->contents);
               
                $existingTemplates->contents = array_merge($existingTemplates->contents,$templates);
              
                $existingTemplates->contents = json_encode($existingTemplates->contents);
                
                $createdPage = $existingTemplates->save();
                
            } else {
                $createdPage = Page::create([
                    'name' => 'faq',
                    'contents' => json_encode($templates)
                ]);
            }


            return $this->getView('faq');
        } catch (Exception $e) {
            dd($e);
        }

        return $this->getView('faq');
    }

    public function updateFAQ($request , $page)
    {
        $this->validate($request,[
            'ques' => 'required',
            'answer' => 'required',
            'old_ques' => 'required',
            'is_active' => 'required'
        ]);

        if(!empty($page->contents))
        {
            $oldPageContents = json_decode($page->contents);

            foreach ($oldPageContents as $content) {
                if($content->ques == $request->old_ques)
                {
                    $content->ques = $request->ques;
                    $content->answer = $request->answer;
                    $content->is_active = $request->is_active;
                    break;
                }
            }

            $page->contents = json_encode($oldPageContents);
            
            try {
                $page->save();
            } catch (Exception $e) {
                dd($e);
            }

            return $this->getView('faq');

        }
    }
    public function getView(String $name)
    {
        switch ($name) {
            case 'home':
                $templates =  Page::where('name', 'home')->first();

                (!empty($templates->contents)) ? $templates->contents = json_decode($templates->contents) : '';
                
                return [
                    'view' => 'administrator.pages.home.index',
                    'data' => [
                        'countryList' => $this->getCountryList(),
                        'templates' => $templates,
                        'data_method' => !empty($templates->contents) ? 'update' : 'create'
                    ],

                ];
                break;
            case 'faq':
                $templates =  Page::where('name', 'faq')->first();
                (!empty($templates->contents)) ? $templates->contents = json_decode($templates->contents) : '';
                //dd($templates->contents);
                return [
                    'view' => 'administrator.pages.faq.index',
                    'res' => true,
                    'data' => [
                        'templates' => $templates,
                    ],

                ];
                break;
            default:
                return '';
                break;
        }
    }


    private function uploadMedia($media, $path)
    {
        $mediaArr = [];

        if ($media instanceof UploadedFile) {
            $fileData = $this->uploads($media, $path);

            if (!empty($fileData['filePath'])) {
                $mediaArr[] = $fileData;
            }
        }

        return $mediaArr;
    }
}
