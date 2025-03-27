<?php

namespace Kirago\BusinessCore\Support\Helpers;

use Carbon\Carbon;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Support\Constants\BcInvoiceStatuses;
use Kirago\BusinessCore\Support\Constants\BcInvoiceType;

final class BcInvoiceHelper
{

    public static function generateInvoiceForOrder(BcOrder $order): BcInvoice
    {
       // $exist = $order->invoice()->where('status', InvoiceStatuses::VALIDATED->value)->exists();
        //if (!$exist) {
       //     $invoice = new BcInvoice();
      //  }
        $invoice = new BcInvoice();

        $invoice->status = BcInvoiceStatuses::VALIDATED->value;
        $invoice->invoice_type = BcInvoiceType::PRODUCT->value;
        $invoice->expired_at = Carbon::now()->addDays(30);
        $invoice->discounts = $order->discounts;

        $invoice->billing_company_name    = $order->billing_company_name;
        $invoice->billing_firstname       = $order->billing_firstname;
        $invoice->billing_lastname        = $order->billing_lastname;
        $invoice->billing_country         = $order->billing_country;
        $invoice->billing_state           = $order->billing_state;
        $invoice->billing_city            = $order->billing_city;
        $invoice->billing_zipcode         = $order->billing_zipcode;
        $invoice->billing_address         = $order->billing_address;
        $invoice->billing_email           = $order->billing_email;
        $invoice->organization()->associate($order->organization);
        $invoice->order()->associate($order);
        $invoice->recipient()->associate($order->recipient);
        $invoice->save();

        return $invoice;
    }

}