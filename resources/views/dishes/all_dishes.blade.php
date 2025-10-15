@extends('layouts.app')

@section('content')

    <div class="margin-b">
        <div class="create-dishes btn-base">
            <a href="{{route('display_new_dish')}}">Je veux créer une recette</a>
        </div>
        <h1>Toute les recettes</h1>
    </div>

    <div class="flex-center flex-col">
        <div class="cards-row">

            @if($allDishes->count() > 0)
                @foreach($allDishes as $d)
                
                    <div class="dish">
                        <span class="spanheart"><i class="fa-solid fa-heart colormyheart"></i></span>
                        <div class="title-dish">
                            <h3>{{ $d->getNameDish()}}</h3>
                            <img src="{{ asset('images/' . $d->getPathDish()) }}" alt="Echec">
                            <span class="span_createur">Créateur : {{ $d->getCreateur()}} </span>
                        </div>

                        <div class="descri-dish">
                            <p> <strong>Recette</strong> <br> {{ $d->getDescriptionDish()}}</p>
                        </div>

                        <div class="delete-dish">
                            <form action="{{route('delete_dish')}}" method="POST">
                                @csrf

                                <input type="hidden" value="{{$d->getDishId()}}" name="id_dish">

                                <button type="submit" class="btn-delete">Supprimer</button>
                            </form>
                        </div>
                    </div>

                @endforeach
            @else

                <h2>Aucune recette enregistrée pour le moment..</h2>

            @endif
        </div>
    </div>
@endsection
