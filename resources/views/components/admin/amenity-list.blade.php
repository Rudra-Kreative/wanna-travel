@props(['amenities'=>$amenities])

<table id="amenity_table" class="display" data-target="{{ url('/administrator/category') }}">
    <thead>
        <tr>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="amenity_body" >
        @foreach ($amenities as $amenity)
            
            <tr data-edit-target="{{ route('administrator.hotel.type.edit',['hotelType'=>$amenity->id]) }}" data-delete-target="{{ route('administrator.hotel.type.delete',['hotelType'=>$amenity->id]) }}">
                <td>

                    <p>{{ $amenity->name }}</p>
                </td>
                <td data-amenityId="{{ $amenity->id }}">
                    {{-- <i class="fa fa-trash deleteHotelType" title="Delete"   style="cursor: pointer;" aria-hidden="true"></i> --}}
                    <i class="fa fa-edit editAmenity" title="Edit" style="cursor: pointer;" aria-hidden="true"></i>
                    <i class="fa fa-ban suspendAmenity" title="Suspend" style="cursor: pointer" aria-hidden="true"></i>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>