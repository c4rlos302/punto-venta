<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Encabezado --}}
    <div class="mb-8">

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Dashboard
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Resumen de tu punto de venta.
        </p>

    </div>


    {{-- MÉTRICAS --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Ventas --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Ventas de hoy
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                {{ $salesToday }}
            </p>

        </div>


        {{-- Ingresos --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Ingresos de hoy
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                ${{ number_format($incomeToday, 2) }}
            </p>

        </div>


        {{-- Productos vendidos --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Productos vendidos
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                {{ $productsSoldToday }}
            </p>

        </div>


        {{-- Stock bajo --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Stock bajo
            </p>

            <p class="mt-2 text-3xl font-bold text-red-600">
                {{ $lowStockProducts->count() }}
            </p>

        </div>

    </div>


    {{-- CONTENIDO --}}
    <div class="mt-8 grid gap-6 lg:grid-cols-2">


        {{-- VENTAS RECIENTES --}}
        <div
            class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-zinc-700">

                <h2 class="font-semibold text-gray-900 dark:text-white">
                    Ventas recientes
                </h2>

            </div>


            <div class="divide-y divide-gray-100 dark:divide-zinc-700">

                @forelse ($recentSales as $sale)
                    <div class="flex items-center justify-between px-6 py-4">

                        <div>

                            <p class="font-medium text-gray-900 dark:text-white">
                                Venta #{{ $sale->id }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                            </p>

                        </div>

                        <div class="text-right">

                            <p class="font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($sale->total, 2) }}
                            </p>

                            <a href="{{ route('sales.show', $sale) }}" wire:navigate
                                class="text-xs font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                Ver detalle
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-10 text-center">

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            No hay ventas registradas.
                        </p>

                    </div>
                @endforelse

            </div>


            <div class="border-t border-gray-200 px-6 py-4 dark:border-zinc-700">

                <a href="{{ route('sales.index') }}" wire:navigate
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                    Ver todas las ventas →
                </a>

            </div>

        </div>


        {{-- STOCK BAJO --}}
        <div
            class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-zinc-700">

                <h2 class="font-semibold text-gray-900 dark:text-white">
                    Productos con stock bajo
                </h2>

            </div>


            <div class="divide-y divide-gray-100 dark:divide-zinc-700">

                @forelse ($lowStockProducts->take(5) as $product)
                    <div class="flex items-center justify-between px-6 py-4">

                        <div>

                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $product->name }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Código: {{ $product->code }}
                            </p>

                        </div>

                        <span
                            class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-950 dark:text-red-300">
                            {{ $product->stock }} disponibles
                        </span>

                    </div>

                @empty

                    <div class="px-6 py-10 text-center">

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            No hay productos con stock bajo.
                        </p>

                    </div>
                @endforelse

            </div>


            <div class="border-t border-gray-200 px-6 py-4 dark:border-zinc-700">

                <a href="{{ route('products.index') }}" wire:navigate
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                    Ver productos →
                </a>

            </div>

        </div>

    </div>

</div>
