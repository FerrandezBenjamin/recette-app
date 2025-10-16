@extends('layouts.app')

@section('content')

    <div class="margin-b">
        <div class="see-dishes btn-base">
            <a href="{{ route('display_all_dishes') }}">Voir les recettes</a>
        </div>
        <h1>Modification de la recette</h1>
    </div>

    <div class="container flex-center flex-col">

        <div class="container flex-center">

            <form action="{{ route('edit_dish') }}" method="POST" enctype="multipart/form-data" class="form-base">
                @csrf
                <input type="hidden" name="id_dish" value="{{$dishWas->getDishId()}}">

                <div>
                    <label for="name">Nom de la recette</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{$dishWas->getNameDish()}}" placeholder="Ma recette de carotte..">
                </div>

                <div>
                    <label for="description">La recette * <em class="maxs">(2048 caractères maximum)</em></label>
                    <textarea id="description" name="description" class="form-control" placeholder="3 Oeufs..." maxlength="2048" value="{{$dishWas->getDescriptionDish()}}"></textarea>
                </div>

                <div class="place-img">
                    <label for="image">L'image du plat</label>
                    <img src="{{ asset('images/' . $dishWas->getPathDish()) }}" id="image" alt="Echec">
                </div>

                <button type="submit" class="btn-base">Modifier</button>
            </form>

        </div>
    </div>

@endsection
