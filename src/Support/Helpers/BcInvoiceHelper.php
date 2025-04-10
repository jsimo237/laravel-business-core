<?php

namespace Kirago\BusinessCore\Support\Helpers;

use Carbon\Carbon;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\BaseOrderContract;
use Kirago\BusinessCore\Modules\SalesManagement\Contrats\RecipientInteractWithOrderAndInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Support\Constants\BcBillingInformations;
use Kirago\BusinessCore\Support\Constants\BcInvoiceStatuses;
use Kirago\BusinessCore\Support\Constants\BcInvoiceType;
use Kirago\BusinessCore\Support\Constants\BcOrderStatuses;

final class BcInvoiceHelper
{

    public static function generateInvoiceForOrder(BaseOrderContract $order): BcInvoice
    {
        $invoice = $order->invoice ?? new BcInvoice();

        $recipient = $order->recipient;

        $invoice->status = BcInvoiceStatuses::VALIDATED->value;
        $invoice->billing_entity_type = BcBillingInformations::TYPE_INDIVIDUAL->value;
        $invoice->expired_at = $order->expired_at ?? Carbon::now()->addDays(30);
        $invoice->discounts = $order->discounts ?? [];

        $invoice->billing_company_name    = $order->billing_company_name ?? "N/A";
        $invoice->billing_firstname       = $order->billing_firstname ?? "N/A";
        $invoice->billing_lastname        = $order->billing_lastname ?? "N/A";
        $invoice->billing_country         = $order->billing_country ?? "N/A";
        $invoice->billing_state           = $order->billing_state ?? "N/A";
        $invoice->billing_city            = $order->billing_city ?? "N/A";
        $invoice->billing_zipcode         = $order->billing_zipcode ?? "N/A";
        $invoice->billing_address         = $order->billing_address ?? "N/A";
        $invoice->billing_email           = $order->billing_email ?? "N/A";

        $invoice->order()->associate($order);
        $invoice->recipient()->associate($recipient);
        $invoice->organization()->associate($order->organization);
        $invoice->save();

        $order->status = BcOrderStatuses::VALIDATED;
        $order->save();


        return $invoice;
    }

}