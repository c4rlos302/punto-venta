<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- ENCABEZADO --}}
    <div class="mb-8">

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Historial de inventario
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Consulta todos los movimientos realizados en el inventario.
        </p>

    </div>


    {{-- FILTROS --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <div class="grid gap-4 md:grid-cols-4">

            {{-- BUSCAR --}}
            <div>

                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Producto
                </label>

                <input id="search" type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Nombre o código..."
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

            </div>


            {{-- TIPO --}}
            <div>

                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Tipo
                </label>

                <select id="type" wire:model.live="type"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                    <option value="">
                        Todos
                    </option>

                    <option value="entrada">
                        Entrada
                    </option>

                    <option value="salida">
                        Salida
                    </option>

                    <option value="ajuste">
                        Ajuste
                    </option>

                </select>

            </div>


            {{-- DESDE --}}
            <div>

                <label for="dateFrom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Desde
                </label>

                <input id="dateFrom" type="date" wire:model.live="dateFrom"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

            </div>


            {{-- HASTA --}}
            <div>

                <label for="dateTo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Hasta
                </label>

                <input id="dateTo" type="date" wire:model.live="dateTo"
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

            </div>

        </div>


        {{-- LIMPIAR --}}
        @if ($search || $type || $dateFrom || $dateTo)
            <div class="mt-4">

                <button type="button" wire:click="clearFilters"
                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                    Limpiar filtros
                </button>

            </div>
        @endif

    </div>


    {{-- TABLA --}}
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-gray-200 bg-gray-50 dark:border-zinc-700 dark:bg-zinc-800">

                    <tr>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Fecha
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Producto
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Tipo
                        </th>

                        <th class="px-6 py-4 text-center font-semibold text-gray-700 dark:text-gray-300">
                            Movimiento
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Motivo
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Usuario
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">

                    @forelse ($movements as $movement)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-zinc-800">

                            {{-- FECHA --}}
                            <td class="whitespace-nowrap px-6 py-4 text-gray-600 dark:text-gray-400">

                                {{ $movement->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}

                            </td>


                            {{-- PRODUCTO --}}
                            <td class="px-6 py-4">

                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $movement->product->name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $movement->product->code }}
                                </p>

                            </td>


                            {{-- TIPO --}}
                            <td class="px-6 py-4">

                                @if ($movement->type === 'entrada')
                                    <span
                                        class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-950 dark:text-green-300">
                                        Entrada
                                    </span>
                                @elseif ($movement->type === 'salida')
                                    <span
                                        class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-950 dark:text-red-300">
                                        Salida
                                    </span>
                                @else
                                    <span
                                        class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300">
                                        Ajuste
                                    </span>
                                @endif

                            </td>


                            {{-- MOVIMIENTO --}}
                            <td class="px-6 py-4 text-center">

                                <p class="font-semibold text-gray-900 dark:text-white">

                                    @if ($movement->quantity > 0)
                                        +{{ $movement->quantity }}
                                    @else
                                        {{ $movement->quantity }}
                                    @endif

                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $movement->stock_before }}
                                    →
                                    {{ $movement->stock_after }}
                                </p>

                            </td>


                            {{-- MOTIVO --}}
                            <td class="px-6 py-4">

                                @if ($movement->sale)
                                    <a href="{{ route('sales.show', $movement->sale) }}" wire:navigate
                                        class="font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                        Venta #{{ $movement->sale->id }}
                                    </a>
                                @elseif ($movement->reason)
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ $movement->reason }}
                                    </span>
                                @else
                                    <span class="text-gray-400">
                                        Sin motivo

                                    </span>
                                @endif

                            </td>
                            
                            {{-- USUARIO --}}
                            <td class="px-6 py-4">
                                @if ($movement->user)
                                    <div class="font-medium text-zinc-900 dark:text-white">
                                        {{ $movement->user->name }}
                                    </div>

                                    <div class="text-xs text-zinc-500">
                                        {{ $movement->user->email }}
                                    </div>
                                @else
                                    <span class="text-zinc-400">
                                        Usuario no disponible
                                    </span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-12 text-center">

                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    No hay movimientos registrados.
                                </p>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Los movimientos de inventario aparecerán aquí.
                                </p>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}
        @if ($movements->hasPages())
            <div class="border-t border-gray-200 px-6 py-4 dark:border-zinc-700">

                {{ $movements->links() }}

            </div>
        @endif

    </div>

</div>
