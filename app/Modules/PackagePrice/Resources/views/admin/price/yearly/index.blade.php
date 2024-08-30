
<table id="yearly_table" class="display table table-striped table-bordered">
    <thead>
    <tr>
        <th>price</th>
        <th>Recurring</th>
        <th>Status</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($stripe_price_yearly  as $key)
        <tr>
            <td>{{$key->price ?: '-'}}</td>
            <td>{{$key->recurring ?: '-'}}</td>
            <td>{{$key->is_active ?: '-'}}</td>
            <td>{{$key->created_at ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>






