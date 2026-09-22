<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportExportController extends Controller
{
    public function sales(Request $request): StreamedResponse
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = Sale::query()
            ->with('user')
            ->where('status', 'completed');

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $sales = $query
            ->withSum('items', 'quantity')
            ->latest()
            ->get();

        $filename = 'reporte-ventas-' . now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($sales) {

            $handle = fopen('php://output', 'w');

            /*
            |--------------------------------------------------------------------------
            | BOM para que Excel reconozca UTF-8
            |--------------------------------------------------------------------------
            */

            fwrite($handle, "\xEF\xBB\xBF");

            /*
            |--------------------------------------------------------------------------
            | Encabezados
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'Venta',
                'Fecha',
                'Vendedor',
                'Unidades',
                'Total',
                'Método de pago',
                'Estado',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Datos
            |--------------------------------------------------------------------------
            */

            foreach ($sales as $sale) {

                fputcsv($handle, [
                    $sale->id,
                    $sale->created_at
                        ->timezone('America/Mexico_City')
                        ->format('d/m/Y H:i:s'),

                    $sale->user?->name ?? 'Sin usuario',

                    $sale->items_sum_quantity ?? 0,

                    number_format($sale->total, 2, '.', ''),

                    $sale->payment_method->label(),

                    'Completada',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function inventory(Request $request): StreamedResponse
    {
        $stockFilter = $request->input('stock_filter', 'all');
        $search = $request->input('search', '');

        $query = Product::query()
            ->with('category');

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        switch ($stockFilter) {
            case 'out':
                $query->where('stock', 0);
                break;

            case 'low':
                $query
                    ->where('stock', '>', 0)
                    ->where('stock', '<=', 5);
                break;

            case 'available':
                $query->where('stock', '>', 5);
                break;
        }

        $products = $query
            ->orderBy('stock')
            ->get();

        $filename = 'reporte-inventario-' . now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($products) {

            $handle = fopen('php://output', 'w');

            // BOM para compatibilidad con Excel
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Código',
                'Producto',
                'Categoría',
                'Stock',
                'Precio',
                'Valor del inventario',
                'Estado',
            ]);

            foreach ($products as $product) {

                $value = $product->stock * $product->price;

                $status = match (true) {
                    $product->stock === 0 => 'Agotado',
                    $product->stock <= 5 => 'Stock bajo',
                    default => 'Disponible',
                };

                fputcsv($handle, [
                    $product->code,
                    $product->name,
                    $product->category?->name ?? 'Sin categoría',
                    $product->stock,
                    number_format($product->price, 2, '.', ''),
                    number_format($value, 2, '.', ''),
                    $status,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
