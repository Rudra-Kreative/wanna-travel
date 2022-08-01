<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Page $page)
    {
        
        if(!empty($page->contents))
        {
           
            !empty($page->contents) ? $page->contents = json_decode(($page->contents)):'';
            //dd($page);

            if(!empty($page->slug) && $page->slug == 'home')
            {
                $faq = Page::where('slug','faq')->first();
                !empty($faq->contents) ? $faq->contents = json_decode(($faq->contents)):'';
                return view($this->getView($page),['data'=>$page,
                'faq'=> $faq]);
                
            }
            return view($this->getView($page),['data'=>$page]);
        }

        throw new ModelNotFoundException();
    }

    public function getView($page)
    {
        switch ($page->slug) {
            case 'home':
                 return 'home';
                break;
            case 'is_wanna_for_me':
                 return 'is-wanna';
                break;
            case 'faq':
                 return 'faq';
                break;
            case 'contact':
                 return 'contact';
                break;
            
            default:
                # code...
                break;
        }
    }
}
