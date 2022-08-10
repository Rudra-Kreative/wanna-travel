@props(['hotelTypes'=>$hotelTypes])

<table id="hotel_type_table" class="display" data-target="{{ url('/administrator/category') }}">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="hotel_type_body" >
        @foreach ($hotelTypes as $hotelType)
            
            <tr data-edit-target="{{ route('administrator.hotel.type.edit',['hotelType'=>$hotelType->id]) }}" data-delete-target="{{ route('administrator.hotel.type.delete',['hotelType'=>$hotelType->id]) }}">
                <td>

                    <p>{{ $hotelType->name }}</p>
                </td>
                <td>{{ $hotelType->desc }}</td>
                <td data-hotelTypeId="{{ $hotelType->id }}">
                    <i class="fa fa-trash deleteHotelType" title="Delete"   style="cursor: pointer;" aria-hidden="true"></i>
                    <i class="fa fa-edit editHotelType" title="Edit" style="cursor: pointer;" aria-hidden="true"></i>
                    {{-- <i class="fa fa-ban suspendHotelType" title="Suspend" style="cursor: pointer" aria-hidden="true"></i> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>