<x-guest-layout>
    <section class="iswanna-home welcome-home">
        <img src="{{ asset('user/guest/images/iswanna-bg.png') }}" alt="">
        <h2>Is WANAH For Me?</h2>
    </section>

    @foreach ($data->contents as $index=>$content)
    <section class="wanna6 iswanna-{{ $index+1 }}">
        <div class="container">
            <div class="row">
                @if (($index+1)%2 == 0)
                <div class="col-lg-4  col-md-5">
                    <h3>{{ $index+1 }}.</h3>
                    <p>{{ $content->section_text ?? '' }}</p>
                </div>
                @else
                <div class="col-lg-4  col-md-5 offset-md-7 offset-lg-8">
                    <h3>{{ $index+1 }}.</h3>
                    <p>{{ $content->section_text ?? '' }}</p>
                </div>
                @endif
            </div>
        </div>
        <img src="{{$content->section_image[0]->filePath ? URL('/' . $content->section_image[0]->filePath) : '' }}" alt="" class="wanna6-img">
        <img class="pattern" src="{{ asset('user/guest/images/pattern.svg') }}" alt="">
    </section>
    @endforeach

    <a href="javascript:void(0)" class="pm-btn check"> Check out our FAQ's</a>
</x-guest-layout>