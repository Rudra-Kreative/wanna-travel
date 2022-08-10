@props(['propertyTypes'=>$propertyTypes])

<table id="property_type_table" class="display">
    <thead>
        <tr>
            <th style="text-align: center">Name</th>
            <th>Description</th>
            <th>Hotel Types</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody id="property_type_body" >
        @foreach ($propertyTypes as $propertyType)
            
            <tr data-edit-target="{{ route('administrator.hotel.property.edit',['propertyType'=>$propertyType->id]) }}" data-delete-target="{{ route('administrator.hotel.property.delete',['propertyType'=>$propertyType->id]) }}">
                <td style="text-align: center">
                    <img class="rounded-circle" style="width: 50px;height: 50px;" src="{{$propertyType->avatar ? URL('/'.$propertyType->avatar) : 'https://i.pravatar.cc/50?u='.$propertyType->id }}" alt="">
                    <p>{{ $propertyType->name }}</p>
                </td>
                <td>{{ $propertyType->desc }}</td>
                <td>
                @foreach ($propertyType->hotel_type as $hotelType)
                <span class="badge badge-primary">{{ $hotelType->name }}</span>
                @endforeach
                </td>
                <td data-propertyTypeId="{{ $propertyType->id }}" style="text-align: left">
                    <i class="fa fa-trash fa-xs deletePropertyType" title="Delete"   style="cursor: pointer;" aria-hidden="true"></i>
                    <i class="fa fa-edit fa-xs editPropertyType" title="Edit" style="cursor: pointer;" aria-hidden="true"></i>
                    {{-- <i class="fa fa-ban suspendPropertyType" title="Suspend" style="cursor: pointer" aria-hidden="true"></i> --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>