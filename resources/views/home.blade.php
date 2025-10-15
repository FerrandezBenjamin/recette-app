@extends('layouts.app')

@section('content')

    <div class="container flex-center flex-col">
        <h1>Bienvenue</h1>
        <div class="dishes flex-arround gap-my-first">

            <div class="see-dishes btn-base">
                <a href="{{route('display_all_dishes')}}">Voir les recettes</a>
            </div>
            <div class="create-dishes btn-base">
                <a href="{{route('display_new_dish')}}">Créer une recette</a>
            </div>

        </div>
    </div>
@endsection
