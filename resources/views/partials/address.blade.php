<address>
    {{ $address->name }}<br>
    {{ $address->line_1 }}<br>
    {{ $address->line_2 }}{!! $address->line_2 ? '<br>' : '' !!}
    {{ $address->city }} {{ $address->postcode }}<br>
    {{ $address->country_name }}<br>
    {{ $address->phone }}
</address>