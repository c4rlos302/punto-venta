<div class="space-y-6">

    {{-- Encabezado --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Reporte de inventario
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Resumen del inventario actual y sus existencias.
            </p>
        </div>

        <a href="{{ route('reports.inventory.export', [
            'stock_filter' => $stockFilter,
            'search' => $search,
        ]) }}"
            class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
            Exportar CSV
        </a>

    </div>


    {{-- Estadísticas --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Productos --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Productos
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                {{ $totalProducts }}
            </p>

        </div>


        {{-- Agotados --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Agotados
            </p>

            <p class="mt-2 text-3xl font-bold text-red-600 dark:text-red-400">
                {{ $outOfStock }}
            </p>

        </div>


        {{-- Stock bajo --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Stock bajo
            </p>

            <p class="mt-2 text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                {{ $lowStock }}
            </p>

        </div>


        {{-- Valor --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Valor del inventario
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                ${{ number_format($inventoryValue, 2) }}
            </p>

        </div>

    </div>


    {{-- Movimientos --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Unidades actuales
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                {{ $totalUnits }}
            </p>

        </div>


        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Movimientos registrados
            </p>

            <div class="mt-2 flex gap-6">

                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Entradas
                    </span>

                    <p class="text-xl font-bold text-green-600 dark:text-green-400">
                        +{{ $entries }}
                    </p>
                </div>

                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Salidas
                    </span>

                    <p class="text-xl font-bold text-red-600 dark:text-red-400">
                        -{{ $exits }}
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- Filtros --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

            {{-- Buscar --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Buscar
                </label>

                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Nombre o código..."
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">

            </div>


            {{-- Stock --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Existencia
                </label>

                <select wire:model.live="stockFilter"
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="all">
                        Todos
                    </option>

                    <option value="out">
                        Agotados
                    </option>

                    <option value="low">
                        Stock bajo
                    </option>

                    <option value="available">
                        Disponibles
                    </option>
                </select>

            </div>


            {{-- Limpiar --}}
            <div class="flex items-end">

                <button type="button" wire:click="clearFilters"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Restablecer
                </button>

            </div>

        </div>

    </div>


    {{-- Tabla --}}
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">

            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Inventario actual
            </h2>

        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                <thead class="bg-gray-50 dark:bg-gray-700/50">

                    <tr>

                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Producto
                        </th>

                        <th
                            class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Categoría
                        </th>

                        <th
                            class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Stock
                        </th>

                        <th
                            class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Precio
                        </th>

                        <th
                            class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Valor
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">

                            <td class="px-6 py-4">

                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $product->name }}
                                </div>

                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $product->code }}
                                </div>

                            </td>


                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">

                                {{ $product->category?->name ?? 'Sin categoría' }}

                            </td>


                            <td class="px-6 py-4 text-center">

                                @if ($product->stock === 0)
                                    <span
                                        class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        Agotado
                                    </span>
                                @elseif ($product->stock <= 5)
                                    <span
                                        class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $product->stock }}
                                    </span>
                                @endif

                            </td>


                            <td class="px-6 py-4 text-right text-sm text-gray-700 dark:text-gray-300">
                                ${{ number_format($product->price, 2) }}
                            </td>


                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">
                                ${{ number_format($product->stock * $product->price, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                No se encontraron productos.
                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($products->hasPages())
            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-700">
                {{ $products->links() }}
            </div>
        @endif

    </div>

</div>
