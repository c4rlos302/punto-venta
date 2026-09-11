<x-layouts::app :title="'Venta #' . $sale->id">

    @php
        $paymentMethod = $sale->payment_method->label();
    @endphp

    <div class="mx-auto max-w-3xl px-6 py-8">

        {{-- Acciones --}}
        <div class="mb-6 flex items-center justify-between print:hidden">

            <a href="{{ route('sales.index') }}" wire:navigate
                class="text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">
                ← Volver al historial
            </a>

            <button type="button" onclick="window.print()"
                class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                Imprimir ticket
            </button>

        </div>

        {{-- Ticket --}}
        <div
            class="rounded-xl border border-zinc-200 bg-white p-8 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 print:border-0 print:shadow-none">

            {{-- Encabezado --}}
            <div class="border-b border-dashed border-zinc-300 pb-6 text-center dark:border-zinc-700">

                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                    Punto de Venta
                </h1>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    Ticket de venta
                </p>

                <p class="mt-4 text-sm text-zinc-700 dark:text-zinc-300">
                    Venta #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                </p>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                </p>

            </div>

            {{-- Información de venta --}}
            <div class="border-b border-dashed border-zinc-300 py-5 dark:border-zinc-700">

                <div class="flex justify-between text-sm">

                    <span class="text-zinc-500 dark:text-zinc-400">
                        Vendedor
                    </span>

                    <span class="font-medium text-zinc-900 dark:text-white">
                        {{ $sale->user?->name ?? 'Sin usuario' }}
                    </span>

                </div>

            </div>

            {{-- Productos --}}
            <div class="border-b border-dashed border-zinc-300 py-5 dark:border-zinc-700">

                <div
                    class="mb-4 grid grid-cols-12 gap-2 text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">

                    <div class="col-span-6">
                        Producto
                    </div>

                    <div class="col-span-2 text-center">
                        Cant.
                    </div>

                    <div class="col-span-2 text-right">
                        Precio
                    </div>

                    <div class="col-span-2 text-right">
                        Subtotal
                    </div>

                </div>

                <div class="space-y-4">

                    @foreach ($sale->items as $item)
                        <div class="grid grid-cols-12 gap-2 text-sm">

                            <div class="col-span-6 text-zinc-900 dark:text-white">
                                {{ $item->product?->name ?? 'Producto eliminado' }}
                            </div>

                            <div class="col-span-2 text-center text-zinc-600 dark:text-zinc-400">
                                {{ $item->quantity }}
                            </div>

                            <div class="col-span-2 text-right text-zinc-600 dark:text-zinc-400">
                                ${{ number_format($item->price, 2) }}
                            </div>

                            <div class="col-span-2 text-right font-medium text-zinc-900 dark:text-white">
                                ${{ number_format($item->subtotal, 2) }}
                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

            {{-- Totales --}}
            <div class="border-b border-dashed border-zinc-300 py-5 dark:border-zinc-700">

                <div class="flex justify-between text-sm">

                    <span class="text-zinc-500 dark:text-zinc-400">
                        Subtotal
                    </span>

                    <span class="text-zinc-900 dark:text-white">
                        ${{ number_format($sale->total, 2) }}
                    </span>

                </div>

                <div class="mt-3 flex justify-between text-lg font-bold">

                    <span class="text-zinc-900 dark:text-white">
                        Total
                    </span>

                    <span class="text-zinc-900 dark:text-white">
                        ${{ number_format($sale->total, 2) }}
                    </span>

                </div>

            </div>

            {{-- Pago --}}
            <div class="border-b border-dashed border-zinc-300 py-5 dark:border-zinc-700">

                <div class="flex justify-between text-sm">

                    <span class="text-zinc-500 dark:text-zinc-400">
                        Método de pago
                    </span>

                    <span class="font-medium text-zinc-900 dark:text-white">
                        {{ $paymentMethod }}
                    </span>

                </div>

                <div class="mt-3 flex justify-between text-sm">

                    <span class="text-zinc-500 dark:text-zinc-400">
                        Pago recibido
                    </span>

                    <span class="text-zinc-900 dark:text-white">
                        ${{ number_format($sale->paid_amount, 2) }}
                    </span>

                </div>

                <div class="mt-3 flex justify-between text-sm">

                    <span class="text-zinc-500 dark:text-zinc-400">
                        Cambio
                    </span>

                    <span class="font-medium text-zinc-900 dark:text-white">
                        ${{ number_format($sale->change, 2) }}
                    </span>

                </div>

            </div>

            {{-- Pie del ticket --}}
            <div class="pt-6 text-center">

                <p class="text-sm font-medium text-zinc-900 dark:text-white">
                    Gracias por su compra
                </p>

                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                    Conserve este ticket como comprobante.
                </p>

            </div>

        </div>

    </div>

</x-layouts::app>
