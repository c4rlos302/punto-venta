@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-6 py-8">

        <div class="mb-8">

            <h2 class="text-3xl font-bold text-gray-900">
                {{ isset($category) ? 'Editar categoría' : 'Nueva categoría' }}
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                {{ isset($category)
                    ? 'Modifica la información de la categoría.'
                    : 'Registra una nueva categoría para tus productos.' }}
            </p>

        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <form
                action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}"
                method="POST">

                @csrf

                @if (isset($category))
                    @method('PUT')
                @endif

                <div class="space-y-6">

                    <div>

                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nombre
                        </label>

                        <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}"
                            class="mt-2 block w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej. Bebidas">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div>

                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Descripción
                        </label>

                        <textarea id="description" name="description" rows="4"
                            class="mt-2 block w-full rounded-lg border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Describe brevemente esta categoría...">{{ old('description', $category->description ?? '') }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('categories.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                        {{ isset($category) ? 'Actualizar categoría' : 'Guardar categoría' }}
                    </button>

                </div>

            </form>

        </div>

    </div>
@endsection
