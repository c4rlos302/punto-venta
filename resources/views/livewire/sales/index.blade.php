<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Encabezado --}}
    <div class="mb-8">

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Historial de ventas
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Consulta y filtra las ventas realizadas.
        </p>

    </div>

    {{-- Filtros --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <div class="grid gap-4 md:grid-cols-4">

            {{-- Buscar --}}
            <div class="md:col-span-2">

                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Buscar venta
                </label>

                <input id="search" type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Número de venta..."
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

            </div>

            {{-- Fecha desde --}}
            <div>

                <label for="dateFrom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Desde
                </label>

                <input id="dateFrom" type="date" wire:model.live="dateFrom"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

            </div>

            {{-- Fecha hasta --}}
            <div>

                <label for="dateTo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Hasta
                </label>

                <input id="dateTo" type="date" wire:model.live="dateTo"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

            </div>

        </div>

        {{-- Limpiar --}}
        @if ($search || $dateFrom || $dateTo)
            <div class="mt-4">

                <button type="button" wire:click="clearFilters"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                    Limpiar filtros
                </button>

            </div>
        @endif

    </div>

    {{-- Tabla --}}
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-gray-200 bg-gray-50 dark:border-zinc-700 dark:bg-zinc-800">

                    <tr>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Venta
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Fecha
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Productos
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-gray-700 dark:text-gray-300">
                            Total
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-gray-700 dark:text-gray-300">
                            Acción
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">

                    @forelse ($sales as $sale)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-zinc-800">

                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                #{{ $sale->id }}
                            </td>

                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $sale->items_count }}
                                {{ $sale->items_count === 1 ? 'producto' : 'productos' }}
                            </td>

                            <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($sale->total, 2) }}
                            </td>

                            <td class="px-6 py-4 text-right">

                                <a href="{{ route('sales.show', $sale) }}" wire:navigate
                                    class="font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                    Ver detalle
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-12 text-center">

                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    No se encontraron ventas.
                                </p>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Prueba modificando los filtros.
                                </p>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Paginación --}}
        @if ($sales->hasPages())
            <div class="border-t border-gray-200 px-6 py-4 dark:border-zinc-700">

                {{ $sales->links() }}

            </div>
        @endif

    </div>

</div>
