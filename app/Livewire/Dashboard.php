<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $salesToday = Sale::whereDate(
            'created_at',
            $today
        )->count();

        $incomeToday = Sale::whereDate(
            'created_at',
            $today
        )->sum('total');

        $productsSoldToday = SaleItem::whereDate(
            'created_at',
            $today
        )->sum('quantity');

        $lowStockProducts = Product::where('stock', '<=', 5)
            ->orderBy('stock')
            ->get();

        $recentSales = Sale::latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'salesToday' => $salesToday,
            'incomeToday' => $incomeToday,
            'productsSoldToday' => $productsSoldToday,
            'lowStockProducts' => $lowStockProducts,
            'recentSales' => $recentSales,
        ]);
    }
}
