@extends('layouts.admin')

@section('scripts')

@endsection

@section('content')

<div class="container">
    <a href="{{ route('admin-index') }}">Nazaj na admin page</a>
    {{-- <input id="id-type" type="hidden" value="{{$item["id_type"]}}" name="id"/> --}}

    @if ($curType !== null)
        <h2>{{ $types->where("id", $curType)->first()->name }}</h2>
    @else
        <h2>Vsi izdelki</h2>
    @endif

    <form action="{{ route('admin-show-items') }}">
        <label for="type">Tip:</label>
        <select name="type" id="type">
            <option value="">Vsi izdelki</option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
        <label for="avail">Razpoložljivost:</label>
        <select name="avail" id="avail">
            <option value="">Vsi izdelki</option>
            <option value="1">Na voljo</option>
            <option value="0">Ni voljo</option>
        </select>
        <input type="submit" value="Filtriraj">
    </form>

    <div class="row">
        @foreach ($items as $item)
        <a class="col-sm-4" href="{{ route('admin-show-item', $item->id) }}">
            <div class="card">
                <img src="/storage/{{ $item->main_image }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text">{{ $item->price }}</p>
                    <p class="card-text">{{ $types->where("id", $item->type_id)->first()->name }}</p>
                    <p class="card-text">{{ $item->available === 1 ? "Na voljo" : "Ni na voljo" }}</p> 
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- <div style="opacity: 1;">
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
    </div> --}}

</div>

@endsection