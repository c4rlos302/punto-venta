<?php

namespace App\Livewire\Reports;

use App\Models\InventoryMovement;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Inventory extends Component
{
    use WithPagination;

    public string $stockFilter = 'all';

    public string $search = '';

    public function updatedStockFilter()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->stockFilter = 'all';
        $this->search = '';

        $this->resetPage();
    }

    public function render()
    {
        /*
        |--------------------------------------------------------------------------
        | Productos
        |--------------------------------------------------------------------------
        */

        $productsQuery = Product::query()
            ->with('category');

        if ($this->search !== '') {

            $productsQuery->where(function ($query) {

                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%');
            });
        }

        switch ($this->stockFilter) {

            case 'out':
                $productsQuery->where('stock', '=', 0);
                break;

            case 'low':
                $productsQuery->where('stock', '>', 0)
                    ->where('stock', '<=', 5);
                break;

            case 'available':
                $productsQuery->where('stock', '>', 5);
                break;
        }

        $products = $productsQuery
            ->orderBy('stock')
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | Estadísticas
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $outOfStock = Product::where('stock', 0)->count();

        $lowStock = Product::whereBetween('stock', [1, 5])->count();

        $totalUnits = Product::sum('stock');

        $inventoryValue = Product::query()
            ->selectRaw('SUM(stock * price) as total')
            ->value('total') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Movimientos
        |--------------------------------------------------------------------------
        */

        $entries = InventoryMovement::where('type', 'in')
            ->sum('quantity');

        $exits = InventoryMovement::where('type', 'out')
            ->sum('quantity');

        return view('livewire.reports.inventory', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'outOfStock' => $outOfStock,
            'lowStock' => $lowStock,
            'totalUnits' => $totalUnits,
            'inventoryValue' => $inventoryValue,
            'entries' => $entries,
            'exits' => $exits,
        ]);
    }
}
