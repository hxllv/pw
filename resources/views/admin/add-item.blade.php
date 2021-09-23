@extends('layouts.admin')

@section('scripts')

<script defer>

function extraImgPreview(fileNum) {
  const [file] = document.getElementById("extra-img-" + fileNum).files;

  try {
    $("#extra-img-" + fileNum + "-show").attr("src", URL.createObjectURL(file));
  } catch {
    $("#extra-img-" + fileNum + "-show").attr("src", "");
  }
}

function mainImgPreview() {
  const [file] = document.getElementById("main-img").files;

  try {
    $("#main-img-show").attr("src", URL.createObjectURL(file));
  } catch {
    $("#main-img-show").attr("src", "");
  }
}

</script>

@endsection
 
@section('content')

<div class="container">
    <a href="{{ route('admin-index') }}">Nazaj na admin page</a>

    <div style="opacity: 1;">
        <form method="post" action="@if(isset($item)) {{ route('admin-update-item', $item->id) }} @else {{ route('admin-store-item') }} @endif" enctype="multipart/form-data">
            @csrf
            @if(isset($item))
            @method('patch')
            @endif
            <div class="form-group">
                <label for="title">Naslov:</label>
                <input id="title" class="form-control @error('title') is-invalid @enderror" name="title" type="text" maxlength="100" @if(isset($item)) value="{{ $item->title }}" @endif required/>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Opis:</label>
                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>@if(isset($item)){{ $item->description }}@endif</textarea>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Tip izdelka:</label>
                <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" required>
                    @foreach ($types as $type)
                        <option @if(isset($item) && $item->type_id === $type->id) selected  @endif value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>

                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Cena:</label>
                <input id="price" class="form-control @error('price') is-invalid @enderror" name="price" type="text" @if(isset($item)) value="{{ $item->price }}" @endif required/>

                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="main-img">Glavna slika:</label><br>
                <input id="main-img" class="form-control-file @error('main-img') is-invalid @enderror" name="main-img" type="file" accept="image/png, image/jpeg, image/webp" onchange="mainImgPreview()" @if(!isset($item)) required @endif/>

                <div class="w-50">
                    <img id="main-img-show" class="w-100"  @if(isset($item)) src="/storage/{{ $item->main_image }}" @endif>   
                </div>

                @error('main-img')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Dodatne slike:</label>

                @for($i = 1; $i <= 6; $i++)

                @if(isset($imgs[$i-1]))
                <input name="extra-img-edit-{{ $i }}" type="hidden" value="{{ $imgs[$i-1]->id }}">
                @endif

                <input id="extra-img-{{ $i }}" class="form-control-file" name="extra-img-{{ $i }}" type="file" accept="image/png, image/jpeg" onchange="extraImgPreview({{ $i }})"/>
                <div class="w-50">
                    <img id="extra-img-{{ $i }}-show" class="w-100" @if(isset($imgs[$i-1])) src="/storage/{{ $imgs[$i-1]->image }}" @endif>   
                </div>

                @endfor
            </div>

            <input class="btn btn-success" type="submit" value="@if(isset($item)) Spremeni @else Dodaj @endif"/>
        </form>
    </div>
</div>

@endsection