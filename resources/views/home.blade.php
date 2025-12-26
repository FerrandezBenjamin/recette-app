@extends('layouts.app')

@section('content')

    <div class="container flex-center flex-col min-p">
        <div class="container-gg flexx" id="bvn">
            <h1></h1>
        </div>

        <div class="dishes gap-my-first">
            <div class="see-dishes btn-base-dish">
                <a href="{{route('display_all_dishes')}}">Voir les recettes</a>
            </div>
            <div class="create-dishes btn-base-dish">
                <a href="{{route('display_new_dish')}}">Créer une recette</a>
            </div>
        </div>
    </div>
@endsection
