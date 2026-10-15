<div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8">

    {{-- ENCABEZADO --}}
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
            class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 sm:w-auto">
            Exportar CSV
        </a>
    </div>

    {{-- FILTROS --}}
    <div
        class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <div>
                <label for="period" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Periodo
                </label>

                <select id="period" wire:model.live="period"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="today">Hoy</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mes</option>
                    <option value="custom">Personalizado</option>
                </select>
            </div>

            <div>
                <label for="dateFrom" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Desde
                </label>

                <input id="dateFrom" type="date" wire:model.live="dateFrom"
                    class="w-full min-w-0 rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:px-4">
            </div>

            <div>
                <label for="dateTo" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Hasta
                </label>

                <input id="dateTo" type="date" wire:model.live="dateTo"
                    class="w-full min-w-0 rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:px-4">
            </div>

            <div class="flex items-end">
                <button type="button" wire:click="clearFilters"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    Restablecer filtros
                </button>
            </div>

        </div>
    </div>

    {{-- INDICADORES --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div
            class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Ventas completadas
            </p>

            <p class="mt-2 break-words text-2xl font-bold text-zinc-900 dark:text-white">
                {{ number_format($salesCount) }}
            </p>
        </div>

        <div
            class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Ingresos
            </p>

            <p class="mt-2 break-words text-2xl font-bold text-zinc-900 dark:text-white">
                ${{ number_format($income, 2) }}
            </p>
        </div>

        <div
            class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Unidades vendidas
            </p>

            <p class="mt-2 break-words text-2xl font-bold text-zinc-900 dark:text-white">
                {{ number_format($productsSold) }}
            </p>
        </div>

        <div
            class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Ticket promedio
            </p>

            <p class="mt-2 break-words text-2xl font-bold text-zinc-900 dark:text-white">
                ${{ number_format($averageTicket, 2) }}
            </p>
        </div>

    </div>

    {{-- DÍAS CON MAYOR Y MENOR INGRESO --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6">

        <div
            class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Día con mayor ingreso
            </p>

            @if ($highestSalesDay)
                <p class="mt-2 break-words text-2xl font-bold text-gray-900 dark:text-white">
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

        <div
            class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Día con menor ingreso
            </p>

            @if ($lowestSalesDay)
                <p class="mt-2 break-words text-2xl font-bold text-gray-900 dark:text-white">
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

    {{-- VENTAS POR DÍA --}}
    <section
        class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-gray-200 px-4 py-4 dark:border-gray-700 sm:px-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Ventas por día
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Resumen de ventas completadas durante el periodo seleccionado.
            </p>
        </div>

        @if ($salesByDay->isEmpty())
            <div class="px-4 py-10 text-center sm:px-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No hay ventas completadas en este periodo.
                </p>
            </div>
        @else
            {{-- TARJETAS MÓVILES --}}
            <div class="divide-y divide-gray-200 sm:hidden dark:divide-gray-700">
                @foreach ($salesByDay as $day)
                    <article wire:key="sales-day-card-{{ $day->date }}" class="p-4">
                        <div class="flex items-center justify-between gap-3">
                            <p class="font-semibold text-gray-900 dark:text-white">
                                {{ \Illuminate\Support\Carbon::parse($day->date)->format('d/m/Y') }}
                            </p>

                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($day->total, 2) }}
                            </p>
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Ventas
                                </p>
                                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $day->sales_count }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Ticket promedio
                                </p>
                                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                    ${{ number_format($day->sales_count > 0 ? $day->total / $day->sales_count : 0, 2) }}
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- TABLA TABLET Y ESCRITORIO --}}
            <div class="hidden overflow-x-auto sm:block">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th
                                class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Fecha
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Ventas
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Ingresos
                            </th>
                            <th
                                class="whitespace-nowrap px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Ticket promedio
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($salesByDay as $day)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white sm:px-6">
                                    {{ \Illuminate\Support\Carbon::parse($day->date)->format('d/m/Y') }}
                                </td>

                                <td
                                    class="whitespace-nowrap px-4 py-4 text-center text-sm text-gray-700 dark:text-gray-300 sm:px-6">
                                    {{ $day->sales_count }}
                                </td>

                                <td
                                    class="whitespace-nowrap px-4 py-4 text-right text-sm font-medium text-gray-900 dark:text-white sm:px-6">
                                    ${{ number_format($day->total, 2) }}
                                </td>

                                <td
                                    class="whitespace-nowrap px-4 py-4 text-right text-sm text-gray-700 dark:text-gray-300 sm:px-6">
                                    ${{ number_format($day->sales_count > 0 ? $day->total / $day->sales_count : 0, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    {{-- VENTAS POR MÉTODO DE PAGO --}}
    <section
        class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-gray-200 px-4 py-4 dark:border-gray-700 sm:px-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Ventas por método de pago
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Distribución de las ventas completadas según el método de pago.
            </p>
        </div>

        @if ($salesByPaymentMethod->isEmpty())
            <div class="px-4 py-10 text-center sm:px-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No hay ventas completadas en este periodo.
                </p>
            </div>
        @else
            {{-- TARJETAS MÓVILES --}}
            <div class="divide-y divide-gray-200 sm:hidden dark:divide-gray-700">
                @foreach ($salesByPaymentMethod as $payment)
                    @php
                        $paymentLabel = $payment->payment_method->label();
                    @endphp

                    <article wire:key="payment-card-{{ $loop->index }}" class="p-4">
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $paymentLabel }}
                        </p>

                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Ventas
                                </p>
                                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $payment->sales_count }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Ingresos
                                </p>
                                <p class="mt-1 break-words text-sm font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($payment->total, 2) }}
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- TABLA --}}
            <div class="hidden overflow-x-auto sm:block">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Método de pago
                            </th>
                            <th
                                class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Ventas
                            </th>
                            <th
                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
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
                                <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white sm:px-6">
                                    {{ $paymentLabel }}
                                </td>

                                <td class="px-4 py-4 text-center text-sm text-gray-700 dark:text-gray-300 sm:px-6">
                                    {{ $payment->sales_count }}
                                </td>

                                <td
                                    class="px-4 py-4 text-right text-sm font-medium text-gray-900 dark:text-white sm:px-6">
                                    ${{ number_format($payment->total, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    {{-- PRODUCTOS MÁS VENDIDOS --}}
    <section
        class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-gray-200 px-4 py-4 dark:border-gray-700 sm:px-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                Productos más vendidos
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Los productos con mayor cantidad de unidades vendidas durante el periodo.
            </p>
        </div>

        @if ($topProducts->isEmpty())
            <div class="px-4 py-10 text-center sm:px-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No hay productos vendidos en este periodo.
                </p>
            </div>
        @else
            {{-- TARJETAS MÓVILES --}}
            <div class="divide-y divide-gray-200 sm:hidden dark:divide-gray-700">
                @foreach ($topProducts as $item)
                    <article wire:key="top-product-card-{{ $loop->index }}" class="p-4">
                        <p class="break-words font-semibold text-gray-900 dark:text-white">
                            {{ $item->product?->name ?? 'Producto eliminado' }}
                        </p>

                        @if ($item->product)
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Código: {{ $item->product->code }}
                            </p>
                        @endif

                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Unidades vendidas
                                </p>
                                <p class="mt-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $item->units_sold }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Ingresos
                                </p>
                                <p class="mt-1 break-words text-sm font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($item->revenue, 2) }}
                                </p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- TABLA --}}
            <div class="hidden overflow-x-auto sm:block">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Producto
                            </th>
                            <th
                                class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Unidades
                            </th>
                            <th
                                class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300 sm:px-6">
                                Ingresos
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($topProducts as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                <td class="px-4 py-4 sm:px-6">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $item->product?->name ?? 'Producto eliminado' }}
                                    </div>

                                    @if ($item->product)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Código: {{ $item->product->code }}
                                        </div>
                                    @endif
                                </td>

                                <td
                                    class="px-4 py-4 text-center text-sm font-medium text-gray-700 dark:text-gray-300 sm:px-6">
                                    {{ $item->units_sold }}
                                </td>

                                <td
                                    class="px-4 py-4 text-right text-sm font-medium text-gray-900 dark:text-white sm:px-6">
                                    ${{ number_format($item->revenue, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    {{-- VENTAS DEL PERIODO --}}
    <section
        class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

        <div class="border-b border-gray-200 px-4 py-4 dark:border-gray-700 sm:px-6">
            <h2 class="font-semibold text-gray-900 dark:text-white">
                Ventas del periodo
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Consulta cada operación y accede a su detalle.
            </p>
        </div>

        {{-- TARJETAS MÓVILES --}}
        <div class="divide-y divide-gray-200 lg:hidden dark:divide-gray-700">
            @forelse ($sales as $sale)
                <article wire:key="sale-mobile-{{ $sale->id }}" class="p-4 sm:p-5">

                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <a href="{{ route('sales.show', $sale) }}" wire:navigate
                                class="font-semibold text-indigo-600 hover:underline dark:text-indigo-400">
                                Venta #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                            </a>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        <p class="shrink-0 text-right text-lg font-bold text-gray-900 dark:text-white">
                            ${{ number_format($sale->total, 2) }}
                        </p>
                    </div>

                    <div
                        class="mt-4 grid grid-cols-2 gap-x-4 gap-y-3 border-t border-gray-100 pt-4 dark:border-gray-700">

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Vendedor
                            </p>
                            <p class="mt-1 break-words text-sm text-gray-700 dark:text-gray-300">
                                {{ $sale->user?->name ?? 'Sin usuario' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Unidades
                            </p>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                {{ $sale->items_sum_quantity }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Método de pago
                            </p>
                            <p class="mt-1 break-words text-sm text-gray-700 dark:text-gray-300">
                                {{ $sale->payment_method->label() }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Estado
                            </p>

                            @if ($sale->status === 'cancelled')
                                <span
                                    class="mt-1 inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    Cancelada
                                </span>
                            @else
                                <span
                                    class="mt-1 inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                    Completada
                                </span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('sales.show', $sale) }}" wire:navigate
                        class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                        Ver detalle de venta
                    </a>
                </article>
            @empty
                <div class="px-4 py-12 text-center text-sm text-gray-500 dark:text-gray-400 sm:px-6">
                    No hay ventas en el periodo seleccionado.
                </div>
            @endforelse
        </div>

        {{-- TABLA PARA ESCRITORIO --}}
        <div class="hidden overflow-x-auto lg:block">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th
                            class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 sm:px-6">
                            Venta
                        </th>
                        <th
                            class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 sm:px-6">
                            Fecha
                        </th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-zinc-500 sm:px-6">
                            Vendedor
                        </th>
                        <th
                            class="whitespace-nowrap px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-zinc-500 sm:px-6">
                            Unidades
                        </th>
                        <th
                            class="whitespace-nowrap px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-zinc-500 sm:px-6">
                            Total
                        </th>
                        <th
                            class="whitespace-nowrap px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-zinc-500 sm:px-6">
                            Método
                        </th>
                        <th
                            class="whitespace-nowrap px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-zinc-500 sm:px-6">
                            Estado
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($sales as $sale)
                        <tr wire:key="sale-desktop-{{ $sale->id }}"
                            class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                            <td class="whitespace-nowrap px-4 py-4 sm:px-6">
                                <a href="{{ route('sales.show', $sale) }}" wire:navigate
                                    class="font-medium text-indigo-600 hover:underline dark:text-indigo-400">
                                    #{{ str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                                </a>
                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-sm text-zinc-600 dark:text-zinc-400 sm:px-6">
                                {{ $sale->created_at->timezone('America/Mexico_City')->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-4 py-4 text-sm text-zinc-700 dark:text-zinc-300 sm:px-6">
                                {{ $sale->user?->name ?? 'Sin usuario' }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm text-zinc-600 dark:text-zinc-400 sm:px-6">
                                {{ $sale->items_sum_quantity }}
                            </td>

                            <td
                                class="whitespace-nowrap px-4 py-4 text-right text-sm font-medium text-zinc-900 dark:text-white sm:px-6">
                                ${{ number_format($sale->total, 2) }}
                            </td>

                            <td class="px-4 py-4 text-center text-sm text-zinc-600 dark:text-zinc-400 sm:px-6">
                                {{ $sale->payment_method->label() }}
                            </td>

                            <td class="px-4 py-4 text-center sm:px-6">
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
                                class="px-4 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400 sm:px-6">
                                No hay ventas en el periodo seleccionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        @if ($sales->hasPages())
            <div class="border-t border-zinc-200 px-4 py-4 dark:border-zinc-700 sm:px-6">
                {{ $sales->links() }}
            </div>
        @endif

    </section>

</div>
