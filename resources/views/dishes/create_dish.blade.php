@extends('layouts.app')

@section('content')

    <div class="margin-b">
        <div class="see-dishes btn-base">
            <a href="{{ route('display_all_dishes') }}">Voir les recettes</a>
        </div>
        <h1>Créer une recette</h1>
    </div>

    <div class="container flex-center flex-col">

        <div class="container flex-center">

            <form action="{{ route('rec_dish') }}" method="POST" enctype="multipart/form-data" class="form-base">
                @csrf

                <div>
                    <label for="name">Nom de la recette</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Ma recette de carotte..">
                </div>

                <div>
                    <label for="description">La recette * <em class="maxs">(2048 caractères maximum)</em></label>
                    <textarea id="description" name="description" class="form-control" placeholder="3 Oeufs..." maxlength="2048"></textarea>
                </div>

                <div>
                    <label for="image">Image du plat</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn-base">Enregistrer</button>
            </form>

        </div>
    </div>

@endsection
