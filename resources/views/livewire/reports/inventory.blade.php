<div class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6 sm:px-6 sm:py-8">

    {{-- Encabezado --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

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
            class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800 sm:w-auto dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
            Exportar CSV
        </a>

    </div>


    {{-- Estadísticas principales --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Productos --}}
        <div
            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Productos
            </p>

            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                {{ $totalProducts }}
            </p>
        </div>

        {{-- Agotados --}}
        <div
            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Agotados
            </p>

            <p class="mt-2 text-3xl font-bold text-red-600 dark:text-red-400">
                {{ $outOfStock }}
            </p>
        </div>

        {{-- Stock bajo --}}
        <div
            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Stock bajo
            </p>

            <p class="mt-2 text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                {{ $lowStock }}
            </p>
        </div>

        {{-- Valor del inventario --}}
        <div
            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Valor del inventario
            </p>

            <p class="mt-2 break-words text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">
                ${{ number_format($inventoryValue, 2) }}
            </p>
        </div>

    </div>


    {{-- Resumen de movimientos --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        {{-- Unidades actuales --}}
        <div
            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Unidades actuales
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                {{ $totalUnits }}
            </p>
        </div>

        {{-- Movimientos registrados --}}
        <div
            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Movimientos registrados
            </p>

            <div class="mt-3 grid grid-cols-2 gap-4">

                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Entradas
                    </span>

                    <p class="mt-1 text-xl font-bold text-green-600 dark:text-green-400">
                        +{{ $entries }}
                    </p>
                </div>

                <div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Salidas
                    </span>

                    <p class="mt-1 text-xl font-bold text-red-600 dark:text-red-400">
                        -{{ $exits }}
                    </p>
                </div>

            </div>
        </div>

    </div>


    {{-- Filtros --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">

        <div class="mb-4">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                Filtrar inventario
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Busca productos o filtra por sus existencias.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Buscar --}}
            <div>
                <label for="inventory-search" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Buscar
                </label>

                <input id="inventory-search" type="search" wire:model.live.debounce.300ms="search"
                    placeholder="Nombre o código..."
                    class="w-full min-w-0 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Stock --}}
            <div>
                <label for="inventory-stock-filter"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Existencia
                </label>

                <select id="inventory-stock-filter" wire:model.live="stockFilter"
                    class="w-full min-w-0 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="all">Todos</option>
                    <option value="out">Agotados</option>
                    <option value="low">Stock bajo</option>
                    <option value="available">Disponibles</option>
                </select>
            </div>

            {{-- Restablecer --}}
            <div class="flex items-end sm:col-span-2 xl:col-span-1">
                <button type="button" wire:click="clearFilters"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Restablecer filtros
                </button>
            </div>

        </div>

    </div>


    {{-- Inventario actual --}}
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        {{-- Encabezado de la sección --}}
        <div
            class="flex flex-col gap-2 border-b border-gray-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-gray-700">

            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Inventario actual
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Productos y existencias registradas.
                </p>
            </div>

        </div>


        {{-- Vista móvil: tarjetas --}}
        <div class="divide-y divide-gray-200 md:hidden dark:divide-gray-700">

            @forelse ($products as $product)
                <article wire:key="inventory-mobile-{{ $product->id }}" class="space-y-4 p-4">

                    {{-- Nombre y código --}}
                    <div class="min-w-0">
                        <h3 class="break-words text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $product->name }}
                        </h3>

                        <p class="mt-1 break-all text-xs text-gray-500 dark:text-gray-400">
                            Código: {{ $product->code }}
                        </p>
                    </div>

                    {{-- Categoría --}}
                    <div class="flex items-start justify-between gap-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Categoría
                        </span>

                        <span class="max-w-[60%] break-words text-right text-sm text-gray-700 dark:text-gray-300">
                            {{ $product->category?->name ?? 'Sin categoría' }}
                        </span>
                    </div>

                    {{-- Stock --}}
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Existencias
                        </span>

                        <div>
                            @if ($product->stock === 0)
                                <span
                                    class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    Agotado
                                </span>
                            @elseif ($product->stock <= 5)
                                <span
                                    class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    {{ $product->stock }} unidades
                                </span>
                            @else
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $product->stock }} unidades
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Precio --}}
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Precio unitario
                        </span>

                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    </div>

                    {{-- Valor total --}}
                    <div
                        class="flex items-center justify-between gap-4 border-t border-gray-100 pt-3 dark:border-gray-700">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Valor en inventario
                        </span>

                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                            ${{ number_format($product->stock * $product->price, 2) }}
                        </span>
                    </div>

                </article>

            @empty

                <div class="px-4 py-10 text-center">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        No se encontraron productos.
                    </p>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Prueba con otro término de búsqueda o cambia el filtro de existencias.
                    </p>
                </div>
            @endforelse

        </div>


        {{-- Vista de escritorio: tabla --}}
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
                        <tr wire:key="inventory-desktop-{{ $product->id }}"
                            class="transition hover:bg-gray-50 dark:hover:bg-gray-700/40">

                            {{-- Producto --}}
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $product->name }}
                                </div>

                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $product->code }}
                                </div>
                            </td>

                            {{-- Categoría --}}
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                {{ $product->category?->name ?? 'Sin categoría' }}
                            </td>

                            {{-- Stock --}}
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

                            {{-- Precio --}}
                            <td
                                class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-700 dark:text-gray-300">
                                ${{ number_format($product->price, 2) }}
                            </td>

                            {{-- Valor total --}}
                            <td
                                class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">
                                ${{ number_format($product->stock * $product->price, 2) }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5"
                                class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                No se encontraron productos.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Paginación --}}
        @if ($products->hasPages())
            <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                {{ $products->links() }}
            </div>
        @endif

    </div>

</div>
