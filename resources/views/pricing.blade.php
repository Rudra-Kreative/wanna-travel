<x-app-layout>
    <x-slot name="addOnCss">
    </x-slot>
    <section class="pricing">
        <div class="container">
            <div class="row">
                @if (!empty($plans))
                    @foreach ($plans as $plan)
                        <div class="col-lg-4 col-md-6">
                            <div class="price-box {{ $plan->id == 2 ? 'recom' : '' }}">
                                <ul class="type">
                                    <li>{{ $plan->name }}</li>
                                    <li>${{ number_format($plan->price, 2) }}</li>
                                </ul>
                                <h4>Plan Includes</h4>
                                <ul class="plan-list">

                                    @if (!empty($plan->planFeatures))
                                        @foreach ($plan->planFeatures as $planFeature)
                                            <li><i class="fa-solid fa-check"></i> {{ $planFeature->name }}</li>
                                        @endforeach
                                    @else
                                        <li><i class="fa-solid fa-cross"></i> No details available</li>
                                    @endif
                                </ul>
                                <a href="#" class="detail">View All Details</a>
                                <a href="javascript:void(0)" class="planSelectBtn pm-btn {{ $plan->id == 2 ? 'select' : '' }}">Select</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <x-slot name="addOnJs">
        <script src="{{ asset('user/auth/js/pages/pricing-plan.js') }}"></script>
    </x-slot>
</x-app-layout>
