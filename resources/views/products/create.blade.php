<x-layouts::app :title="__(isset($product) ? 'Editar producto' : 'Nuevo producto')">

    <div class="mx-auto max-w-3xl px-6 py-8">

        <div class="mb-8">

            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ isset($product) ? 'Editar producto' : 'Nuevo producto' }}
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ isset($product) ? 'Modifica la información del producto.' : 'Registra un nuevo producto en el inventario.' }}
            </p>

        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

            <form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}"
                method="POST">

                @csrf

                @if (isset($product))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Código --}}
                    <div>

                        <label for="code" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Código
                        </label>

                        <input type="text" id="code" name="code"
                            value="{{ old('code', $product->code ?? '') }}" placeholder="Ej. 001"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                        @error('code')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Nombre --}}
                    <div>

                        <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nombre
                        </label>

                        <input type="text" id="name" name="name"
                            value="{{ old('name', $product->name ?? '') }}" placeholder="Ej. Coca-Cola"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Categoría --}}
                    <div>

                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Categoría
                        </label>

                        <select id="category_id" name="category_id"
                            class="mt-2 block w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

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

                    {{-- Precio --}}
                    <div>

                        <label for="price" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Precio
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                                $
                            </span>

                            <input type="number" id="price" name="price"
                                value="{{ old('price', $product->price ?? '') }}" step="0.01" min="0"
                                placeholder="0.00"
                                class="w-full rounded-lg border border-gray-300 py-2.5 pl-8 pr-4 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                        </div>

                        @error('price')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Stock --}}
                    <div>

                        <label for="stock" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Stock
                        </label>

                        <input type="number" id="stock" name="stock"
                            value="{{ old('stock', $product->stock ?? '') }}" min="0" placeholder="Ej. 25"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- Botones --}}
                <div class="mt-8 flex justify-end gap-3 border-t border-gray-200 pt-6 dark:border-zinc-700">

                    <a href="{{ route('products.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-800">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        {{ isset($product) ? 'Actualizar producto' : 'Guardar producto' }}
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts::app>
