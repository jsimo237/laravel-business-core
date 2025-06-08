<!DOCTYPE html>
@php
    /**
     * @var \Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice $invoice
     * @var \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization $organization
     */
    $organization = $invoice->getOrganization();
    $currency = "FCFA";

    $logo1 = $organization->getSettingOf(\Kirago\BusinessCore\Support\Constants\SettingsKeys::LOGOS->value)['LOGO_1'];
    $logo2 = $organization->getSettingOf(\Kirago\BusinessCore\Support\Constants\SettingsKeys::LOGOS->value)['LIGHT'];
    try {
        $logo1 = base64_encode(file_get_contents($logo1));
    } catch (\Throwable $e) {
        $logo1 = "";
    }
    try {
        $logo2 = base64_encode(file_get_contents($logo2));
    } catch (\Throwable $e) {
        $logo2 = "";
    }
@endphp
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $invoice->code }}</title>
    <style>
        @font-face {
            font-family: "Greycliff CF Light";
            src: local("Greycliff CF"), url("{{ asset("/fonts/Greycliff-CF-Light.woff") }}") format("woff");
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Greycliff CF Regular";
            src: local("Greycliff CF"), url("{{ asset("/fonts/Greycliff-CF-Regular.woff") }}") format("woff");
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Greycliff CF Medium";
            src: local("Greycliff CF"), url("{{ asset("/fonts/Greycliff-CF-Medium.woff") }}") format("woff");
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: "Greycliff CF Bold";
            src: local("Greycliff CF"), url("{{ asset("/fonts/Greycliff-CF-Bold.woff") }}") format("woff");
            font-style: normal;
            font-display: swap;
        }

        @page {
            size: A4;
            margin: 0 !important;
        }

        body {
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: "Greycliff CF Regular", sans-serif;
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header .left, .header .center, .header .right {
            flex: 1;
        }

        .left {
            text-align: left;
        }

        .center {
            text-align: center;
            font-size: 13px;
            color: #555;
        }

        .right {
            text-align: right;
        }

        .logo {
            height: 60px;
        }

        h1.title {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 10px;
            color: #2c3e50;
        }

        .meta {
            text-align: center;
            margin-bottom: 30px;
            color: #888;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th {
            background-color: #f4f6f8;
            color: #2c3e50;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .totals td {
            text-align: right;
        }

        .totals tr:last-child td {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="left">
        @if($logo1)
            <img src="data:image/webp;base64,{{ $logo1 }}" class="logo" alt="logo1">
        @else
            <span><strong>LOGO 1</strong></span>
        @endif
    </div>

    <div class="center">
        @if($organization)
            <strong>{{ $organization->name }}</strong><br>
            {{ $organization->phone }}<br>
            {{ $organization->email }}
        @else
            Informations de l'organisation non disponibles.
        @endif
    </div>

    <div class="right">
        @if($logo2)
            <img src="data:image/webp;base64,{{ $logo2 }}" class="logo" alt="logo2">
        @else
            <span><strong>LOGO 2</strong></span>
        @endif
    </div>
</div>

<h1 class="title">Facture</h1>

<div class="meta">
    <p><strong>Référence :</strong> {{ $invoice->code }} | <strong>Date :</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>
</div>

<table>
    <tr>
        <td><strong>Client :</strong> {{ $invoice->recipient?->fullname ?? 'N/A' }}</td>
        <td><strong>Email :</strong> {{ $invoice->recipient?->email ?? 'N/A' }}</td>
        <td><strong>Téléphone :</strong> {{ $invoice->recipient?->phone ?? 'N/A' }}</td>
    </tr>
</table>

<table>
    <thead>
    <tr>
        <th>Désignation</th>
        <th>Quantité</th>
        <th>Prix Unitaire</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($invoice->items as $item)
        <tr>
            <td style="padding: 10px 15px">
                @if($item->invoiceable instanceof \App\Models\ProfilesManagement\MemberShip )
                    Frais d'adhésion <strong>{{$item->invoiceable->reference}}</strong> pour la période
                    du {{ format_date($item->invoiceable->start_at) }} au {{ format_date($item->invoiceable->start_at) }}
                    <br>
                @else
                    <span>{{filled($item->note) ? $item->note : "Item {$item->code}" }}</span>
                @endif
            </td>
            <td style="padding: 10px 15px;">

                @if($item->invoiceable instanceof \App\Models\ProfilesManagement\MemberShip )
                    <strong style="color: #de3232"> {{$item->invoiceable->getDurationLabel()}}</strong>
                @else
                    {{ $item->quantity }}
                @endif
            </td>
            <td style="padding: 10px 15px;">
                {{ format_amount($item->unit_price,$currency," ") }}
            </td>
            <td style="padding: 10px 15px;">
                {{ format_amount($item->getItemSubTotalAmount() ,$currency," ") }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="totals">
    <tr>
        <td><strong>Sous-total</strong></td>
        <td>{{ number_format($invoice->getSubTotalAmount(), 0, ',', ' ') }} FCFA</td>
    </tr>
    <tr>
        <td><strong>Taxes</strong></td>
        <td>{{ number_format($invoice->getTaxes()['total'] ?? 0, 0, ',', ' ') }} FCFA</td>
    </tr>
    <tr>
        <td><strong>Total</strong></td>
        <td>{{ number_format($invoice->getTotalAmount(), 0, ',', ' ') }} FCFA</td>
    </tr>
    <tr>
        <td><strong>Montant payé</strong></td>
        <td>{{ number_format($invoice->getTotalPaid(), 0, ',', ' ') }} FCFA</td>
    </tr>
    <tr>
        <td><strong>Reste à payer</strong></td>
        <td>{{ number_format($invoice->getTotalRemaining(), 0, ',', ' ') }} FCFA</td>
    </tr>
</table>

<div class="footer">
    Merci pour votre confiance. Si vous avez des questions concernant cette facture, n'hésitez pas à nous contacter.
</div>
</body>
</html>
