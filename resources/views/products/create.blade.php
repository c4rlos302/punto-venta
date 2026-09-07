@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-6 py-8">

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ isset($product) ? 'Editar producto' : 'Nuevo producto' }}
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                {{ isset($product) ? 'Modifica la información del producto.' : 'Registra un nuevo producto en el inventario.' }}
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}"
                method="POST">

                @csrf

                @if (isset($product))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Código -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            Código
                        </label>

                        <input type="text" id="code" name="code" value="{{ old('code', $product->code ?? '') }}"
                            placeholder="Ej. 001"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
               outline-none transition">

                        @error('code')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre
                        </label>

                        <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}"
                            placeholder="Ej. Coca-Cola"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                           outline-none transition">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">
                            Categoría
                        </label>

                        <select id="category_id" name="category_id"
                            class="mt-2 block w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                            <option value="">
                                Selecciona una categoría
                            </option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Precio -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Precio
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                                $
                            </span>

                            <input type="number" id="price" name="price"
                                value="{{ old('price', $product->price ?? '') }}" step="0.01" min="0"
                                placeholder="0.00"
                                class="w-full rounded-lg border border-gray-300 pl-8 pr-4 py-2.5 text-sm
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                               outline-none transition">

                            @error('price')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                            Stock
                        </label>

                        <input type="number" id="stock" name="stock"
                            value="{{ old('stock', $product->stock ?? '') }}" min="0" placeholder="Ej. 25"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                           outline-none transition">

                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">

                    <a href="{{ route('products.index') }}"
                        class="px-4 py-2.5 rounded-lg border border-gray-300
                       text-sm font-medium text-gray-700
                       hover:bg-gray-50 transition">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-indigo-600
                        text-sm font-medium text-white
                        hover:bg-indigo-700
                        focus:outline-none focus:ring-2 focus:ring-indigo-300
                        transition">
                        {{ isset($product) ? 'Actualizar producto' : 'Guardar producto' }}
                    </button>

                </div>

            </form>

        </div>

    </div>
@endsection
