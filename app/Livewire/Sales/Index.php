<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'dateFrom',
            'dateTo',
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $sales = Sale::query()
            ->with('user')
            ->withCount('items')

            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where(
                        'id',
                        'like',
                        '%' . $this->search . '%'
                    );
                });
            })

            ->when($this->dateFrom, function ($query) {
                $query->whereDate(
                    'created_at',
                    '>=',
                    $this->dateFrom
                );
            })

            ->when($this->dateTo, function ($query) {
                $query->whereDate(
                    'created_at',
                    '<=',
                    $this->dateTo
                );
            })

            ->latest()
            ->paginate(10);

        return view('livewire.sales.index', [
            'sales' => $sales,
        ]);
    }
}
