<!DOCTYPE html>
@php
    /**
     * @var \Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice $invoice
     * @var \Kirago\BusinessCore\Modules\OrganizationManagement\Models\Organization $organization
     */
      $organization = $invoice->getOrganization();

        $currency = $organization->getSettingOf(\Kirago\BusinessCore\Support\Constants\SettingsKeys::AMOUNT_CURRENCY->value);
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

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$filename ?? 'Invoice'}}</title>
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

        @media print {

            table,
            table tr,
            table tr td,
            table tbody,
            table thead,
            table tfoot,
            span,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            p,
            div {
                page-break-inside: avoid;
                page-break-after: avoid;
                page-break-before: avoid;
            }
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        tbody {
            width: 100%;
            display: table;
        }

        tr {
            width: 100%;
        }

        th,
        td {
            padding: 0;
        }

        ul {
            width: 100%;
            margin: 0;
            padding: 0;
            display: table;
        }

        ul li {
            list-style: none;
        }

        .space-5 {
            width: 100%;
            height: 5px;
            display: table;
        }

        .user-infos {
            vertical-align: top;
        }

        .user-infos td ul li,
        .user-infos td p,
        .invoice-hader td ul li {
            color: #090222;
            font-family: 'Greycliff CF Regular', sans-serif;
            font-size: 10px;
            line-height: 14px;
        }
        .user-infos td p{
            line-height: 5px;
        }

        .invoice-table thead tr th {
            color: #4B5563;
            font-size: 12px;
            line-height: 18px;
            padding: 7px 15px;
        }

        .invoice-subtotal tbody tr td {
            font-size: 11px;
            padding: 0 15px;
            line-height: 14px;
            font-size: 12px;
        }

        .invoice-subtotal tbody tr td ul {
            width: 100%;
        }

        .invoice-total tbody tr td ul,
        .invoice-subtotal tbody tr td ul {
            width: auto;
            margin: 5px 0;
        }

        .invoice-subtotal tbody tr td ul li {
            width: 112px;
            padding: 0 5px;
            float: left;
            font-family: 'Greycliff CF Bold', sans-serif;
        }

        .invoice-subtotal tbody tr td ul li:nth-child(2),
        .invoice-total tbody tr td ul li:nth-child(2) {
            text-align: right;
        }

        .invoice-subtotal tbody tr td table tr td {
            font-family: 'Greycliff CF Bold', sans-serif;
            font-size: 14px;
            line-height: 18px;
            color: #4B5563;
        }

        .invoice-total tbody tr td table tr td {
            color: #4B5563;
            font-size: 14px;
            line-height: 18px;
            font-family: 'Greycliff CF Bold', sans-serif;
        }

        .payment-list li {
            font-size: 8px;
            line-height: 12px;
            color: #6B7280;
        }
        .address-organization{
            margin: 8px 0 0 0;
        }
        .address-organization p{
            line-height: 10px;
            color: #000; font-size: 12px; font-family: 'Greycliff CF Regular', sans-serif;
        }
    </style>
</head>

<body>
<table cellspacing="0" cellpadding="0" border="0" style="min-height: 29.7cm; background-color: {{$templateInvoice->background_color}};">
    <tbody>
    <tr>
        <td>
            <table>
                <tbody style="background-color: {{$templateInvoice->header_color}};">
                <tr>
                    <td style="text-align: center; padding: 15px 36px;">
                        <div style=" text-align: center;">
                             <div>
                                 @if($logo1)
                                     <img src="data:image/webp;base64,{{ $logo1 }}"
                                          style="height: 100px"
                                          class="logo"
                                          alt="logo2">
                                 @else
                                     <span><strong>LOGO 1</strong></span>
                                 @endif
                                 @if($logo2)
                                     <img src="data:image/webp;base64,{{ $logo2 }}"
                                          style="height: 60px"
                                          class="logo"
                                          alt="logo2">
                                 @else
                                     <span><strong>LOGO 2</strong></span>
                                 @endif
                             </div>
                            <div class="address-organization">
                                <strong>{{ $organization->name }}</strong><br>
                                {{ $organization->phone }}<br>
                                {{ $organization->email }}
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <table>
                <tbody>
                <tr>
                    <td style="padding: 0 36px;">
                        <div style="width: 100%; height: 20px;"></div>
                    </td>
                </tr>
                <tr class="user-infos">
                    <td width="50%">
                        <ul>
                            <li style="color: #6B7280; text-decoration: underline;">
                                Contac :</li>
                        </ul>
                        {!! $templateInvoice->contact_details !!}
                    </td>
                    <td width="50%">
                        <ul>
                            <li style="color: #6B7280; text-decoration: underline;">
                                Adressé à :</li>
                        </ul>
                        <ul style="margin: 2px 0 0 0;">
                            <li>
                                {{$invoice->billing_firstname == "N/A" ? "" : $invoice->billing_firstname}} {{$order->billing_lastname  == "N/A" ? "" :  $order->billing_firstname}}
                            </li>
                        </ul>
                        <ul>
                            <li>{{$invoice->billing_address }}</li>
                        </ul>
                        <ul>
                            <li>{{$invoice->recipient->phone }}</li>
                        </ul>
                        <ul>
                            <li>{{$invoice->billing_email}}</li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <div style="width: 100%; height: 10px;"></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <div style="height: 1px; background-color: #0902221A;"></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <div style="width: 100%; height: 10px;"></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <table cellspacing="0" cellpadding="0">
                <tbody>
                <tr class="invoice-hader" style="vertical-align: top;">
                    <td width="50%">
                        <ul>
                            <li style="font-size: 12px; line-height: 16px;">N° de confirmation :
                                <span style="font-size: 12px; line-height: 16px; color: #6B7280;
                                font-family: 'Greycliff CF Bold', sans-serif;">
                                    {{ implode(",",$order->itemsBookings?->pluck("salesInvoiceable")?->pluck('code')->toArray()) }}
                                </span>
                            </li>
                        </ul>
                        <ul>
                            <li>Fait le : {{ format_date($order->created_at,"d/m/Y") }}</li>
                        </ul>
                        <ul>
                            <li>
                                Séjour {{"du {$order->itemsBookings?->pluck("salesInvoiceable")?->min('start_at')?->format("d/m/Y")}"}}
                                {{"au {$order->itemsBookings?->pluck("salesInvoiceable")?->max('end_at')?->format("d/m/Y")}"}}
                            </li>
                        </ul>
                    </td>
                    <td width="50%" style="text-align: right;">
                        <span style="color: #090222; font-size: 12px; line-height: 16px; font-family: 'Greycliff CF Bold', sans-serif;">
                            FACTURE N° {{ $order->code }}
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 36px; height: 12px;"></td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <table class="invoice-table" cellspacing="0" cellpadding="0">
                <thead style="background-color: {{$templateInvoice->section_color}};">
                <tr>
                    <th style="text-align: left; width: 100%;">Description</th>
                    <th style="text-align: left; min-width: 40px;">Q</th>
                    <th style="text-align: left; min-width: 100px;">Prix</th>
                    <th style="text-align: left; min-width: 100px;">Total</th>
                </tr>
                </thead>
                <tbody style="display: table-header-group;">
                    @foreach($order->items as $item)
                        <tr>
                            <td style="padding: 5px 0;"></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 15px">
                                @if($item->isBooking())
                                    {{ "{$item->salesInvoiceable->spot->name} #{$item->salesInvoiceable->spot->code}" }} |
                                    du {{ format_date($item->salesInvoiceable->start_at) }} au {{ format_date($item->salesInvoiceable->end_at) }} |
                                    <br>
                                    @if($item->salesInvoiceable->adults_count)
                                        <span> {{"x {$item->salesInvoiceable->adults_count} Adulte(s)"}}</span>
                                    @endif
                                    @if($item->salesInvoiceable->children_count)
                                        <span>, {{"x {$item->salesInvoiceable->children_count} Enfant(s)"}}</span>
                                    @endif
                                    @if($item->salesInvoiceable->pets_count)
                                        <span>, {{"x {$item->salesInvoiceable->pets_count} Animaux"}}</span>
                                    @endif
                                @else
                                    <span>{{filled($item->excerpt) ? $item->excerpt : "Autre Frais {$item->code}" }}</span>
                                @endif
                            </td>
                            <td style="padding: 10px 15px;">
                                {{ $item->quantity }}
                            </td>
                            <td style="padding: 10px 15px;">
                                {{ format_amount($item->unit_price,"$") }}
                            </td>
                            <td style="padding: 10px 15px;">
                                {{ format_amount($item->getItemTotalAmount() ,"$") }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="invoice-subtotal" cellspacing="0" cellpadding="0">

                <tr>
                    <td width="50%" style="padding: 7px 0;"></td>
                    <td width="50%" style="padding: 7px 0; text-align: right;">
                        <table>

                            <tr>
                                <td> Sous total :</td>
                                <td style="text-align: right;">
                                    {{ format_amount($order->getInvoiceSubTotalAmount(),"$") }}
                                </td>
                            </tr>

                             @if($order->getInvoiceTaxes()['details'])
                                @foreach($order->getInvoiceTaxes()['details'] as $taxe)
                                    @if($taxe['value'] > 0)
                                        <tr>
                                            <td style="height: 8px;"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {{ $taxe['name'] }}
                                                (
                                                    {{ $taxe['value'] }}
                                                    {{ ($taxe['type'] === \App\Models\Tax::TAX_CALCULATION_TYPE_PERCENTAGE) ? "%":"$" }}):
                                            </td>
                                            <td style="text-align: right;">
                                                {{ format_amount($taxe['amount'], "$") }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </table>
                    </td>
                </tr>
            </table>
            <table style="background-color: {{$templateInvoice->section_color}};" class="invoice-total">
                <tbody>
                <tr>
                    <td width="50%" style="padding: 5px 0;"></td>
                    <td width="50%" style="padding: 5px 0; text-align: right;">
                        <table>
                            <tbody style="display: table-header-group;">
                            <tr>
                                <td style="width: 100px; padding: 3px 15px;">
                                    Total :
                                </td>
                                <td style="width: 120px; padding: 3px 15px; text-align: right;">
                                    {{ format_amount($order->getInvoiceTotalAmount(), "$") }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="height: 12px; padding: 0 36px;"></td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <table cellspacing="0" cellpadding="0">
                <tbody>
                @if($order->getInvoiceTotalPaied() > 0)
                <tr>
                    <td style="color: #4B5563; font-size: 14px; line-height: 18px; font-family: 'Greycliff CF Regular', sans-serif;">
                        Montant déjà payé :
                    </td>
                    <td style="color: #F05252; text-align: right; font-size: 14px; line-height: 18px; font-family: 'Greycliff CF Medium', sans-serif;">
                        {{ format_amount($order->getInvoiceTotalPaied(),"$") }}
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="height: 5px;"></td>
                </tr>
                @if($order->getInvoiceTotalRemaining() > 0)
                    <tr>
                        <td style="color: #4B5563; font-size: 14px; line-height: 18px; font-family: 'Greycliff CF Bold', sans-serif;">
                            Solde à payer : </td>
                        <td style="color: #4B5563; text-align: right; font-size: 14px; line-height: 18px; font-family: 'Greycliff CF Bold', sans-serif;">
                            {{ format_amount($order->getInvoiceTotalRemaining(),"$") }}
                        </td>
                    </tr>
                @endif

                <tr>
                    <td style="height: 5px;"></td>
                </tr>
                <tr>
                    <td style="color: #4B5563; font-size: 14px; line-height: 18px; font-family: 'Greycliff CF Regular', sans-serif;">
                        Mode de paiement :</td>
                    <td style="color: #4B5563; text-align: right; font-size: 14px; line-height: 18px; font-family: 'Greycliff CF Medium', sans-serif;">
                        {{ $order->organization->card_number ?? "---" }}
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="height: 50px; padding: 0 36px;"></td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td style="padding: 0 36px;">
            <table cellspacing="0" cellpadding="0">
                <tbody>
                <tr style="vertical-align: bottom;">
                    <td>
                        <ul class="payment-list">
                            <li style="color: #4B5563; font-size: 11px; line-height: 14px; font-family: 'Greycliff CF Medium', sans-serif; margin-bottom: 3px;">
                                Paiement à
                                l'ordre de {{ $order->organization->name  }}
                            </li>
                            @if($order->getInvoiceTaxes()['details'])
                                {!! $templateInvoice->other_infos !!}
                            @endif
                        </ul>
                    </td>
                    <td style="text-align: right;">
                        <ul>
                            <li
                                    style="color: #4B5563; font-size: 11px; line-height: 14px; font-family: 'Greycliff CF Medium', sans-serif; margin-bottom: 3px;">
                                Condition de paiement</li>

                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 5px 36px;">
        </td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <div style="height: 1px; background-color: #4B5563;"></div>
        </td>
    </tr>
    <tr>
        <td style="padding: 5px 36px;">
        </td>
    </tr>
    <tr>
        <td style="padding: 0 36px;">
            <table class="footer">
                <tbody>
                <tr>
                    <td style="text-align: center;">
                        <ul>
                            <li style="color: #4B5563; font-size: 9px; line-height: 12px;">MERCI POUR VOTRE
                                CONFIANCE</li>
                            <li class="space-3"></li>
                            <li
                                    style="color: #4B5563; font-size: 9px; line-height: 12px; text-decoration: underline;">
                                Software By
                                Kampwise</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tfoot>
</table>
</body>

</html>
