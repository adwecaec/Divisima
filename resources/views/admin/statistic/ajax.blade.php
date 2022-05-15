@if($status)
    <tr>
        <td>
            <p>
            @foreach($products as $key => $p)
                {{$p->name}}{{ $key == count($products) - 1 ? '' : ', ' }} <br>  <br>
             @endforeach
            </p>
        </td>
        <td>
            <p>{{$orders_amount}}</p>
        </td>
        <td>
            <p><b>₴{{$total}}</b></p>
        </td>
        <td>
            <p>{{$products[0]->categoryGroups->name}}</p>
        </td>
        <td>
            <p>{{$products[0]->categories->name}}</p>
        </td>
        <td>
            <p>{{$products[0]->subcategories->name}}</p>
        </td>
        <td>
            <p>{{$products[0]->brands->name}}</p>
        </td>
        <td>
            <p>{{$registeredUsers}}</p>
        </td>
    </tr>

    @else
    <tr>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
            <p>Not Found</p>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
    </tr>
@endif