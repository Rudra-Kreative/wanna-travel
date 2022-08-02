<?php

namespace App\Http\Controllers\user;

use App\Helper\Country;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Plan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use Country;
    public function index(Page $page)
    {

        if (!empty($page->contents)) {

            !empty($page->contents) ? $page->contents = json_decode(($page->contents)) : '';


            if (!empty($page->slug) && $page->slug == 'home') {

                if (!empty($page->contents->destination_country)) {

                    foreach ($page->contents->destination_country as $index => $destination_country) {
                        $page->contents->destination_country[$index] = $this->getCountryList()[array_search(strtoupper($destination_country), array_column($this->getCountryList(), 'code'))]['name'] ?? '';
                    }
                }
                $faq = Page::where('slug', 'faq')->first();
                !empty($faq->contents) ? $faq->contents = json_decode(($faq->contents)) : '';
                return view($this->getView($page), [
                    'data' => $page,
                    'faq' => $faq
                ]);
            }

            elseif ((!empty($page->slug) && $page->slug == 'plan')) {
                $plans = Plan::with(['planFeatures'])->where('is_active',true)->get();
                
                return view($this->getView($page), [
                    'data' => $page,
                    'plans' => $plans
                ]);
            }
            return view($this->getView($page), ['data' => $page]);
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
            case 'plan':

                return 'pricing';
                break;

            default:
                # code...
                break;
        }
    }
}
