@extends('layouts.app')

@section('content')

<div class="margin-b">
    <div class="create-dishes btn-base">
        <a href="{{ route('display_new_dish') }}">Je veux créer une recette</a>
    </div>
    <h1>Toute les recettes</h1>
</div>

<div class="flex-center flex-col">
    <div class="cards-row">
    @foreach($allDishes as $d)
        <div class="dish">
            <div class="dish-actions">
                <button class="spanheart favorite-btn" data-id="{{ $d->getDishId() }}" type="button">
                    @php
                        $isFav = auth()->check() && auth()->user()->favoriteDishes->contains('dish_id', $d->getDishId());
                    @endphp
                    <i class="fa-solid fa-heart {{ $isFav ? 'colormyheart' : 'colormyheartwasfav' }}"></i>
                </button>
            </div>

            <a href="{{ route('dish', ['id' => $d->getDishId()]) }}" class="dish-link">
                <div class="title-dish">
                    <h3>{{ $d->getNameDish() }}</h3>
                    <img src="{{ asset('images/' . $d->getPathDish()) }}" alt="Echec">
                    <span class="span_createur">Créateur : {{ $d->getCreateur() }}</span>
                </div>

                <div class="descri-dish">
                    <p><strong>Recette</strong><br>{{ $d->getDescriptionDish() }}</p>
                </div>
            </a>

            <div class="delete-dish">
                <form action="{{ route('delete_dish') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $d->getDishId() }}" name="id_dish">
                    <button type="submit" class="btn-delete">Supprimer</button>
                </form>
            </div>
        </div>
    @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
        e.stopPropagation();
        e.preventDefault();

        const dishId = this.dataset.id;
        const icon = this.querySelector('i');

        fetch(`/plat/${dishId}/favorite`, {
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
            },
            body: JSON.stringify({}) // corps vide si besoin
        })
        .then(res => {
            // debug réseau si problème
            // console.log('status', res.status);
            return res.json().then(data => ({ status: res.status, body: data }));
        })
        .then(({ status, body }) => {
            if (status === 200) {
            // 200 = ajouté aux favoris (ajuster si ton contrôleur fait l'inverse)
            icon.classList.add('colormyheart');
            icon.classList.remove('colormyheartwasfav');
            } else if (status === 201) {
            // 201 = retiré des favoris
            icon.classList.add('colormyheartwasfav');
            icon.classList.remove('colormyheart');
            } else {
            console.warn('Unexpected status', status, body);
            }
        })
        .catch(err => {
            console.error('Fetch error', err);
        });
        });
    });
});

</script>

@endsection