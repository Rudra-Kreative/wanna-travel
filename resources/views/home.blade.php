<x-guest-layout>

    <section class="home-sec">
        <div class="owl-carousel owl-theme home-slider">
            @if(!empty($data->contents->banner_media))
                @foreach ($data->contents->banner_media as $banner_media)
                <div class="item ">
                    <img src="{{$banner_media[0]->filePath ? URL('/' . $banner_media[0]->filePath) : '' }}" alt="">
                    <div class="banner">
                        <div class="container">
                            <div class="row">
                                <h2>{{ $data->contents->banner_section_heading ?? '' }}</h2>
                                <p>{{ $data->contents->banner_section_text ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    
    
    </section>
    <section class="wanna2">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <span class="short">What We Do</span>
                    <h3>{{ $data->contents->section_1_heading??'' }}
                    </h3>
                    <p>@excerpt($data->contents->section_1_text ?? '')</p>
                    <a href="{{  $data->contents->section_1_button_link ?? '' }}" class="pm-btn">{{ $data->contents->section_1_button_text??'' }}</a>
                </div>
                <div class="col-lg-7 wanna-img">
                    <img src="{{$data->contents->section_1_image_1[0]->filePath ? URL('/' . $data->contents->section_1_image_1[0]->filePath) : '' }}" alt="">
                    <img src="{{$data->contents->section_1_image_2[0]->filePath ? URL('/' . $data->contents->section_1_image_2[0]->filePath) : '' }}" alt="">
                </div>
            </div>
        </div>
        <img class="pattern2" src="{{ asset('user/guest/images/pattern2.svg') }}" alt="">
    </section>
    <section class="wanna3">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-8 col-md-5 offset-md-7">
                    <h3>{{ $data->contents->section_2_heading ?? '' }}</h3>
                    <p>@excerpt($data->contents->section_2_text ?? '') </p>
                    <a href="{{ $data->contents->section_2_button_link ?? '' }}" class="pm-btn">{{ $data->contents->section_2_button_text??'' }}</a>
                </div>
            </div>
        </div>
        <img src="{{$data->contents->section_2_image[0]->filePath ? URL('/' . $data->contents->section_2_image[0]->filePath) : '' }}" alt="" class="wanna3-img">
    </section>
    <section class="wanna4 text-end">
        <div class="container text-start">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <h3>{{ $data->contents->section_3_heading ?? '' }}</h3>
                    <p>@excerpt($data->contents->section_3_text ?? '')
                    </p>
                    <a href="{{ $data->contents->section_3_button_link }}" class="pm-btn">{{ $data->contents->section_3_button_text }}</a>
                </div>
            </div>
        </div>
        <img src="{{$data->contents->section_3_image[0]->filePath ? URL('/' . $data->contents->section_3_image[0]->filePath) : '' }}" alt="" class="wanna4-img">
    </section>
    <section class="wanna5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 wanna5-img-box1">
                    <img src="{{$data->contents->section_4_image[0]->filePath ? URL('/' . $data->contents->section_4_image[0]->filePath) : '' }}" alt="">
                    <div class="img-box-text">
                        <h4>{{ $data->contents->section_4_heading ?? '' }}</h4>
                        <h5>@excerptShort($data->contents->section_4_text ?? '')</h5>
                        <a href="{{ $data->contents->section_4_button_link }}" class="pm-btn">{{ $data->contents->section_4_button_text ?? '' }}</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 wanna5-img-box2">
                    @if(!empty($data->contents->destination_country))
                        @foreach ($data->contents->section_4_destination_image as $index=>$desImage)
                        <div class="wanna-img-boxes">
                            <a href="">
                                <img src="{{ $desImage[0]->filePath ? URL('/' . $desImage[0]->filePath) : '' }}" alt="">
                            </a>
                            <h6>{{ 'Test' }}</h6>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="wanna6">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 offset-md-7 offset-lg-7">
                    <h3>{{  $data->contents->section_5_heading ?? ''  }}</h3>
                    <p>@excerpt($data->contents->section_5_text ?? '')</p>
    
                </div>
            </div>
        </div>
        <img src="{{$data->contents->section_5_image[0]->filePath ? URL('/' . $data->contents->section_5_image[0]->filePath) : '' }}" alt="" class="wanna6-img">
        <img class="pattern" src="{{ asset('user/guest/images/pattern.svg') }}" alt="">
    </section>
    <section class="wanna-accordian">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Frequently Asked Questions</h2>
                    <div class="accordion f-accordian">
                        @foreach ($faq->contents as $index=>$content)
                        @if (!empty($content->is_active) && ($content->is_active == 'true'))
                        <h4 class="accordion-toggle">{{ $content->ques ?? '' }} </h4>
                        <div class="accordion-content" style="display: {{ $index == 0 ? 'block' : 'none'}}">
                            <p>{{ $content->answer ?? '' }}</p>
                        </div>
                        @endif
                        @endforeach
    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="wanna7">
        <img src="{{ asset('user/guest/images/wanna-sec7-img1.png') }}" alt="">
        <div class="text-box text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h5>Fancy a quick chat, more info? Email me.</h5>
                        <h4>charlotte@weallneedaholiday.com</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
