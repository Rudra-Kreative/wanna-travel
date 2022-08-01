<?php

namespace App\Http\Controllers;

use App\Helper\Country;
use App\Helper\Media;
use App\Models\Page;
use App\Models\Plan;
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
            'slug' => ['required']
        ]);


        if (!empty($request->slug)) {

            $requestedView = $this->getView($request->slug);

            if (!empty($requestedView)) {
                return view($requestedView['view'], ['data' => $requestedView['data']]);
            } else {
                throw new ModelNotFoundException();
            }
        } else {
            throw new ModelNotFoundException();
        }
    }

    public function store(Request $request)
    {
        if (!empty($request->page_indentifier)) {
            switch ($request->page_indentifier) {
                case 'home':

                    $requestedView = $this->handleHomePage($request);

                    if (!empty($requestedView)) {
                        return redirect()->route('administrator.pages.home', ['slug' => $request->page_indentifier])
                            ->with($requestedView['data']['response']['key'], $requestedView['data']['response']['message']);
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
                case 'is_wanna_for_me':

                    $requestedView = $this->createIsWannaForMe($request);
                    if (!empty($requestedView)) {
                        return  ['data' => $requestedView['data']];
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;
                case 'contact':

                    $requestedView = $this->createContactPage($request);
                    if (!empty($requestedView)) {
                        return redirect()->route('administrator.pages.home', ['slug' => $request->page_indentifier])
                            ->with($requestedView['data']['response']['key'], $requestedView['data']['response']['message']);
                        //return view($requestedView['view'], ['data' => $requestedView['data']]);
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;
                case 'plan':
                    
                    $requestedView = $this->createPlan($request);
                    if (!empty($requestedView)) {
                        return  ['data' => $requestedView['data']];
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;
                default:
                    throw new ModelNotFoundException();
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

                        return redirect()->route('administrator.pages.home', ['slug' => $request->page_indentifier])
                            ->with($requestedView['data']['response']['key'], $requestedView['data']['response']['message']);
                    } else {
                        throw new ModelNotFoundException();
                    }

                    break;
                case 'faq':
                    $requestedView = $this->updateFAQ($request, $page);

                    if (!empty($requestedView)) {
                        return  ['data' => $requestedView['data']];
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;
                case 'is_wanna_for_me':
                    $requestedView = $this->updateIsWannaForMe($request, $page);
                    if (!empty($requestedView)) {
                        return  ['data' => $requestedView['data']];
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;
                case 'contact':
                    $requestedView = $this->updateContact($request, $page);

                    if (!empty($requestedView)) {
                        return redirect()->route('administrator.pages.home', ['slug' => $request->page_indentifier])
                            ->with($requestedView['data']['response']['key'], $requestedView['data']['response']['message']);
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;

                case 'plan':
                    $requestedView = $this->updatePlan($request, $page);

                    if (!empty($requestedView)) {
                        return  ['data' => $requestedView['data']];
                    } else {
                        throw new ModelNotFoundException();
                    }
                    break;

                default:
                    throw new ModelNotFoundException();
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
                    throw new ModelNotFoundException();
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
                'slug' => 'home',
                'contents' => json_encode($temlateArray)
            ]);

            if (!empty($createdContent->id)) {

                $response = [
                    'key' => 'success',
                    'message' => 'Home page has been created successfully!!'
                ];
            } else {

                $response = [
                    'key' => 'fail',
                    'message' => 'Home page could not be created'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'key' => 'fail',
                'message' => 'Home page could not be created'
            ];
        }

        return $this->getView($request->page_indentifier, $response);
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
            'updated_banner_images.*' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,images/jpg,image/webp | max:50048',
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
                    $existingBanner[count($existingBanner)] = $existingBannerArr->$key[0]->fileName;
                }
            }

            $bannerMedia = [];
            if ($request->hasFile('updated_banner_images')) {
                foreach ($request->updated_banner_images as $val) {
                    if (!empty($val) && (in_array($val->getClientOriginalName(), $selected_banner_image)) && (!in_array($val->getClientOriginalName(), $existingBanner)))
                        $bannerMedia[] = $this->uploadMedia($val, 'pages/home/banner_media/');
                }

                foreach ($existingBannerArr as $key => $value) {

                    $bannerMedia[count($bannerMedia)][] = [
                        'fileName' => $value[0]->fileName,
                        'fileType' => $value[0]->fileType,
                        'filePath' => $value[0]->filePath,
                        'fileSize' => $value[0]->fileSize
                    ];
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
            $isUpdated = $page->save();

            if ($isUpdated) {
                $response = [
                    'key' => 'success',
                    'message' => 'Home page has been updated successfully!!'
                ];
            } else {
                $response = [
                    'key' => 'fail',
                    'message' => 'Home page could not be updated '
                ];
            }
        } catch (Exception $e) {
            $response = [
                'key' => 'fail',
                'message' => 'Home page could not be updated '
            ];
        }

        return $this->getView('home', $response);
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
            $existingTemplates = Page::where('slug', 'faq')->first();
            if (!empty($existingTemplates->contents)) {

                $existingTemplates->contents = json_decode($existingTemplates->contents);

                $existingTemplates->contents = array_merge($existingTemplates->contents, $templates);

                $existingTemplates->contents = json_encode($existingTemplates->contents);

                $createdPage = $existingTemplates->save();

                if (!empty($createdPage)) {
                    $response = [
                        'key' => 'success',
                        'message' => 'FAQ has been added successfully!!'
                    ];
                } else {
                    $response = [
                        'key' => 'fail',
                        'message' => 'FAQ could not be added'
                    ];
                }
            } else {
                $createdPage = Page::create([
                    'name' => 'faq',
                    'slug' => 'faq',
                    'contents' => json_encode($templates)
                ]);

                if (!empty($createdPage->id)) {
                    $response = [
                        'key' => 'success',
                        'message' => 'FAQ page has been created successfully!!'
                    ];
                } else {
                    $response = [
                        'key' => 'fail',
                        'message' => 'FAQ page could not be created'
                    ];
                }
            }
        } catch (Exception $e) {
            $response = [
                'key' => 'fail',
                'message' => 'FAQ could not be added'
            ];
        }

        return $this->getView('faq', $response);
    }

    public function updateFAQ($request, $page)
    {
        $this->validate($request, [
            'ques' => 'required',
            'answer' => 'required',
            'old_ques' => 'required',
            'is_active' => 'required'
        ]);

        if (!empty($page->contents)) {

            $oldPageContents = json_decode($page->contents);

            foreach ($oldPageContents as $content) {
                if ($content->ques == $request->old_ques) {
                    $content->ques = $request->ques;
                    $content->answer = $request->answer;
                    $content->is_active = $request->is_active;
                    break;
                }
            }

            $page->contents = json_encode($oldPageContents);

            try {
                $isUpdated = $page->save();

                if ($isUpdated) {
                    $response = [
                        'key' => 'success',
                        'message' => 'FAQ page has been updated successfully!!'
                    ];
                } else {
                    $response = [
                        'key' => 'fail',
                        'message' => 'FAQ page could not be updated!!'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'key' => 'fail',
                    'message' => 'FAQ page could not be updated!!'
                ];
            }

            return $this->getView('faq', $response);
        }
    }

    public function createIsWannaForMe($request)
    {
        $this->validate($request, [
            'this_sec' => 'required',
            'section_text' => 'required',
            'section_image' => 'required | mimetypes:image/bmp,image/gif,image/png,image/jpeg,images/jpg,image/webp | max:50048'
        ]);

        try {
            $existingTemplates = Page::where('slug', 'is_wanna_for_me')->first();

            if (!empty($existingTemplates->contents)) {

                if ($request->hasFile('section_image')) {
                    $section_image = $this->uploadMedia($request->section_image, 'pages/is_wanna_for_me/section_image/' . $request->this_sec . '/');
                }

                $templates = [
                    [
                        'section' => $request->this_sec,
                        'section_text' => $request->section_text,
                        'section_image' => $section_image
                    ]
                ];

                $existingTemplates->contents = json_decode($existingTemplates->contents);

                $existingTemplates->contents = array_merge($existingTemplates->contents, $templates);

                $existingTemplates->contents = json_encode($existingTemplates->contents);

                $createdPage = $existingTemplates->save();

                if ($createdPage) {
                    $response = [
                        'key' => 'success',
                        'message' => 'Section has been updated successfully!!'
                    ];
                } else {
                    $response = [
                        'key' => 'fail',
                        'message' => 'Section could not be updated!!'
                    ];
                }
            } else {
                if ($request->hasFile('section_image')) {
                    $section_image = $this->uploadMedia($request->section_image, 'pages/is_wanna_for_me/section_image/' . $request->this_sec . '/');
                }

                $templates = [
                    [
                        'section' => $request->this_sec,
                        'section_text' => $request->section_text,
                        'section_image' => $section_image
                    ]
                ];

                $createdPage = Page::create([
                    'name' => 'Is Wanna For Me',
                    'slug' => 'is_wanna_for_me',
                    'contents' => json_encode($templates)
                ]);

                if (!empty($createdPage->id)) {
                    $response = [
                        'key' => 'success',
                        'message' => 'Page has been created successfully!!'
                    ];
                } else {
                    $response = [
                        'key' => 'fail',
                        'message' => 'Page could not be created!!'
                    ];
                }
            }
        } catch (Exception $e) {
            $response = [
                'key' => 'success',
                'message' => 'Section could not be created'
            ];
        }

        return $this->getView('is_wanna_for_me', $response);
    }


    public function updateIsWannaForMe($request, $page)
    {
        $this->validate($request, [
            'this_sec' => 'required',
            'section_text' => 'required',
            'section_image' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,images/jpg,image/webp | max:50048'
        ]);

        try {


            if (!empty($page->contents)) {
                $oldPageContents = json_decode($page->contents);
                foreach ($oldPageContents as $oldPageContent) {

                    if ($oldPageContent->section == $request->this_sec) {
                        if ($request->hasFile('section_image')) {
                            $section_image = $this->uploadMedia($request->section_image, 'pages/is_wanna_for_me/section_image/' . $request->this_sec . '/');

                            if (!empty($section_image)) {
                                if (Storage::exists('public/' . substr($oldPageContent->section_image[0]->filePath, strpos($oldPageContent->section_image[0]->filePath, '/') + 1))) {
                                    Storage::delete('public/' . substr($oldPageContent->section_image[0]->filePath, strpos($oldPageContent->section_image[0]->filePath, '/') + 1));
                                }
                            }

                            $oldPageContent->section_image = $section_image;
                        }

                        $oldPageContent->section_text = $request->section_text;

                        break;
                    }
                }

                $page->contents = json_encode($oldPageContents);
                $isUpdated = $page->save();

                if ($isUpdated) {
                    $response = [
                        'key' => 'success',
                        'message' => 'Section has been updated successfully!!'
                    ];
                } else {
                    $response = [
                        'key' => 'fail',
                        'message' => 'Section could not be updated!!'
                    ];
                }
            } else {
                $response = [
                    'key' => 'fail',
                    'message' => 'Section could not be updated!!'
                ];
            }

          
        } catch (Exception $e) {
            $response = [
                'key' => 'fail',
                'message' => 'Section could not be updated!!'
            ];
        }

        return $this->getView('is_wanna_for_me', $response);
    }

    public function createContactPage($request)
    {
        $this->validate($request, [
            'heading' => 'required',
            'maps_url' => 'required | url'
        ]);

        try {

            $templates = [
                [
                    'heading' => $request->heading,
                    'maps_url' => $request->maps_url
                ]
            ];


            $createdPage = Page::create([
                'name' => 'Contact',
                'slug' => 'contact',
                'contents' => json_encode($templates)
            ]);

            if (!empty($createdPage->id)) {
                $response = [
                    'key' => 'success',
                    'message' => 'Contact page has been created successfully!!'
                ];
            } else {
                $response = [
                    'key' => 'fail',
                    'message' => 'Contact page could not be created!!'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'key' => 'fail',
                'message' => 'Contact page could not be created!!'
            ];
        }

        return $this->getView('contact', $response);
    }

    public function updateContact($request, $page)
    {
        $this->validate($request, [
            'heading' => 'required',
            'maps_url' => 'required | url'
        ]);

        if (!empty($page->contents)) {
            $oldPageContents = json_decode($page->contents);
            $oldPageContents[0]->heading = $request->heading;
            $oldPageContents[0]->maps_url = $request->maps_url;
            $page->contents = json_encode($oldPageContents);
            try {
                $isUpdated = $page->save();

                if ($isUpdated) {
                    $response = [
                        'key' => 'success',
                        'message' => 'Contact page has been updated successfully!!'
                    ];
                } else {
                    $response = [
                        'key' => 'fail',
                        'message' => 'Contact page could not be updated updated!!'
                    ];
                }
            } catch (Exception $e) {
                $response = [
                    'key' => 'fail',
                    'message' => 'Contact page could not be updated updated!!'
                ];
            }
        }

        return $this->getView('contact', $response);
    }

    public function createPlan($request)
    {
        
        $this->validate($request, [
            'heading' => ['required'],
            'page_indentifier' => ['required'],
            'withPlan' => ['required']
        ]);


        try {
            $templates = [
                [
                    'heading' => $request->heading
                ]
            ];
            $createdPage = Page::create([
                'name' => 'Plan',
                'slug' => 'plan',
                'contents' => json_encode($templates)
            ]);

            if (!empty($createdPage->id)) {
                if ($request->withPlan == 'true') {
                    $this->validate($request, [
                        'planId' => ['required', 'exists:plans,id'],
                        'price' => ['required', 'numeric'],
                        'features.*' => ['required', 'min:1']
                    ]);

                    //updating the plan table
                    $plan = Plan::find($request->planId);
                    $plan->price = $request->price;

                    $planUpdated = $plan->save();

                    if ($planUpdated) {
                        //creating feature for the given plan

                        $addedPlanFeatureIds = [];
                        foreach ($request->features as $feature) {

                            $isPLanAdded = $plan->planFeatures()->create(['name' => $feature]);
                            if ($isPLanAdded->id) {
                                $addedPlanFeatureIds[] = $isPLanAdded->id;
                            }
                        }

                        if (!empty($addedPlanFeatureIds)) {
                            $response = [
                                'key' => 'success',
                                'message' => 'Plan page has been created successfully!!'
                            ];
                        } else {
                            $response = [
                                'key' => 'fail',
                                'message' => 'Plan features could not be added!!'
                            ];
                        }
                    } else {
                        $response = [
                            'key' => 'fail',
                            'message' => 'Plan page could not be created!!'
                        ];
                    }
                } else {
                    $response = [
                        'key' => 'success',
                        'message' => 'Plan page has been created successfully!!'
                    ];
                }
            } else {
                $response = [
                    'key' => 'fail',
                    'message' => 'Plan page could not be created!!'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'key' => 'fail',
                'message' => 'Plan page could not be created!!'
            ];
        }

        return $this->getView('plan', $response);
    }

    public function updatePlan($request, $page)
    {
        // print_r($page);
        // dd($request->all());

        $this->validate($request, [
            'heading' => ['required'],
            'page_indentifier' => ['required'],
            'withPlan' => ['required']
        ]);

        try {
            if (!empty($page->contents)) {
                $oldPageContents = json_decode($page->contents);
                $oldPageContents[0]->heading = $request->heading;
                $page->contents = json_encode($oldPageContents);
                

                $isPageUpdated = $page->save();
                if($isPageUpdated)
                {
                    if ($request->withPlan == 'true')
                    {
                        $this->validate($request, [
                            'planId' => ['required', 'exists:plans,id'],
                            'price' => ['required', 'numeric'],
                            'features.*' => ['required', 'min:1']
                        ]);

                         //updating the plan table
                        $plan = Plan::with(['planFeatures'])->find($request->planId);
                        $plan->price = $request->price;
                        $isPlanUpdated = $plan->save();
                        
                        if($isPlanUpdated)
                        {
                            
                            if(!empty($plan->planFeatures) && (count($plan->planFeatures)>0))
                            {
                                $isOldFeaturesDeleted = $plan->planFeatures()->delete();
                                
                            }

                            $updatedPlanFeatureIds = [];
                            foreach ($request->features as $feature) {

                                $isPlanFeatureUpdated = $plan->planFeatures()->create(['name' => $feature]);

                                if ($isPlanFeatureUpdated->id) {
                                    $updatedPlanFeatureIds[] = $isPlanFeatureUpdated->id;
                            }
                        }

                        if (!empty($updatedPlanFeatureIds)) {
                            $response = [
                                'key' => 'success',
                                'message' => 'Plan page has been updated successfully!!'
                            ];
                        } else {
                            $response = [
                                'key' => 'fail',
                                'message' => '1-Plan page could not be updated!!'
                            ];
                        }

                        }
                        else
                        {
                            $response = [
                                'key' => 'fail',
                                'message' => '2-Plan page could not be updated!!'
                            ];
                        }
                    }
                    else
                    {
                        $response = [
                            'key' => 'success',
                            'message' => 'Plan page has been updated successfully!!'
                        ];
                    }
                }
                else
                {
                    $response = [
                        'key' => 'fail',
                        'message' => '3-Plan page could not be updated!!'
                    ];
                }
            }
            else
            {
                $response = [
                    'key' => 'fail',
                    'message' => '4-Plan page could not be updated !!'
                ];
            }
        } catch (Exception $e) {
           
            $response = [
                'key' => 'fail',
                'message' => '5-Plan page could not be updated !!'
            ];
        }
        
        return $this->getView('plan', $response);
    }

    public function getView(String $slug, $resArray = [])
    {

        switch ($slug) {
            case 'home':
                $templates =  Page::where('slug', 'home')->first();

                (!empty($templates->contents)) ? $templates->contents = json_decode($templates->contents) : '';

                return [
                    'view' => 'administrator.pages.home.index',
                    'data' => [
                        'countryList' => $this->getCountryList(),
                        'templates' => $templates,
                        'data_method' => !empty($templates->contents) ? 'update' : 'create',
                        'response' => $resArray
                    ],

                ];
                break;
            case 'faq':
                $templates =  Page::where('slug', 'faq')->first();
                (!empty($templates->contents)) ? $templates->contents = json_decode($templates->contents) : '';
                //dd($templates->contents);
                return [
                    'view' => 'administrator.pages.faq.index',
                    'data' => [
                        'templates' => $templates,
                        'response' => $resArray
                    ],

                ];
                break;
            case 'is_wanna_for_me':
                $templates =  Page::where('slug', 'is_wanna_for_me')->first();
                (!empty($templates->contents)) ? $templates->contents = json_decode($templates->contents) : '';
                return [
                    'view' => 'administrator.pages.is_wanna_for_me.index',
                    'res' => true,
                    'data' => [
                        'templates' => $templates,
                        'response' => $resArray
                    ],

                ];
                break;
            case 'contact':
                $templates =  Page::where('slug', 'contact')->first();
                (!empty($templates->contents)) ? $templates->contents = json_decode($templates->contents) : '';
                return [
                    'view' => 'administrator.pages.contact.index',
                    'res' => true,
                    'data' => [
                        'templates' => $templates,
                        'data_method' => !empty($templates->contents) ? 'update' : 'create',
                        'response' => $resArray
                    ],

                ];
                break;
            case 'plan';
                $templates =  Page::where('slug', 'plan')->first();
                (!empty($templates->contents)) ? $templates->contents = json_decode($templates->contents) : '';

                return [
                    'view' => 'administrator.pages.pricing_plan.index',
                    'res' => true,
                    'data' => [
                        'templates' => $templates,
                        'plans' => Plan::with('planFeatures')->where('is_active', true)->get(),
                        'data_method' => !empty($templates->contents) ? 'update' : 'create',
                        'response' => $resArray
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
