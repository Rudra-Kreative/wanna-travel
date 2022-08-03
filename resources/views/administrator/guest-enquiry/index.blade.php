<x-administrator-app-layout>
    <x-slot name="addOnCss">

    </x-slot>
    <x-slot name='header'>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Enquery </h1>

            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Enquery</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </x-slot>

    <x-admin.enquiry-list :enquiries="$data" />

    <x-slot name="addOnJs">
        <script src="{{ asset('admin/dist/js/pages/guest-enquiry.js') }}"></script>
    </x-slot>

</x-administrator-app-layout>
