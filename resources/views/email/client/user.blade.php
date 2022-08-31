@component('mail::message')
# Compte Créé
Votre compte a été créé avec succès

@component('mail::panel')
Votre mot de passe est {{ $password }}
@endcomponent

Merci pour votre confiance accordée,<br>
NETFORCE GROUP
@endcomponent
