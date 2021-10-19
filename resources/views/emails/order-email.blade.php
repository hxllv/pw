@component('mail::message')

# Naročilo za {{ $data['userData']['ime'] }} {{ $data['userData']['priimek'] }}.

## Kontaktni podatki
- e-naslov: {{ $data['userData']['email'] }},
- Telefonska št.: {{ $data['userData']['tel'] }}

## Naslov za dostavo
- {{ $data['userData']['naslov'] }},
- {{ $data['userData']['kraj'] }}, {{ $data['userData']['posta'] }}

@foreach ($data['items'] as $item)

{{$item}}
    
@endforeach

@endcomponent

