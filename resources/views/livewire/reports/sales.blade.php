<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Encabezado --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Reporte de ventas
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Consulta y analiza las ventas del periodo seleccionado.
            </p>
        </div>

        <a href="{{ route('reports.sales.export', [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ]) }}"
            class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
            Exportar CSV
        </a>

    </div>


    {{-- Filtros --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

            {{-- Periodo --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Periodo
                </label>

                <select wire:model.live="period"
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="today">Hoy</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mes</option>
                    <option value="custom">Personalizado</option>
                </select>
            </div>

            {{-- Desde --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Desde
                </label>

                <input type="date" wire:model.live="dateFrom"
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Hasta --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Hasta
                </label>

                <input type="date" wire:model.live="dateTo"
                    class="w-full rounded-lg border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
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


    {{-- Indicadores --}}
    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Ventas --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Ventas completadas
            </p>

            <p class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">
                {{ number_format($salesCount) }}
            </p>

        </div>


        {{-- Ingresos --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Ingresos
            </p>

            <p class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">
                ${{ number_format($income, 2) }}
            </p>

        </div>


        {{-- Productos --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Unidades vendidas
            </p>

            <p class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">
                {{ number_format($productsSold) }}
            </p>

        </div>


        {{-- Ticket promedio --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Ticket promedio
            </p>

            <p class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">
                ${{ number_format($averageTicket, 2) }}
            </p>

        </div>

    </div>

    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">

        {{-- Mayor ingreso --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Día con mayor ingreso
                    </p>

                    @if ($highestSalesDay)
                        <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($highestSalesDay->total, 2) }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ \Illuminate\Support\Carbon::parse($highestSalesDay->date)->format('d/m/Y') }}
                        </p>
                    @else
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Sin información
                        </p>
                    @endif

                </div>

            </div>

        </div>


        {{-- Menor ingreso --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Día con menor ingreso
                    </p>

                    @if ($lowestSalesDay)
                        <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($lowestSalesDay->total, 2) }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ \Illuminate\Support\Carbon::parse($lowestSalesDay->date)->format('d/m/Y') }}
                        </p>
                    @else
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Sin información
                        </p>
                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- Ventas por dia --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Ventas por día
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Resumen de ventas completadas durante el periodo seleccionado.
            </p>
        </div>

        <div class="overflow-x-auto">

            @if ($salesByDay->isEmpty())

                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No hay ventas completadas en este periodo.
                    </p>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                    <thead class="bg-gray-50 dark:bg-gray-700/50">

                        <tr>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Fecha
                            </th>

                            <th
                                class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Ventas
                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Ingresos
                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Ticket promedio
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                        @foreach ($salesByDay as $day)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ \Illuminate\Support\Carbon::parse($day->date)->format('d/m/Y') }}
                                </td>

                                <td
                                    class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                    {{ $day->sales_count }}
                                </td>

                                <td
                                    class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">
                                    ${{ number_format($day->total, 2) }}
                                </td>

                                <td class="px-6 py-4 text-right text-sm text-gray-700 dark:text-gray-300">
                                    ${{ number_format($day->sales_count > 0 ? $day->total / $day->sales_count : 0, 2) }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            @endif

        </div>

    </div>

    {{-- Ventas por método de pago --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Ventas por método de pago
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Distribución de las ventas completadas según el método de pago.
            </p>
        </div>

        <div class="overflow-x-auto">

            @if ($salesByPaymentMethod->isEmpty())

                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No hay ventas completadas en este periodo.
                    </p>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                    <thead class="bg-gray-50 dark:bg-gray-700/50">

                        <tr>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Método de pago
                            </th>

                            <th
                                class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Ventas
                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Ingresos
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                        @foreach ($salesByPaymentMethod as $payment)
                            @php
                                $paymentLabel = $payment->payment_method->label();
                            @endphp

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">

                                <td class="px-6 py-4">

                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $paymentLabel }}
                                    </span>

                                </td>

                                <td class="px-6 py-4 text-center text-sm text-gray-700 dark:text-gray-300">
                                    {{ $payment->sales_count }}
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">
                                    ${{ number_format($payment->total, 2) }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            @endif

        </div>

    </div>

    {{-- Productos mas vendidos --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Productos más vendidos
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Los productos con mayor cantidad de unidades vendidas durante el periodo.
            </p>
        </div>

        <div class="overflow-x-auto">

            @if ($topProducts->isEmpty())

                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        No hay productos vendidos en este periodo.
                    </p>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                    <thead class="bg-gray-50 dark:bg-gray-700/50">

                        <tr>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Producto
                            </th>

                            <th
                                class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Unidades
                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                Ingresos
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                        @foreach ($topProducts as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">

                                <td class="px-6 py-4">

                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $item->product?->name ?? 'Producto eliminado' }}
                                    </div>

                                    @if ($item->product)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Código: {{ $item->product->code }}
                                        </div>
                                    @endif

                                </td>

                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $item->units_sold }}
                                </td>

                                <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">
                                    ${{ number_format($item->revenue, 2) }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            @endif

        </div>

    </div>

    {{-- Tabla --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-zinc-200 px-6 py-4 dark:border-zinc-700">

            <h2 class="font-semibold text-zinc-900 dark:text-white">
                Ventas del periodo
            </h2>

        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">

                <thead class="bg-zinc-50 dark:bg-zinc-800">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            Venta
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            Fecha
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            Vendedor
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            Unidades
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            Total
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            Método
                        </th>

                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide text-zinc-500">
                            Estado
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">

                    @forelse ($sales as $sale)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                            <td class="px-6 py-4">

                                <a href="{{ route('sales.show', $sale) }}" wire:navigate
                                    class="font-medium text-indigo-600 hover:underline dark:text-indigo-400">
                                    #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                                </a>

                            </td>


                            <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">

                                {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}

                            </td>


                            <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">

                                {{ $sale->user?->name ?? 'Sin usuario' }}

                            </td>


                            <td class="px-6 py-4 text-center text-sm text-zinc-600 dark:text-zinc-400">

                                {{ $sale->items_sum_quantity }}

                            </td>


                            <td class="px-6 py-4 text-right text-sm font-medium text-zinc-900 dark:text-white">

                                ${{ number_format($sale->total, 2) }}

                            </td>


                            <td class="px-6 py-4 text-center text-sm text-zinc-600 dark:text-zinc-400">

                                {{ $sale->payment_method->label() }}

                            </td>


                            <td class="px-6 py-4 text-center">

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

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                No hay ventas en el periodo seleccionado.
                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Paginación --}}
        @if ($sales->hasPages())
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-700">
                {{ $sales->links() }}
            </div>
        @endif

    </div>

</div>
