@extends('layouts.app')

@section('content')

<div class="pre-top">
    <a href="{{ route('display_new_dish') }}" class="create-dishes btn-base create-r">Créer une recette</a>
    <a href="{{ url('/home') }}" class="create-dishes btn-base create-r">Menu principal</a>
</div>

<div class="card-top">
    {{-- <h1>Toute les recettes</h1> --}}

    <form action="{{ route('generate_dishes') }}" method="GET" class="inline-form">
        <input type="number" name="count" class="form-control" min="1" max="100" value="10">
        <button type="submit" class="create-dishes btn-base create-r">Générer des recettes</button>
    </form>
    
</div>


<div class="flex-center flex-col">
    @if($allDishes->count() >0 )
        <div class="cards-row">
        @foreach($allDishes as $d)
            <div class="dish">
                <div class="dish-actions">
                    <button class="spanheart favorite-btn" data-id="{{ $d->getDishId() }}" type="button">
                        @php
                            $isFav = auth()->check() && auth()->user()->favoriteDishes->contains('dish_id', $d->getDishId());
                        @endphp
                        <i class="fa-solid fa-heart {{ $isFav ? 'colormyheartwasfav' : 'colormyheart' }}"></i>
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
        {{ $allDishes->links() }}
    @else
        <h2>Aucune recette trouvée pour le moment !</h2>
    @endif
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
                body: JSON.stringify({})
            })
            .then(res => {
                return res.json().then(data => ({ status: res.status, body: data }));
            })
            .then(({ status, body }) => {
                if (status === 200) {
                    icon.classList.add('colormyheartwasfav');
                    icon.classList.remove('colormyheart');
                } else if (status === 201) {
                    icon.classList.add('colormyheart');
                    icon.classList.remove('colormyheartwasfav');
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