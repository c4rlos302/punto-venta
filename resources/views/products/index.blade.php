<x-layouts::app :title="__('Productos')">

    <div class="mx-auto max-w-7xl px-6 py-8">

        {{-- Encabezado --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Productos
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Administra los productos de tu inventario.
                </p>
            </div>

            <a href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                + Nuevo producto
            </a>

        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Resumen --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        Total de productos
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $products->count() }}
                    </p>
                </div>

                <div class="flex justify-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-10 w-10">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m20.25 7.5-8.25-4.5-8.25 4.5m16.5 0v9L12 21l-8.25-4.5v-9m16.5 0L12 12m0 0L3.75 7.5M12 12v9" />

                    </svg>
                </div>

            </div>

        </div>

        {{-- Tabla --}}
        <div
            class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">

                    <thead class="bg-gray-50 dark:bg-zinc-800">

                        <tr>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Código
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Producto
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Categoría
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Precio
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Stock
                            </th>

                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">

                        @forelse ($products as $product)
                            <tr class="transition hover:bg-gray-50 dark:hover:bg-zinc-800">

                                {{-- Código --}}
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $product->code }}
                                </td>

                                {{-- Nombre --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $product->name }}
                                    </div>

                                </td>

                                {{-- Categoría --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $product->category->name }}
                                </td>

                                {{-- Precio --}}
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($product->price, 2) }}
                                </td>

                                {{-- Stock --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $product->stock }}
                                        </span>

                                        @if ($product->stock > 10)
                                            <span
                                                class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                Disponible
                                            </span>
                                        @elseif ($product->stock > 0)
                                            <span
                                                class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-700">
                                                Stock bajo
                                            </span>
                                        @else
                                            <span
                                                class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                                Agotado
                                            </span>
                                        @endif

                                    </div>

                                </td>

                                {{-- Acciones --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <div class="flex justify-end gap-3">

                                        <a href="{{ route('products.edit', $product) }}"
                                            class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                            Editar
                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-sm font-medium text-red-600 hover:text-red-800">
                                                Eliminar
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-12 text-center">

                                    <div class="mb-3 text-4xl text-gray-400">
                                        📦
                                    </div>

                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        No hay productos registrados.
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        Comienza agregando tu primer producto.
                                    </p>

                                    <a href="{{ route('products.create') }}"
                                        class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:text-indigo-800">
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
