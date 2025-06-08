<?php

namespace Kirago\BusinessCore\Modules\SalesManagement\Helpers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\OrderStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\PaymentSource;
use Kirago\BusinessCore\Modules\SalesManagement\Constants\PaymentStatuses;
use Kirago\BusinessCore\Modules\SalesManagement\Interfaces\Orderable;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Invoice;
use Kirago\BusinessCore\Modules\SalesManagement\Models\InvoiceItem;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Order;
use Kirago\BusinessCore\Modules\SalesManagement\Models\Payment;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Constants\SubscriptionStatuses;
use Kirago\BusinessCore\Modules\SubscriptionsManagement\Models\Subscription;
use function Kirago\BusinessCore\Support\Helpers\now;

final class OrderHelper
{

    public static function checkout(Order $order, array $paymentData): ?Invoice
    {
        /**
         * @var Payment $payment
         */
        $payment = Payment::firstWhere([
                        "source_code" => $paymentData['source'],
                        "source_reference" => $paymentData['source_reference'],
                        "organization_id" => $order->organization_id,
                    ]);

        if (!$payment){
            $payment = new Payment();
        }

       $organization = $order->organization;

        $payment->amount = $paymentData['amount'] ?? $order->getTotalAmount();
        $payment->status = $paymentData['status'] ?? PaymentStatuses::DRAFT->value;
        $payment->source_code = $paymentData['source'] ?? PaymentSource::UNKNOWN->value;
        $payment->source_reference = $paymentData['source_reference'] ?? null;
        $payment->source_response = $paymentData['source_response'] ?? null;
        $payment->category = $paymentData['category'] ?? $paymentData['boundary']  ?? null;
        $payment->method = $paymentData['method'] ?? null;
        $payment->paid_at = now();
        $payment->note = $paymentData['note'] ?? null ;

        $payment->organization()->associate($order->organization);
        $payment->save();
        $payment->refresh();

        if ($payment->status === PaymentStatuses::VALIDATED->value){
            $invoice = self::generateInvoice($order);


            if ($invoiceItems = $invoice->items){
                foreach ($invoiceItems as $invoiceItem) {

                    $invoiceable = $invoiceItem->invoiceable;
                    if ($invoiceable instanceof Subscription){

                        if (  $invoiceable->status = SubscriptionStatuses::INITIATED->value){
                                $invoiceable->status = SubscriptionStatuses::COMPLETED->value;
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

    public static function generateInvoice(Order $order) : Invoice{

        $invoice = InvoiceHelper::generateInvoiceForOrder($order);

        if ($orderItems = $order->items){

            foreach ($orderItems as $orderItem) {

                $invoiceItem = InvoiceItem::firstWhere('code',$orderItem->code);
                $invoiceItem ??= new InvoiceItem();

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
            $order->status = OrderStatuses::VALIDATED;
            $order->save();
        }

        $invoice->refresh();
        $order->refresh();

        return $invoice;
    }
}
