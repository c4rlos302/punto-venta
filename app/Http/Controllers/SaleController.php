<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::withCount('items')
            ->latest()
            ->get();

        return view('sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'user']);

        return view('sales.show', compact('sale'));
    }

    public function cancel(Sale $sale, InventoryService $inventory) {
        if ($sale->status === 'cancelled') {
            return back()->with(
                'error',
                'Esta venta ya está cancelada.'
            );
        }

        try {

            DB::transaction(function () use ($sale, $inventory) {

                $sale->load('items.product');

                foreach ($sale->items as $item) {

                    $product = $item->product;

                    if (!$product) {
                        throw new \RuntimeException(
                            "El producto de la venta #{$sale->id} ya no existe."
                        );
                    }

                    $inventory->addStock(
                        $product->id,
                        $item->quantity,
                        "Cancelación de venta",
                        $sale->id,
                        Auth::id()
                    );
                }

                $sale->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                    'cancelled_by' => Auth::id(),
                ]);
            });

            return back()->with(
                'success',
                'Venta cancelada correctamente. El inventario ha sido restaurado.'
            );
        } catch (\Throwable $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}
