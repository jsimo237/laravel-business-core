@component('mail::message',["organization" => $otp->getOrganization(), "styleMail" => []])
# 🔐 Vérification de sécurité

Bonjour,

Votre code de vérification est :<br>
<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto; background-color: #f1f5f9; border-left: 4px solid #0d6efd; border-radius: 6px; padding: 12px 24px;">
                <tr>
                    <td style="font-size: 22px; font-weight: bold; letter-spacing: 2px; font-family: monospace; text-align: center;">
                        {{ $otp->code }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


{{--<x-otp-code-render :otp="$otp"  />--}}

Ce code est valide pendant **{{ number_format(abs($otp->expired_at->diffInMinutes(now()))) }} minute(s)**.

Si vous n’avez pas fait cette demande, vous pouvez ignorer ce message.

Merci,
@endcomponent
