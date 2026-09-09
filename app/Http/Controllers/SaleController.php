<?php

namespace App\Http\Controllers;

use App\Models\Sale;

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
        $sale->load('items.product');

        return view('sales.show', compact('sale'));
    }
}
