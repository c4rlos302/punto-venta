<div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
     ENCABEZADO
     ========================================================= --}}
    <div class="mb-6 sm:mb-8">

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Historial de ventas
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Consulta y filtra las ventas realizadas.
        </p>

    </div>


    {{-- =========================================================
     FILTROS
     ========================================================= --}}
    <div
        class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">

        <div class="grid gap-4 lg:grid-cols-4">

            {{-- Buscar --}}
            <div class="lg:col-span-2">

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
                    class="mt-2 block w-full min-w-0 rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

            </div>


            {{-- Fecha hasta --}}
            <div>

                <label for="dateTo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Hasta
                </label>

                <input id="dateTo" type="date" wire:model.live="dateTo"
                    class="mt-2 block w-full min-w-0 rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

            </div>

        </div>


        {{-- Limpiar --}}
        @if ($search || $dateFrom || $dateTo)
            <div class="mt-4">

                <button type="button" wire:click="clearFilters"
                    class="rounded-lg px-2 py-1 text-sm font-medium text-indigo-600 transition hover:bg-indigo-50 hover:text-indigo-800 dark:text-indigo-400 dark:hover:bg-indigo-950/30">
                    Limpiar filtros
                </button>

            </div>
        @endif

    </div>


    {{-- =========================================================
     TABLA — ESCRITORIO
     ========================================================= --}}
    <div
        class="hidden overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900 lg:block">

        <table class="w-full text-left text-sm">

            <thead class="border-b border-gray-200 bg-gray-50 dark:border-zinc-700 dark:bg-zinc-800">

                <tr>

                    <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                        Venta
                    </th>

                    <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                        Usuario
                    </th>

                    <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                        Fecha
                    </th>

                    <th class="px-6 py-4 text-center font-semibold text-gray-700 dark:text-gray-300">
                        Unidades
                    </th>

                    <th class="px-6 py-4 text-right font-semibold text-gray-700 dark:text-gray-300">
                        Total
                    </th>

                    <th class="px-4 py-4 text-center font-semibold text-gray-700 dark:text-gray-300">
                        Estado
                    </th>

                    <th class="px-6 py-4 text-right font-semibold text-gray-700 dark:text-gray-300">
                        Acción
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">

                @forelse ($sales as $sale)
                    <tr class="transition hover:bg-gray-50 dark:hover:bg-zinc-800">

                        {{-- Venta --}}
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            #{{ $sale->id }}
                        </td>


                        {{-- Usuario --}}
                        <td class="px-6 py-4">

                            @if ($sale->user)
                                <div class="font-medium text-zinc-900 dark:text-white">
                                    {{ $sale->user->name }}
                                </div>

                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $sale->user->email }}
                                </div>
                            @else
                                <span class="text-zinc-400">
                                    Usuario no disponible
                                </span>
                            @endif

                        </td>


                        {{-- Fecha --}}
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                            {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                        </td>


                        {{-- Unidades --}}
                        <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400">
                            {{ $sale->items_sum_quantity }}
                        </td>


                        {{-- Total --}}
                        <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                            ${{ number_format($sale->total, 2) }}
                        </td>


                        {{-- Estado --}}
                        <td class="px-4 py-4 text-center">

                            @if ($sale->status === 'cancelled')
                                <span
                                    class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    Cancelada
                                </span>
                            @else
                                <span
                                    class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                    Completada
                                </span>
                            @endif

                        </td>


                        {{-- Acción --}}
                        <td class="px-6 py-4 text-right">

                            <a href="{{ route('sales.show', $sale) }}" wire:navigate
                                class="font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                Ver detalle
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="px-6 py-12 text-center">

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


        {{-- Paginación --}}
        @if ($sales->hasPages())
            <div class="border-t border-gray-200 px-4 py-4 dark:border-zinc-700 sm:px-6">

                {{ $sales->links() }}

            </div>
        @endif

    </div>


    {{-- =========================================================
     TARJETAS — MÓVIL / TABLET
     ========================================================= --}}
    <div class="space-y-3 lg:hidden">

        @forelse ($sales as $sale)
            <article
                class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                {{-- Encabezado --}}
                <div
                    class="flex items-start justify-between gap-3 border-b border-gray-100 px-4 py-4 dark:border-zinc-800">

                    <div class="min-w-0">

                        <p class="font-semibold text-gray-900 dark:text-white">
                            Venta #{{ $sale->id }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                        </p>

                    </div>


                    {{-- Estado --}}
                    @if ($sale->status === 'cancelled')
                        <span
                            class="shrink-0 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                            Cancelada
                        </span>
                    @else
                        <span
                            class="shrink-0 rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                            Completada
                        </span>
                    @endif

                </div>


                {{-- Información --}}
                <div class="space-y-3 px-4 py-4">

                    {{-- Usuario --}}
                    <div class="flex items-start justify-between gap-4">

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Usuario
                        </span>

                        <div class="min-w-0 text-right">

                            @if ($sale->user)
                                <p class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $sale->user->name }}
                                </p>

                                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                                    {{ $sale->user->email }}
                                </p>
                            @else
                                <p class="text-sm text-zinc-400">
                                    Usuario no disponible
                                </p>
                            @endif

                        </div>

                    </div>


                    {{-- Unidades --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Unidades
                        </span>

                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $sale->items_sum_quantity }}
                        </span>

                    </div>


                    {{-- Total --}}
                    <div class="flex items-center justify-between border-t border-gray-100 pt-3 dark:border-zinc-800">

                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Total
                        </span>

                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                            ${{ number_format($sale->total, 2) }}
                        </span>

                    </div>

                </div>


                {{-- Acción --}}
                <div class="border-t border-gray-100 px-4 py-3 dark:border-zinc-800">

                    <a href="{{ route('sales.show', $sale) }}" wire:navigate
                        class="flex w-full items-center justify-center rounded-lg px-4 py-2.5 text-sm font-medium text-indigo-600 transition hover:bg-indigo-50 hover:text-indigo-800 dark:text-indigo-400 dark:hover:bg-indigo-950/30">
                        Ver detalle
                    </a>

                </div>

            </article>

        @empty

            <div
                class="rounded-xl border border-gray-200 bg-white px-5 py-12 text-center shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    No se encontraron ventas.
                </p>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Prueba modificando los filtros.
                </p>

            </div>
        @endforelse


        {{-- Paginación móvil --}}
        @if ($sales->hasPages())
            <div class="rounded-xl border border-gray-200 bg-white px-4 py-4 dark:border-zinc-700 dark:bg-zinc-900">

                {{ $sales->links() }}

            </div>
        @endif

    </div>

</div>
