<x-layouts::app :title="'Venta #' . $sale->id">

    @php
        $paymentMethod = $sale->payment_method->label();
    @endphp

    <div class="mx-auto w-full max-w-3xl px-4 py-6 sm:px-6 sm:py-8">

        {{-- Acciones --}}
        <div class="mb-6 flex flex-col gap-3 print:hidden sm:flex-row sm:items-center sm:justify-between">

            <a href="{{ route('sales.index') }}" wire:navigate
                class="text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">
                ← Volver al historial
            </a>

            <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">

                <a href="{{ route('sales.ticket', $sale) }}" target="_blank"
                    class="w-full rounded-lg bg-zinc-900 px-4 py-2.5 text-center text-sm font-medium text-white transition hover:bg-zinc-700 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200 sm:w-auto">
                    Imprimir ticket
                </a>

                @if (auth()->user()->isAdmin() && $sale->status !== 'cancelled')
                    <form method="POST" action="{{ route('sales.cancel', $sale) }}" class="w-full sm:w-auto"
                        onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta venta? El inventario será restaurado.');">

                        @csrf

                        <button type="submit"
                            class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-700 sm:w-auto">
                            Cancelar venta
                        </button>

                    </form>
                @endif

            </div>

        </div>

        {{-- Ticket --}}
        <div
            class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-8 print:border-0 print:shadow-none">

            {{-- Encabezado --}}
            <div class="border-b border-dashed border-zinc-300 pb-6 text-center dark:border-zinc-700">

                <h1 class="text-xl font-bold text-zinc-900 dark:text-white sm:text-2xl">
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

                @if ($sale->status === 'cancelled')
                    <div
                        class="mt-4 inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                        Venta cancelada
                    </div>
                @endif

            </div>

            {{-- Información de venta --}}
            <div class="border-b border-dashed border-zinc-300 py-5 dark:border-zinc-700">

                <div class="flex items-start justify-between gap-4 text-sm">

                    <span class="shrink-0 text-zinc-500 dark:text-zinc-400">
                        Vendedor
                    </span>

                    <span class="min-w-0 break-words text-right font-medium text-zinc-900 dark:text-white">
                        {{ $sale->user?->name ?? 'Sin usuario' }}
                    </span>

                </div>

            </div>

            {{-- Productos --}}
            <div class="border-b border-dashed border-zinc-300 py-5 dark:border-zinc-700">

                {{-- Encabezado --}}
                <div
                    class="mb-4 grid grid-cols-12 gap-2 text-[10px] font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400 sm:text-xs">

                    <div class="col-span-5 sm:col-span-6">
                        Producto
                    </div>

                    <div class="col-span-2 text-center">
                        Cant.
                    </div>

                    <div class="col-span-2 text-right">
                        Precio
                    </div>

                    <div class="col-span-3 text-right sm:col-span-2">
                        Subtotal
                    </div>

                </div>

                {{-- Productos --}}
                <div class="space-y-4">

                    @foreach ($sale->items as $item)
                        <div class="grid min-w-0 grid-cols-12 gap-2 text-sm">

                            <div class="col-span-5 min-w-0 break-words text-zinc-900 dark:text-white sm:col-span-6">
                                {{ $item->product?->name ?? 'Producto eliminado' }}
                            </div>

                            <div class="col-span-2 text-center text-zinc-600 dark:text-zinc-400">
                                {{ $item->quantity }}
                            </div>

                            <div class="col-span-2 text-right text-zinc-600 dark:text-zinc-400">
                                ${{ number_format($item->price, 2) }}
                            </div>

                            <div class="col-span-3 text-right font-medium text-zinc-900 dark:text-white sm:col-span-2">
                                ${{ number_format($item->subtotal, 2) }}
                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

            {{-- Totales --}}
            <div class="border-b border-dashed border-zinc-300 py-5 dark:border-zinc-700">

                <div class="flex items-center justify-between gap-4 text-sm">

                    <span class="text-zinc-500 dark:text-zinc-400">
                        Subtotal
                    </span>

                    <span class="shrink-0 text-zinc-900 dark:text-white">
                        ${{ number_format($sale->total, 2) }}
                    </span>

                </div>

                <div class="mt-3 flex items-center justify-between gap-4 text-lg font-bold">

                    <span class="text-zinc-900 dark:text-white">
                        Total
                    </span>

                    <span class="shrink-0 text-zinc-900 dark:text-white">
                        ${{ number_format($sale->total, 2) }}
                    </span>

                </div>

            </div>

            {{-- Pago --}}
            <div class="border-b border-dashed border-zinc-300 py-5 dark:border-zinc-700">

                <div class="flex items-start justify-between gap-4 text-sm">

                    <span class="shrink-0 text-zinc-500 dark:text-zinc-400">
                        Método de pago
                    </span>

                    <span class="min-w-0 break-words text-right font-medium text-zinc-900 dark:text-white">
                        {{ $paymentMethod }}
                    </span>

                </div>

                <div class="mt-3 flex items-center justify-between gap-4 text-sm">

                    <span class="text-zinc-500 dark:text-zinc-400">
                        Pago recibido
                    </span>

                    <span class="shrink-0 text-zinc-900 dark:text-white">
                        ${{ number_format($sale->paid_amount, 2) }}
                    </span>

                </div>

                <div class="mt-3 flex items-center justify-between gap-4 text-sm">

                    <span class="text-zinc-500 dark:text-zinc-400">
                        Cambio
                    </span>

                    <span class="shrink-0 font-medium text-zinc-900 dark:text-white">
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
