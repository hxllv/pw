@extends('layouts.admin')

@section('scripts')

@endsection

@section('content')

<div class="container">
    <h1 class="display-1">Zdravo Žan</h1>

    <ul class="list-group">
        <li class="list-group-item">
            <h3>Upravljanje z izdelki:</h3>
            <ul>
                <li class="p-2">
                    <a href="{{ route('admin-create-item') }}">Dodaj izdelek</a>
                </li>

                <li class="p-2">
                    <div class="dropdown show">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Izberi izdelek
                        </a>
                      
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($items as $item)
                                <a class="dropdown-item" href="{{ route('admin-show-item', $item->id) }}">{{ $item->title }}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <li class="list-group-item">
            <h3>Upravljanje s tipi izdelkov:</h3>
            <ul>
                <li class="p-2">
                    <new-type></new-type>
                </li>

                <li class="p-2">
                    <div class="dropdown show">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Izberi tip
                        </a>
                      
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            @foreach ($types as $type)
                                <a class="dropdown-item" href="{{ route('admin-show-type', $type->id) }}">{{ $type->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>

@endsection
