<?php

namespace App\Livewire\Sales;

use App\Models\Product;

use App\Models\Sale;
use App\Models\SaleItem;
use App\PaymentMethod;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public string $search = '';
    public array $cart = [];

    public string $paymentMethod = PaymentMethod::CASH->value;
    public string $paidAmount = '';

    public function addProduct(Product $product)
    {
        if ($product->stock <= 0) {
            return;
        }

        if (isset($this->cart[$product->id])) {
            if ($this->cart[$product->id]['quantity'] >= $product->stock) {
                return;
            }

            $this->cart[$product->id]['quantity']++;
        } else {
            $this->cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => 1,
                'stock' => $product->stock,
            ];
        }
    }

    public function removeProduct($productId)
    {
        unset($this->cart[$productId]);
    }

    public function increaseQuantity($productId)
    {
        if (!isset($this->cart[$productId])) {
            return;
        }

        if ($this->cart[$productId]['quantity'] >= $this->cart[$productId]['stock']) {
            return;
        }

        $this->cart[$productId]['quantity']++;
    }

    public function decreaseQuantity($productId)
    {
        if (!isset($this->cart[$productId])) {
            return;
        }

        if ($this->cart[$productId]['quantity'] <= 1) {
            unset($this->cart[$productId]);
            return;
        }

        $this->cart[$productId]['quantity']--;
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function getChangeProperty()
    {
        if ($this->paymentMethod !== 'cash') {
            return 0;
        }

        $paid = (float) $this->paidAmount;

        return max(0, $paid - $this->total);
    }

    public function checkout(InventoryService $inventory)
    {
        if (empty($this->cart)) {
            return;
        }

        $this->validate([
            'paymentMethod' => [
                'required',
                'in:cash,card,transfer',
            ],
            'paidAmount' => [
                'required_if:paymentMethod,cash',
                'numeric',
                'min:0',
            ],
        ]);

        if (
            $this->paymentMethod === 'cash'
            && (float) $this->paidAmount < $this->total
        ) {
            $this->addError(
                'paidAmount',
                'El pago recibido no puede ser menor al total de la venta.'
            );

            return;
        }

        try {

            DB::transaction(function () use ($inventory) {

                $sale = Sale::create([
                    'total' => $this->total,
                    'user_id' => Auth::id(),
                    'payment_method' => $this->paymentMethod,
                    'paid_amount' => $this->paymentMethod === 'cash'
                        ? (float) $this->paidAmount
                        : $this->total,
                    'change' => $this->paymentMethod === 'cash'
                        ? $this->change
                        : 0,
                ]);

                foreach ($this->cart as $item) {

                    $product = Product::find($item['id']);

                    if (!$product) {
                        throw new \RuntimeException(
                            'Uno de los productos ya no existe.'
                        );
                    }

                    if ($product->stock < $item['quantity']) {
                        throw new \RuntimeException(
                            "Stock insuficiente para {$product->name}."
                        );
                    }

                    $subtotal = $product->price * $item['quantity'];

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);

                    $inventory->removeStock(
                        $product->id,
                        $item['quantity'],
                        "Venta #{$sale->id}",
                        $sale->id,
                        Auth::id()
                    );
                }
            });

            $this->cart = [];
            $this->search = '';
            $this->paymentMethod = 'cash';
            $this->paidAmount = '';

            session()->flash(
                'success',
                'Venta registrada correctamente.'
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
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name')
            ->get();

        return view('livewire.sales.create', [
            'products' => $products,
        ]);
    }
}
