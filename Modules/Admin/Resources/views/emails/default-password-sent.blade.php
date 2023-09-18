@component('mail::message')

Bienvenue {{ $fullname }}!

Votre compte est prêt, vous pouvez dès à présent accéder à la plateforme Patrimoine passage.
Votre mot de passe temporaire est
<code style="color: rgb(27, 27, 214); background-color: rgb(223, 213, 213);padding: 2 4">{{ $password }}</code>

@endcomponent
