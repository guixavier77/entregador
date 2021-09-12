@component('mail::message')
    <h1>Recuperar acesso ao sistema</h1>

    Olá {{ $user->name }}, Para continuar usando o sistema clique no botão abaixo!

@component('mail::button', ['url' => route('authCredentials', ['email' => $user->email, 'token' => $user->remember_token])])
    Recuperar
@endcomponent
@endcomponent
