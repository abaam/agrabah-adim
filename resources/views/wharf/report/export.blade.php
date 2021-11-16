<table>
    <thead>
    <tr>
        <th>Created At</th>
        <th>Expiration</th>
        @if($type == 'reverse-bidding')
            <th>Items</th>
        @else
            <th data-sortable="false">Photo</th>
            <th>Name</th>
            <th>Selling Price</th>
        @endif
        @if($type!='market-place')
            <th>Bought Price</th>
            <th>Winner</th>
        @endif
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($row as $col)
        <tr>
            <td>{{$col->created_at}}</td>
            <td>{{$col->expiration_time}}</td>
            @if($type == 'reverse-bidding')
                <td>
                    <ol>
                        @foreach($col->items as $item)
                            <li>{{$item->item_name}} -{{$item->quantity}}{{$item->unit_of_measure_short}} </li>
                        @endforeach
                    </ol>
                </td>
            @else
                <td>@if($col->hasMedia($type))
                        <img class='img-thumbnail bidding_photos' src='{{config('app.wharf_url').$col->getFirstMediaUrl($type)}}' width="150px">
                    @endif
                </td>
                <td>{{$col->name}}</td>
                <td>{{$type == 'reverse-bidding'?$col->asking_price:$col->original_price}}</td>
            @endif
            @if($type!='market-place')
                <td>{{$col->winner?$col->current_bid:'No Bidder'}}</td>
                <td>{{$col->winner?$col->winner->name??$col->winner->email:'No Bidder'}}</td>
            @endif
    @endforeach
    </tbody>
</table>