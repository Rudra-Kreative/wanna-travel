<x-guest-layout>
    <section class="faq-home welcome-home">
        <img src="{{ asset('user/guest/images/faq-bg.png') }}" alt="">
        <h2>Frequently Asked Questions</h2>
    </section>

   
    <section class="faq-accordian">
        <div class="container">
            <div class="row">
                <div class="accordion f-accordian">
                    
                    @foreach ($data->contents as $index=>$content)
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
    </section>

</x-guest-layout>