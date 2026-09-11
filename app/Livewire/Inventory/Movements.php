<?php

namespace App\Livewire\Inventory;

use App\Models\InventoryMovement;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Movements extends Component
{
    use WithPagination;

    public string $search = '';

    public string $type = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedType()
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
            'type',
            'dateFrom',
            'dateTo',
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $movements = InventoryMovement::query()
            ->with(['product', 'sale', 'user'])

            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where(function ($query) {
                        $query->where(
                            'name',
                            'like',
                            '%' . $this->search . '%'
                        )
                            ->orWhere(
                                'code',
                                'like',
                                '%' . $this->search . '%'
                            );
                    });
                });
            })

            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
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
            ->paginate(15);

        return view('livewire.inventory.movements', [
            'movements' => $movements,
        ]);
    }
}
