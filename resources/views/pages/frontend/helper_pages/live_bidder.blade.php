@forelse($bidder_list as $key => $bidder)
<tr>
    <td>{{ $bidder['id'] }}</td>
    <td>{{ $bidder['name'] }}</td>
</tr>
@empty
<tr>
    <td colspan="2">No Bidder available</td>
</tr>
@endforelse
