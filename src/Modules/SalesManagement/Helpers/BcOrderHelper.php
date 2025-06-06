<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Helpers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BcOrderStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BcPaymentSource;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\BcPaymentStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Orderable;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcInvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcOrder;
use Kirago\BusinessCore\Modules\SalesManagement\Models\BcPayment;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Constants\BcSubscriptionStatuses;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\BcSubscription;
use function Kirago\BusinessCore\Support\Helpers\now;

final class BcOrderHelper
{

    public static function checkout(BcOrder $order, array $paymentData): ?BcInvoice
    {
        /**
         * @var BcPayment $payment
         */
        $payment = BcPayment::firstWhere([
                        "source_code" => $paymentData['source'],
                        "source_reference" => $paymentData['source_reference'],
                        "organization_id" => $order->organization_id,
                    ]);

        if (!$payment){
            $payment = new BcPayment();
        }

       $organization = $order->organization;

        $payment->amount = $paymentData['amount'] ?? $order->getTotalAmount();
        $payment->status = $paymentData['status'] ?? BcPaymentStatuses::DRAFT->value;
        $payment->source_code = $paymentData['source'] ?? BcPaymentSource::UNKNOWN->value;
        $payment->source_reference = $paymentData['source_reference'] ?? null;
        $payment->source_response = $paymentData['source_response'] ?? null;
        $payment->category = $paymentData['category'] ?? $paymentData['boundary']  ?? null;
        $payment->method = $paymentData['method'] ?? null;
        $payment->paid_at = now();
        $payment->note = $paymentData['note'] ?? null ;

        $payment->organization()->associate($order->organization);
        $payment->save();
        $payment->refresh();

        if ($payment->status === BcPaymentStatuses::VALIDATED->value){
            $invoice = self::generateInvoice($order);


            if ($invoiceItems = $invoice->items){
                foreach ($invoiceItems as $invoiceItem) {

                    $invoiceable = $invoiceItem->invoiceable;
                    if ($invoiceable instanceof BcSubscription){

                        if (  $invoiceable->status = BcSubscriptionStatuses::INITIATED->value){
                                $invoiceable->status = BcSubscriptionStatuses::COMPLETED->value;
                                $invoiceable->start_at = now();
                                $invoiceable->active = true;
                                $invoiceable->end_at = Carbon::parse()->addDays($invoiceable->package->count_days);
                                $invoiceable->completed_at = now();
                                $invoiceable->save();
                                $invoiceable->refresh();
                        }
                    }
                }
            }

            $payment->invoice()->associate($order->invoice);
            $payment->save();
            $payment->refresh();
        }

      return  $order->invoice;

    }

    public static function generateInvoice(BcOrder $order) : BcInvoice{

        $invoice = BcInvoiceHelper::generateInvoiceForOrder($order);

        if ($orderItems = $order->items){

            foreach ($orderItems as $orderItem) {

                $invoiceItem = BcInvoiceItem::firstWhere('code',$orderItem->code);
                $invoiceItem ??= new BcInvoiceItem();

                /**
                 * @var Orderable|Model $orderable
                 */
                $orderable = $orderItem->orderable;

                $invoiceItem->code = $orderItem->code;
                $invoiceItem->note = $orderItem->note;
                $invoiceItem->unit_price = $orderItem->unit_price;
                $invoiceItem->quantity = $orderItem->quantity;
                $invoiceItem->discount = $orderItem->discount;
                $invoiceItem->taxes = $orderItem->taxes;
                $invoiceItem->invoice()->associate($invoice);
                $invoiceItem->invoiceable()->associate($orderable);
                $invoiceItem->save();
            }
            $order->status = BcOrderStatuses::VALIDATED;
            $order->save();
        }

        $invoice->refresh();
        $order->refresh();

        return $invoice;
    }
}
