@extends('layouts.admin')

@section('scripts')

@endsection

@section('content')

<div class="container">
    <a href="{{ route('admin-index') }}">Nazaj na admin page</a>

    <div style="opacity: 1;">
        <ul>
            <li class="mb-5">
                <form class="form-inline" method="post" action="{{ route('admin-update-type', $type->id) }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <input class="@error('name') is-invalid @enderror" type="text" name="name" placeholder="Novo ime tipa" required/>

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group ml-2">
                        <input class="btn btn-success" type="submit" value="Spremeni"/>
                    </div>
                </form>
            </li>
            <li>
                <form method="post" action="{{ route('admin-destroy-type', $type->id) }}">
                    @csrf
                    @method('delete')
                    <input class="btn btn-danger" type="submit" value="Zbriši"/>
                    <b>Pri brisanju tipa se izbrišejo vsi z njem povezani izdelki in slike teh izdelkov!</b>
                </form>
            </li>
        </ul>
        
    </div>
</div>

@endsection