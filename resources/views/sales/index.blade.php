<x-layouts::app :title="'Historial de ventas'">

    <div class="mx-auto max-w-7xl px-6 py-8">

        {{-- Encabezado --}}
        <div class="mb-8">

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Historial de ventas
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Consulta las ventas realizadas.
            </p>

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
                                    {{ $sale->created_at->format('d/m/Y H:i') }}
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
                                        No hay ventas registradas.
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Las ventas que realices aparecerán aquí.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-layouts::app>
