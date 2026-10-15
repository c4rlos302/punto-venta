<x-layouts::app :title="__('Productos')">

    <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8">

        {{-- Encabezado --}}
        <div class="mb-8 flex min-w-0 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="min-w-0">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl">
                    Productos
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Administra los productos de tu inventario.
                </p>
            </div>

            <a href="{{ route('products.create') }}"
                class="inline-flex w-full shrink-0 items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 sm:w-auto">
                + Nuevo producto
            </a>

        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div
                class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/20 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        {{-- Resumen --}}
        <div
            class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 sm:p-6">

            <div class="flex items-center justify-between gap-4">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total de productos
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $products->count() }}
                    </p>
                </div>

                <div class="shrink-0 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-9 w-9 sm:h-10 sm:w-10">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m20.25 7.5-8.25-4.5-8.25 4.5m16.5 0v9L12 21l-8.25-4.5v-9m16.5 0L12 12m0 0L3.75 7.5M12 12v9" />

                    </svg>
                </div>

            </div>

        </div>

        {{-- Productos: tarjetas para móviles y tablets pequeñas --}}
        <div class="space-y-3 lg:hidden">

            @forelse ($products as $product)
                <article
                    class="min-w-0 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                    {{-- Nombre y código --}}
                    <div class="flex min-w-0 items-start justify-between gap-3">

                        <div class="min-w-0 flex-1">

                            <h3 class="break-words text-base font-semibold text-gray-900 dark:text-white">
                                {{ $product->name }}
                            </h3>

                            <p class="mt-1 break-words text-xs text-gray-500 dark:text-gray-400">
                                Código: {{ $product->code }}
                            </p>

                        </div>

                        <p class="shrink-0 text-right text-base font-bold text-gray-900 dark:text-white">
                            ${{ number_format($product->price, 2) }}
                        </p>

                    </div>

                    {{-- Categoría --}}
                    <div class="mt-4 border-t border-gray-100 pt-3 dark:border-zinc-700">

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Categoría
                        </p>

                        <p class="mt-1 break-words text-sm text-gray-900 dark:text-white">
                            {{ $product->category?->name ?? 'Sin categoría' }}
                        </p>

                    </div>

                    {{-- Existencias --}}
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">

                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                Existencias
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $product->stock }} unidades
                            </p>
                        </div>

                        @if ($product->stock > 10)
                            <span
                                class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                Disponible
                            </span>
                        @elseif ($product->stock > 0)
                            <span
                                class="inline-flex rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                Stock bajo
                            </span>
                        @else
                            <span
                                class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                Agotado
                            </span>
                        @endif

                    </div>

                    {{-- Acciones --}}
                    <div class="mt-4 grid grid-cols-2 gap-3 border-t border-gray-100 pt-3 dark:border-zinc-700">

                        <a href="{{ route('products.edit', $product) }}"
                            class="inline-flex items-center justify-center rounded-lg border border-indigo-200 px-3 py-2.5 text-sm font-medium text-indigo-700 transition hover:bg-indigo-50 dark:border-indigo-900 dark:text-indigo-400 dark:hover:bg-indigo-950">
                            Editar
                        </a>

                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex w-full items-center justify-center rounded-lg border border-red-200 px-3 py-2.5 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-900 dark:text-red-400 dark:hover:bg-red-950">
                                Eliminar
                            </button>

                        </form>

                    </div>

                </article>

            @empty

                <div
                    class="rounded-xl border border-gray-200 bg-white px-4 py-10 text-center shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                    <p class="text-base font-semibold text-gray-900 dark:text-white">
                        No hay productos registrados.
                    </p>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Comienza agregando tu primer producto.
                    </p>

                    <a href="{{ route('products.create') }}"
                        class="mt-4 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        Crear producto
                    </a>

                </div>
            @endforelse

        </div>

        {{-- Tabla para escritorio --}}
        <div
            class="hidden overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900 lg:block">

            <div class="overflow-x-auto">

                <table class="w-full divide-y divide-gray-200 dark:divide-zinc-700">

                    <thead class="bg-gray-50 dark:bg-zinc-800">

                        <tr>

                            <th
                                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 xl:px-6">
                                Código
                            </th>

                            <th
                                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 xl:px-6">
                                Producto
                            </th>

                            <th
                                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 xl:px-6">
                                Categoría
                            </th>

                            <th
                                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 xl:px-6">
                                Precio
                            </th>

                            <th
                                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 xl:px-6">
                                Stock
                            </th>

                            <th
                                class="px-4 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 xl:px-6">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">

                        @forelse ($products as $product)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-zinc-800">

                                {{-- Código --}}
                                <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-white xl:px-6">
                                    {{ $product->code }}
                                </td>

                                {{-- Nombre --}}
                                <td class="px-4 py-4">
                                    <div
                                        class="max-w-xs break-words text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $product->name }}
                                    </div>
                                </td>

                                {{-- Categoría --}}
                                <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $product->category?->name ?? 'Sin categoría' }}
                                </td>

                                {{-- Precio --}}
                                <td
                                    class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-gray-900 dark:text-white xl:px-6">
                                    ${{ number_format($product->price, 2) }}
                                </td>

                                {{-- Stock --}}
                                <td class="px-4 py-4">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $product->stock }}
                                        </span>

                                        @if ($product->stock > 10)
                                            <span
                                                class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                                Disponible
                                            </span>
                                        @elseif ($product->stock > 0)
                                            <span
                                                class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                Stock bajo
                                            </span>
                                        @else
                                            <span
                                                class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                Agotado
                                            </span>
                                        @endif

                                    </div>

                                </td>

                                {{-- Acciones --}}
                                <td class="whitespace-nowrap px-4 py-4 text-right xl:px-6">

                                    <div class="flex justify-end gap-3">

                                        <a href="{{ route('products.edit', $product) }}"
                                            class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Editar
                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                Eliminar
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">

                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        No hay productos registrados.
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Comienza agregando tu primer producto.
                                    </p>

                                    <a href="{{ route('products.create') }}"
                                        class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                        Crear producto
                                    </a>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-layouts::app>
