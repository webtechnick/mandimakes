<address>
    <strong>{{ $address->name_line }}</strong><br>
    {{ $address->street }} @if($address->street_2), {{ $address->street_2 }} @endif<br>
    {{ $address->city }}, {{ $address->state }} {{ $address->zipcode }}<br>
</address>