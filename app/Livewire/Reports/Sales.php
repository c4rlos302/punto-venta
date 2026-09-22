<?php

namespace App\Livewire\Reports;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;

    public string $period = 'month';

    public string $dateFrom = '';

    public string $dateTo = '';

    public function mount()
    {
        $this->setPeriod('month');
    }

    public function updatedPeriod()
    {
        $this->setPeriod($this->period);
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->period = 'custom';
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->period = 'custom';
        $this->resetPage();
    }

    public function setPeriod(string $period)
    {
        $this->period = $period;

        $today = now();

        switch ($period) {

            case 'today':
                $this->dateFrom = $today
                    ->copy()
                    ->format('Y-m-d');

                $this->dateTo = $today
                    ->copy()
                    ->format('Y-m-d');
                break;

            case 'week':
                $this->dateFrom = $today
                    ->copy()
                    ->startOfWeek()
                    ->format('Y-m-d');

                $this->dateTo = $today
                    ->copy()
                    ->endOfWeek()
                    ->format('Y-m-d');
                break;

            case 'month':
                $this->dateFrom = $today
                    ->copy()
                    ->startOfMonth()
                    ->format('Y-m-d');

                $this->dateTo = $today
                    ->copy()
                    ->endOfMonth()
                    ->format('Y-m-d');
                break;

            case 'custom':
                break;
        }
    }

    public function clearFilters()
    {
        $this->setPeriod('month');
        $this->resetPage();
    }

    public function render()
    {
        $from = Carbon::parse($this->dateFrom)
            ->startOfDay();

        $to = Carbon::parse($this->dateTo)
            ->endOfDay();

        /*
        |--------------------------------------------------------------------------
        | Ventas completadas
        |--------------------------------------------------------------------------
        */

        $completedSales = Sale::query()
            ->where('status', 'completed')
            ->whereBetween('created_at', [$from, $to]);

        $salesCount = (clone $completedSales)->count();

        $income = (clone $completedSales)->sum('total');

        /*
        |--------------------------------------------------------------------------
        | Unidades vendidas
        |--------------------------------------------------------------------------
        */

        $productsSold = SaleItem::query()
            ->whereHas('sale', function ($query) use ($from, $to) {
                $query
                    ->where('status', 'completed')
                    ->whereBetween('created_at', [$from, $to]);
            })
            ->sum('quantity');

        /*
        |--------------------------------------------------------------------------
        | Ticket promedio
        |--------------------------------------------------------------------------
        */

        $averageTicket = $salesCount > 0
            ? $income / $salesCount
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Ventas agrupadas por día
        |--------------------------------------------------------------------------
        */

        $salesByDay = Sale::query()
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as sales_count')
            ->selectRaw('SUM(total) as total')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$from, $to])
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Ventas por método de pago
        |--------------------------------------------------------------------------
        */

        $salesByPaymentMethod = Sale::query()
            ->select('payment_method')
            ->selectRaw('COUNT(*) as sales_count')
            ->selectRaw('SUM(total) as total')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Productos más vendidos
        |--------------------------------------------------------------------------
        */

        $topProducts = SaleItem::query()
            ->select('product_id')
            ->selectRaw('SUM(quantity) as units_sold')
            ->selectRaw('SUM(subtotal) as revenue')
            ->whereHas('sale', function ($query) use ($from, $to) {
                $query
                    ->where('status', 'completed')
                    ->whereBetween('created_at', [$from, $to]);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('units_sold')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Lista de ventas
        |--------------------------------------------------------------------------
        */

        $sales = Sale::query()
            ->with('user')
            ->withSum('items', 'quantity')
            ->whereBetween('created_at', [$from, $to])
            ->latest()
            ->paginate(10);


        $highestSalesDay = $salesByDay
            ->sortByDesc('total')
            ->first();

        $lowestSalesDay = $salesByDay
            ->sortBy('total')
            ->first();

        return view('livewire.reports.sales', [
            'sales' => $sales,
            'salesCount' => $salesCount,
            'income' => $income,
            'productsSold' => $productsSold,
            'averageTicket' => $averageTicket,
            'salesByDay' => $salesByDay,
            'salesByPaymentMethod' => $salesByPaymentMethod,
            'topProducts' => $topProducts,
            'highestSalesDay' => $highestSalesDay,
            'lowestSalesDay' => $lowestSalesDay,
        ]);
    }
}
