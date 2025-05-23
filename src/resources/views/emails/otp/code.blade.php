@component('mail::message',["organization" => $otp->getOrganization(), "styleMail" => []])
# 🔐 Vérification de sécurité

Bonjour,

Votre code de vérification est :

<x-otp-code-render :otp="$otp"  />

Ce code est valide pendant **{{ $otp->expired_at->diffInMinutes(now()) }} minute(s)**.

Si vous n’avez pas fait cette demande, vous pouvez ignorer ce message.

Merci,
@endcomponent
