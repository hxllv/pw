@component('mail::message')

# Naročilo za {{ $data['userData']['ime'] }} {{ $data['userData']['priimek'] }}.

## Kontaktni podatki
- e-naslov: {{ $data['userData']['email'] }},
- Telefonska št.: {{ $data['userData']['tel'] }}

## Naslov za dostavo
- {{ $data['userData']['naslov'] }},
- {{ $data['userData']['kraj'] }}, {{ $data['userData']['posta'] }}

## Način dostave
- Pošta Slovenije

## Način plačila
- Plačilo po povzetju

## Izdelki

@foreach ($data['items'] as $item)

- {{ $item->title }}, {{ $item->price }} €  `(ID: {{ $item->id }})`

@endforeach

- Skupaj: {{ $data['price'] }} €

## Opombe:
{{ $data['notes'] }}

@endcomponent

