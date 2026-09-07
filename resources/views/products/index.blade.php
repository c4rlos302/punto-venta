@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Encabezado --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">

            <div>
                <h2 class="text-3xl font-bold text-gray-900">
                    Productos
                </h2>

                <p class="mt-1 text-sm text-gray-500">
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
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total de productos
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ $products->count() }}
                    </p>
                </div>

                <div class="mb-3 flex justify-center text-gray-400">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m20.25 7.5-8.25-4.5-8.25 4.5m16.5 0v9L12 21l-8.25-4.5v-9m16.5 0L12 12m0 0L3.75 7.5M12 12v9" />
                    </svg>

                </div>

            </div>

        </div>


        {{-- Tabla --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Código
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Producto
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Categoría
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Precio
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Stock
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Acciones
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200 bg-white">

                        @forelse ($products as $product)
                            <tr class="transition hover:bg-gray-50">

                                {{-- Código --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $product->code }}
                                </td>


                                {{-- Nombre --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $product->name }}
                                    </div>

                                </td>


                                {{-- Categoría --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ $product->category->name }}
                                </td>


                                {{-- Precio --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">
                                    ${{ number_format($product->price, 2) }}
                                </td>


                                {{-- Stock --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <span class="text-sm font-medium text-gray-900">
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

                                    <div class="text-gray-400 text-4xl mb-3">
                                        📦
                                    </div>

                                    <p class="text-sm font-medium text-gray-900">
                                        No hay productos registrados.
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
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
@endsection
