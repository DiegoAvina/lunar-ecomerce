<?php

namespace App\Services\Shipping;

use App\Data\Shipping\ShippingEstimateData;
use Carbon\Carbon;

class ShippingEstimateService
{
    public function estimate(
        ?string $postalCode = null,
        float $cartTotal = 0
    ): ShippingEstimateData {

        $processing = now()->addDays(
            config('shipping.processing_days')
        );

        $from = $processing->copy()->addDays(
            config('shipping.delivery.min_days')
        );

        $to = $processing->copy()->addDays(
            config('shipping.delivery.max_days')
        );

        $freeShipping = $cartTotal >= config('shipping.free_shipping_from');

        $shippingCost = $freeShipping ? 0 : 149;

        return new ShippingEstimateData(

            postalCode: $postalCode ?? 'Sin definir',

            processingDate: $processing,

            from: $from,

            to: $to,

            freeShipping: $freeShipping,

            shippingCost: $shippingCost,

            message: $freeShipping
                ? 'Envío gratuito'
                : 'Costo de envío calculado al finalizar la compra',

        );
    }
}