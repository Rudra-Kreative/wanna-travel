<x-administrator-app-layout>
    <x-slot name="addOnCss">

    </x-slot>

    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Plans</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Plans</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
                {{-- <button type="button" class="btn btn-block btn-primary btn-lg mt-4" id="hotel_type_create"
                    style="width: 100px">Create</button> --}}

                <div id="plan_form_div" style="display:block">
                    <form
                        action="javscript:void(0)"
                        id="plan_form" data-method="{{ $data['data_method'] ?? null }}" data-slug="{{ $data['templates']->slug ?? null }}" data-action="{{ $data['data_method'] == 'update' ? route('administrator.pages.update',[$data['templates']->slug]) : route('administrator.pages.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="page_indentifier" id="page_indentifier" value="plan">
                        @if ($data['data_method'] == 'update')
                            @method('PUT')
                        @endif
                        <div class="card-body">

                            <div class="form-group ">
                                <label for="map">Page Heading</label>
                                    <input type="text" class="form-control" id="heading" name="heading"
                                        placeholder="Enter heading" value="{{ $data['templates']->contents[0]->heading ?? '' }}">
                                @error('heading')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="heading">Plans</label>

                                <select name="plan" id="plan" class="form-control">
                                    <option value="" selected>Select one plan</option>
                                    @if (!empty($data['plans']))
                                        @foreach ($data['plans'] as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('plan')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="descriptiveDiv" style="display: none">
                                <div class="form-group ">
                                    <label for="map">Price</label>
                                    <div class="input-group">
    
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="price" name="price"
                                            placeholder="Enter price for the plan" value="">
                                    </div>
                                    @error('price')
                                        <span style="color: red">{{ $message }}</span>
                                    @enderror
                                </div>
    
                                <div class="form-group">
                                    <label for="map">Add Feature Description</label>
                                    <div class="field_wrapper featureDiv">
                                        <div style="display: flex;padding-top: 2px;" class="addFeatureDiv">
                                            <input type="text" class="form-control" name="features[]">
                                            <i class='fas fa-plus-circle addFeatureBtn'style='font-size: 25px;
                                        color: rgb(44, 49, 45);
                                        cursor: pointer;
                                        padding-left: 10px;
                                        padding-top: 5px;'
                                                title="Add feature"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div style="padding: .75rem 1.25rem; display: flex">
                            <button type="button"
                                class="btn btn-primary planUpdateBtn"  >{{ Str::ucfirst($data['data_method']) }}</button>
                        </div>

                    </form>
                </div>
            </div><!-- /.col -->

        </div><!-- /.row -->

        <input type="hidden" name="plan_data" id="plan_data"
            value="{{ !empty($data['plans']) ? json_encode($data['plans']) : null }}">

    </x-slot>


    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/plan.js') }}"></script>

    </x-slot>
</x-administrator-app-layout>
