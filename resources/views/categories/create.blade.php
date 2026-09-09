<x-layouts::app :title="__(isset($category) ? 'Editar categoría' : 'Nueva categoría')">

    <div class="mx-auto max-w-3xl px-6 py-8">

        <div class="mb-8">

            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ isset($category) ? 'Editar categoría' : 'Nueva categoría' }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ isset($category)
                    ? 'Modifica la información de la categoría.'
                    : 'Registra una nueva categoría para tus productos.' }}
            </p>

        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}"
                method="POST">

                @csrf

                @if (isset($category))
                    @method('PUT')
                @endif

                <div class="space-y-6">

                    {{-- Nombre --}}
                    <div>

                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nombre
                        </label>

                        <input type="text" id="name" name="name"
                            value="{{ old('name', $category->name ?? '') }}" placeholder="Ej. Bebidas"
                            class="mt-2 block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Descripción --}}
                    <div>

                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Descripción
                        </label>

                        <textarea id="description" name="description" rows="4" placeholder="Describe brevemente esta categoría..."
                            class="mt-2 block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">{{ old('description', $category->description ?? '') }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- Botones --}}
                <div class="mt-8 flex justify-end gap-3 border-t border-gray-200 pt-6 dark:border-zinc-700">

                    <a href="{{ route('categories.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-800">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        {{ isset($category) ? 'Actualizar categoría' : 'Guardar categoría' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>
