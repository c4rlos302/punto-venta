<?php

namespace App\Livewire\Inventory;

use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $selectedProductId = null;

    public string $movementType = 'entrada';

    public int $quantity = 1;

    public string $reason = '';

    public bool $showModal = false;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function openMovementModal($productId)
    {
        $product = Product::findOrFail($productId);

        $this->selectedProductId = $product->id;
        $this->movementType = 'entrada';
        $this->quantity = 1;
        $this->reason = '';
        $this->showModal = true;
    }

    public function closeMovementModal()
    {
        $this->reset([
            'selectedProductId',
            'movementType',
            'quantity',
            'reason',
        ]);

        $this->movementType = 'entrada';
        $this->quantity = 1;
        $this->showModal = false;
    }

    public function saveMovement(InventoryService $inventory)
    {
        $this->validate([
            'selectedProductId' => [
                'required',
                'exists:products,id'
            ],

            'movementType' => [
                'required',
                'in:entrada,salida,ajuste'
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],

            'reason' => [
                'nullable',
                'string',
                'max:255'
            ],
        ]);

        try {

            DB::transaction(function () use ($inventory) {

                if ($this->movementType === 'entrada') {

                    $inventory->addStock(
                        $this->selectedProductId,
                        $this->quantity,
                        $this->reason ?: null
                    );
                } elseif ($this->movementType === 'salida') {

                    $inventory->removeStock(
                        $this->selectedProductId,
                        $this->quantity,
                        $this->reason ?: null
                    );
                } else {

                    $inventory->adjustStock(
                        $this->selectedProductId,
                        $this->quantity,
                        $this->reason ?: null
                    );
                }
            });

            $this->closeMovementModal();

            session()->flash(
                'success',
                'Movimiento de inventario registrado correctamente.'
            );
        } catch (\Throwable $e) {

            session()->flash(
                'error',
                $e->getMessage()
            );
        }
    }

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->when($this->search, function ($query) {
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
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.inventory.index', [
            'products' => $products,
        ]);
    }
}
