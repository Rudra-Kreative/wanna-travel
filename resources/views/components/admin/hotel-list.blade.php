@props(['hotels'=>$hotels])

<table id="hotel_table" class="display" data-target="{{ url('/administrator/category') }}">
    <thead>
        <tr>
            <th>Name</th>
            <th>Images</th>
            <th>Rating</th>
            <th>Country</th>
            <th>Property Type</th>
            <th>Hotel Type</th>
            <th>Amenities</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="hotel_body" >
        @foreach ($hotels as $hotel)
            
            <tr>
                <td >

                    {{-- <img class="rounded-circle" style="width: 50px;height: 50px;" src="{{$hotelType->avatar ? URL('/'.$hotelType->avatar) : 'https://i.pravatar.cc/50?u='.$$hotelType->id }}" alt=""> --}}
                    <p>{{ $hotel->name }}</p>
                </td>
                <td> 
                    @if (!empty($hotel->hotelImages))
                    <div class="container">
                        <div class='row'>
                        @foreach ($hotel->hotelImages as $index=>$hotelImage)

                            @if ($index == 1 )
                            {{-- <img class="rounded-circle" style="width: 50px;height: 50px;" src="{{$hotelImage->image ? URL('/'.$hotelImage->image) : ''}}" alt=""> --}}
                            <div class='col-md-4 viewAllImages' data-targetURI="{{ route('administrator.hotel.getHotelImages',['hotel'=>$hotel->id]) }}" data-hotelId="{{ $hotel->id }}" style="cursor: pointer">
                                <img title="View more" style="width: 50px;height: 50px;opacity: 0.3;" src="{{$hotelImage->image ? URL('/'.$hotelImage->image) : ''}}"
                                    class="rounded-circle previewImg" alt="">
                                    <div class="viewmoreimg">
                                    <i class='fas fa-eye fa-xs' style=""></i>
                                    <p>{{ count($hotel->hotelImages)-1 }} more</p>
                                </div>
                            </div>
                                
                                @break
                            @else
                            <img class="rounded-circle" style="width: 50px;height: 50px;" src="{{$hotelImage->image ? URL('/'.$hotelImage->image) : ''}}" alt="">

                            @endif

                        @endforeach
                        </div>
                    </div>
                    @endif
                </td>
                <td>{{ $hotel->star_rating ? $hotel->star_rating .' star' : '' }}</td>
                <td>{{ $hotel->country ?? '' }}</td>
                <td><span class="badge badge-secondary">{{ $hotel->propertyType->name }}</span></td>
                <td>
                    @foreach ($hotel->hotel_type as $hotelType)
                    <span class="badge badge-primary">{{ $hotelType->name }}</span>
                    @endforeach
                </td>
                <td>
                    @foreach ($hotel->amenity as $amenity)
                    <span class="badge badge-success">{{ $amenity->name }}</span>
                    @endforeach
                </td>
                <td data-hotelId="{{ $hotel->id }}">
                    <i class="fa fa-eye fa-xs viewHotelDetails" data-targetURI="{{ route('administrator.hotel.view',['hotel'=>$hotel->id]) }}" title="View Details" style="cursor: pointer;" aria-hidden="true"></i>
                    <i class="fa fa-trash fa-xs deleteHotelType" title="Delete"   style="cursor: pointer;" aria-hidden="true"></i>
                    <i class="fa fa-edit fa-xs editHotelType" title="Edit" style="cursor: pointer;" aria-hidden="true"></i>
                    <i class="fa fa-ban fa-xs suspendHotelType" title="Suspend" style="cursor: pointer" aria-hidden="true"></i>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>