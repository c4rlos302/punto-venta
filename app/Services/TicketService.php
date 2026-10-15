<?php

namespace App\Services;

use App\Models\Sale;

class TicketService
{
    public function data(Sale $sale): array
    {
        $sale->loadMissing([
            'items.product',
            'user',
        ]);

        return [
            'sale' => [
                'id' => $sale->id,
                'number' => str_pad(
                    $sale->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),
                'date' => $sale->created_at
                    ->timezone('America/Mexico_City')
                    ->format('d/m/Y H:i'),
                'status' => $sale->status,
                'seller' => $sale->user?->name ?? 'Sin usuario',
            ],

            'items' => $sale->items->map(function ($item) {
                return [
                    'name' => $item->product?->name
                        ?? 'Producto eliminado',

                    'quantity' => $item->quantity,

                    'price' => (float) $item->price,

                    'subtotal' => (float) $item->subtotal,
                ];
            })->values()->all(),

            'payment' => [
                'method' => $sale->payment_method->label(),
                'paid' => (float) $sale->paid_amount,
                'change' => (float) $sale->change,
            ],

            'total' => (float) $sale->total,
        ];
    }
}
