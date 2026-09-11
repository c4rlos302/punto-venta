<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
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

        return view('livewire.products.index', [
            'products' => $products,
        ]);
    }
}
