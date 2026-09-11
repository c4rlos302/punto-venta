<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\Product;

class InventoryService
{
    public function addStock(
        int $productId,
        int $quantity,
        ?string $reason = null,
        ?int $saleId = null,
        ?int $userId = null
    ): InventoryMovement {

        if ($quantity <= 0) {
            throw new \InvalidArgumentException(
                'La cantidad debe ser mayor a 0.'
            );
        }

        $product = Product::findOrFail($productId);

        $stockBefore = $product->stock;
        $stockAfter = $stockBefore + $quantity;

        $product->update([
            'stock' => $stockAfter,
        ]);

        return InventoryMovement::create([
            'product_id' => $product->id,
            'type' => 'entrada',
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reason' => $reason,
            'sale_id' => $saleId,
            'user_id' => $userId,
        ]);
    }

    public function removeStock(
        int $productId,
        int $quantity,
        ?string $reason = null,
        ?int $saleId = null,
        ?int $userId = null
    ): InventoryMovement {

        if ($quantity <= 0) {
            throw new \InvalidArgumentException(
                'La cantidad debe ser mayor a 0.'
            );
        }

        $product = Product::findOrFail($productId);

        $stockBefore = $product->stock;

        if ($quantity > $stockBefore) {
            throw new \RuntimeException(
                "No hay suficiente stock de {$product->name}."
            );
        }

        $stockAfter = $stockBefore - $quantity;

        $product->update([
            'stock' => $stockAfter,
        ]);

        return InventoryMovement::create([
            'product_id' => $product->id,
            'type' => 'salida',
            'quantity' => -$quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reason' => $reason,
            'sale_id' => $saleId,
            'user_id' => $userId,
        ]);
    }

    public function adjustStock(
        int $productId,
        int $newStock,
        ?string $reason = null,
        ?int $userId = null
    ): InventoryMovement {

        if ($newStock < 0) {
            throw new \InvalidArgumentException(
                'El stock no puede ser negativo.'
            );
        }

        $product = Product::findOrFail($productId);

        $stockBefore = $product->stock;
        $stockAfter = $newStock;

        $product->update([
            'stock' => $stockAfter,
        ]);

        return InventoryMovement::create([
            'product_id' => $product->id,
            'type' => 'ajuste',
            'quantity' => $stockAfter - $stockBefore,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reason' => $reason,
            'sale_id' => null,
            'user_id' => $userId,
        ]);
    }
}
