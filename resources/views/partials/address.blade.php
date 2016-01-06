<address>
    {{ $address->name }}<br>
    {{ $address->line_1 }}<br>
    {{ $address->line_2 ? $address->line_2 . "<br>" : '' }}
    {{ $address->city }} {{ $address->postcode }}<br>
    {{ $address->country }}<br>
    {{ $address->phone }}
</address>