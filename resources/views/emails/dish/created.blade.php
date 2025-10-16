<x-mail::message>
Bonjour {{ Auth::user()->getFullName() }},

Votre recette **{{ $dish->getNameDish() }}** est maintenant disponible.

<x-mail::button :url="''">
Acceder à la recette
</x-mail::button>

En vous remerciant,<br>
{{ config('app.name') }}
</x-mail::message>
