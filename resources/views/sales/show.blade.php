<x-layouts::app :title="'Venta #' . $sale->id">

    <div class="mx-auto max-w-5xl px-6 py-8">

        {{-- Encabezado --}}
        <div class="mb-8 flex items-start justify-between">

            <div>

                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Venta #{{ $sale->id }}
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                </p>

            </div>

            <a href="{{ route('sales.index') }}" wire:navigate
                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-800">
                Volver
            </a>

        </div>

        {{-- Productos --}}
        <div
            class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-zinc-800 dark:bg-zinc-800">

                        <tr>

                            <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                                Producto
                            </th>

                            <th class="px-6 py-4 text-center font-semibold text-gray-700 dark:text-gray-300">
                                Cantidad
                            </th>

                            <th class="px-6 py-4 text-right font-semibold text-gray-700 dark:text-gray-300">
                                Precio
                            </th>

                            <th class="px-6 py-4 text-right font-semibold text-gray-700 dark:text-gray-300">
                                Subtotal
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">

                        @foreach ($sale->items as $item)
                            <tr>

                                <td class="px-6 py-4">

                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $item->product->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Código: {{ $item->product->code }}
                                    </p>

                                </td>

                                <td class="px-6 py-4 text-center text-gray-600 dark:text-gray-400">
                                    {{ $item->quantity }}
                                </td>

                                <td class="px-6 py-4 text-right text-gray-600 dark:text-gray-400">
                                    ${{ number_format($item->price, 2) }}
                                </td>

                                <td class="px-6 py-4 text-right font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($item->subtotal, 2) }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- Total --}}
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-5 dark:border-zinc-700 dark:bg-zinc-800">

                <div class="flex items-center justify-between">

                    <span class="text-base font-medium text-gray-600 dark:text-gray-400">
                        Total
                    </span>

                    <span class="text-2xl font-bold text-gray-900 dark:text-white">
                        ${{ number_format($sale->total, 2) }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</x-layouts::app>
