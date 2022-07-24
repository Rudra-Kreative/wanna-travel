<x-administrator-app-layout>
    <x-slot name="addOnCss">

    </x-slot>
    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">FAQ</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">FAQ</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
                {{-- <button type="button" class="btn btn-block btn-primary btn-lg mt-4" id="hotel_type_create"
                    style="width: 100px">Create</button> --}}

                <div id="hotel_type_form_div" style="display:block">
                    <form action="javscrip:void(0)" id="faq_form" data-slug="{{ $data['templates']->slug ?? null }}" data-action=""
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="page_indentifier" id="page_indentifier" value="faq">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Select Questions or Create One</label>

                                <select name="faq_ques" id="faq_ques" class="form-control">
                                    <option value="" selected>Select a question</option>
                                    <optgroup label="Create ?">
                                        <option value="create">Create a new one +</option>
                                    </optgroup>

                                    @if (!empty($data['templates']->contents))
                                        <optgroup label="Select question">
                                            @foreach ($data['templates']->contents as $content)
                                                <option value="{{ $content->ques }}">{{ $content->ques }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                </select>
                                @error('name')
                                    <span style="color: red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="ques_answer_div" style="display: none">
                                <div class="form-group">
                                    <label for="ques">Question</label>
                                    <input type="text" class="form-control" name="ques" required id="ques"
                                        placeholder="Enter question">
                                </div>
                                <div class="form-group">
                                    <label for="answer">Answer</label>

                                    <textarea name="answer" required id="answer" cols="70" rows="5" placeholder="Enter answer"
                                        class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div style="padding: .75rem 1.25rem; display: flex">
                            <button type="button" id="faq_button" class="btn btn-primary" disabled>No action
                                permitted</button>

                            <div style="display: none" class="fac_active_button">
                                <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-on bootstrap-switch-focused"
                                    style="width: 86px;margin-left: 10px;margin-top: 5px;">
                                    <div class="bootstrap-switch-container" style="width: 126px; margin-left: 0px;">
                                        <span class="bootstrap-switch-handle-on bootstrap-switch-primary"
                                            style="width: 42px;">Active</span><span class="bootstrap-switch-label"
                                            style="width: 42px;">&nbsp;</span><span
                                            class="bootstrap-switch-handle-off bootstrap-switch-default"
                                            style="width: 42px;">Deactive</span><input type="checkbox"
                                            name="faq-active-checkbox" id="faq-active-checkbox" checked="" data-bootstrap-switch=""></div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div><!-- /.col -->

        </div><!-- /.row -->
        <input type="hidden" name="faq_data" id="faq_data"
        value="{{ !empty($data['templates']->contents) ? json_encode($data['templates']->contents) : null }}">
       
        
    </x-slot>


    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/faq.js') }}"></script>
    </x-slot>
</x-administrator-app-layout>
