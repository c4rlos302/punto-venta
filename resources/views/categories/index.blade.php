@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">

            <div>
                <h2 class="text-3xl font-bold text-gray-900">
                    Categorías
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Organiza los productos de tu inventario.
                </p>
            </div>

            <a href="{{ route('categories.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                + Nueva categoría
            </a>

        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Categoría
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Descripción
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Productos
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse ($categories as $category)
                            <tr class="transition hover:bg-gray-50">

                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    {{ $category->name }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $category->description ?? 'Sin descripción' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $category->products_count }}
                                </td>

                                <td class="px-6 py-4 text-right">

                                    <div class="flex justify-end gap-3">

                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                            Editar
                                        </a>

                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
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
                                <td colspan="4" class="px-6 py-12 text-center">

                                    <p class="text-sm font-medium text-gray-900">
                                        No hay categorías registradas.
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Crea una categoría para comenzar a organizar tus productos.
                                    </p>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
