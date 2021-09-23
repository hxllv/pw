@extends('layouts.admin')

@section('scripts')

@endsection

@section('content')

<div class="container">
    <a href="{{ route('admin-index') }}">Nazaj na admin page</a>
    {{-- <input id="id-type" type="hidden" value="{{$item["id_type"]}}" name="id"/> --}}

    <div style="opacity: 1;">
        <ul>
            <li>
                <label>Naslov: </label>
                <b>{{ $item->title }}</b>
            </li>
            <li>
                <label>Opis: </label>
                <b>{{ $item->description }}</b>
            </li>
            <li>
                <label>Tip izdelka: </label>
                <b>{{ $type[0]->name }}</b>
            </li>
            <li>
                <label>Cena: </label>
                <b>{{ $item->price }}</b>
            </li>
            <li>
                <label>Glavna slika: </label><br/>
                <img src="/storage/{{ $item->main_image }}" class="img-preview w-100"> 
            </li>

            <li>
                <label>Dodatne slike: </label><br/>
                <ul>
                    @foreach ($imgs as $img)
                    <li>
                        <img src="/storage/{{ $img->image }}" class="img-preview w-100"> 
                    </li>    
                    @endforeach
                </ul>
            </li>
        </ul>

        <a class="btn btn-secondary mb-2" href="{{ route('admin-edit-item', $item->id) }}">Spremeni</a>

        <form method="post" action="{{ route('admin-destroy-item', $item->id) }}">
            @method('delete')
            @csrf
            <div class="form-group">
                <input class="btn btn-danger" type="submit" value="Zbriši">
                <b>Pri brisanju izdelka se izbrišejo tudi vse z njem povezane slike!</b>
            </div>
        </form>

        <edit-avail avail="{{ $item->available }}" id="{{ $item->id }}"></edit-avail>
    </div>

</div>

@endsection