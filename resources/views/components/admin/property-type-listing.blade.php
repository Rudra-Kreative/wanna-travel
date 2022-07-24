@props(['propertyTypes'=>$propertyTypes])

<table id="property_type_table" class="display" data-target="{{ url('/administrator/category') }}">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="property_type_body" >
        @foreach ($propertyTypes as $propertyType)
            
            <tr>
                <td style="text-align: center">
                    {{ $propertyType->name }}
                </td>
                <td>{{ $propertyType->desc }}</td>
                <td data-propertyTypeId="{{ $propertyType->id }}">
                    <i class="fa fa-trash deletePropertyType" title="Delete"   style="cursor: pointer;" aria-hidden="true"></i>
                    <i class="fa fa-edit editPropertyType" title="Edit" style="cursor: pointer;" aria-hidden="true"></i>
                    <i class="fa fa-ban suspendPropertyType" title="Suspend" style="cursor: pointer" aria-hidden="true"></i>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>