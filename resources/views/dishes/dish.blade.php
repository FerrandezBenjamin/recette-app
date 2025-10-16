@extends('layouts.app')

@section('content')

    <div class="header-dishes">
                <h1>{{$dishWas->getNameDish() }}</h1>
        <div class="see-dishes">
            <div class="btn-base">
                <a href="{{ route('display_new_dish') }}">Créer une recette</a>
            </div>

            <div class="btn-base">
                <a href="{{ route('display_all_dishes') }}">Voir les recettes</a>
            </div>
        </div>

    </div>

    <div class="container flex-center flex-col force-p-disabled">

        <div class="container flex-center force-p-disabled">

            @can('creation plat')
                <form action="{{ route('edit_dish') }}" method="POST" enctype="multipart/form-data" class="form-base">
                    @csrf
                    <input type="hidden" name="id_dish" value="{{ $dishWas->getDishId() }}">

                    <div>
                        <label for="name">Nom de la recette</label>
                        <input type="text" id="name" name="name" class="form-control"
                               value="{{ $dishWas->getNameDish() }}" placeholder="Ma recette de carotte..">
                    </div>


                    <div class="place-img">
                        <img src="{{ asset('images/' . $dishWas->getPathDish()) }}" id="image" alt="Echec">
                    </div>

                    <div>
                        <label for="description">La recette * <em class="maxs">(2048 caractères maximum)</em></label>
                        <textarea id="description" name="description" class="form-control" maxlength="2048">{{ $dishWas->getDescriptionDish() }}</textarea>
                    </div>



                    <button type="submit" class="btn-base">Modifier</button>
                </form>
            @else
                <div class="form-base readonly">

                    <div>
                        <label>Nom de la recette</label>
                        <input type="text" readonly value="{{ $dishWas->getNameDish() }}" class="form-control">
                    </div>

                    <div class="place-img">
                        <img src="{{ asset('images/' . $dishWas->getPathDish()) }}" alt="Echec">
                    </div>
  

                    <div>
                        <label>La recette</label>
                        <textarea readonly class="form-control">{{ $dishWas->getDescriptionDish() }}</textarea>
                    </div>


                </div>
            @endcan

        </div>
    </div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('textarea').forEach(textarea => {
        function autoResize() {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }
        autoResize();
        textarea.addEventListener('input', autoResize);
    });
});
</script>

