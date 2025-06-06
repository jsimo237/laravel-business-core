<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Helpers;

use Carbon\Carbon;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BcBillingInformations;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BcInvoiceStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BcOrderStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\BaseOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BaseBcOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;

final class BcInvoiceHelper
{

    public static function generateInvoiceForOrder(BaseOrder|BaseBcOrder $order): BcInvoice
    {
        $invoice = $order->invoice ?? new BcInvoice();

        $recipient = $order->recipient;

        $invoice->status = BcInvoiceStatuses::VALIDATED->value;
        $invoice->billing_entity_type = BcBillingInformations::TYPE_INDIVIDUAL->value;
        $invoice->expired_at = $order->expired_at ?? Carbon::now()->addDays(60);
        $invoice->discounts = $order->discounts ?? [];

        $invoice->billing_company_name    = $order->billing_company_name ?? "---";
        $invoice->billing_firstname       = $order->billing_firstname ?? "---";
        $invoice->billing_lastname        = $order->billing_lastname ?? "---";
        $invoice->billing_country         = $order->billing_country ?? "---";
        $invoice->billing_state           = $order->billing_state ?? "---";
        $invoice->billing_city            = $order->billing_city ?? "---";
        $invoice->billing_zipcode         = $order->billing_zipcode ?? "---";
        $invoice->billing_address         = $order->billing_address ?? "---";
        $invoice->billing_email           = $order->billing_email ?? "---";

        $invoice->order()->associate($order);
        $invoice->recipient()->associate($recipient);
        $invoice->organization()->associate($order->organization);
        $invoice->save();

        $order->status = BcOrderStatuses::VALIDATED;
        $order->save();

        return $invoice;
    }

}