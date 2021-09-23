@component('mail::message')
# {{ $data['zadeva'] }}

## Ime: 
{{ $data['ime'] }}

## Priimek: 
{{ $data['priimek'] }}

## Email: 
{{ $data['email'] }}

## Telefon: 
{{ $data['tel'] }}

## Sporočilo:
{{ $data['sporocilo'] }}
@endcomponent
