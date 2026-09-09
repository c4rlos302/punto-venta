<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Encabezado --}}
    <div class="mb-8">

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Nueva venta
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Selecciona los productos para agregarlos al carrito.
        </p>

    </div>
    @if (session('success'))
        <div
            class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-950 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-950 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- PRODUCTOS --}}
        <div class="lg:col-span-2">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                {{-- Buscador --}}
                <div class="mb-6">

                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Buscar producto
                    </label>

                    <input id="search" type="text" wire:model.live="search"
                        placeholder="Buscar por nombre o código..."
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                </div>

                {{-- Lista de productos --}}
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                    @forelse ($products as $product)
                        <button type="button" wire:click="addProduct({{ $product->id }})" @disabled($product->stock <= 0)
                            class="rounded-xl border border-gray-200 p-4 text-left transition hover:border-indigo-300 hover:bg-indigo-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-zinc-700 dark:hover:border-indigo-500 dark:hover:bg-zinc-800">

                            <div class="flex items-start justify-between gap-3">

                                <div>

                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $product->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Código: {{ $product->code }}
                                    </p>

                                </div>

                                <span class="text-sm font-semibold text-indigo-600">
                                    ${{ number_format($product->price, 2) }}
                                </span>

                            </div>

                            <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                Stock disponible: {{ $product->stock }}
                            </p>

                        </button>

                    @empty

                        <div class="col-span-full py-10 text-center">

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                No se encontraron productos.
                            </p>

                        </div>
                    @endforelse

                </div>

            </div>

        </div>

        {{-- CARRITO --}}
        <div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                {{-- Encabezado carrito --}}
                <div class="mb-6 flex items-center justify-between">

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Carrito
                    </h2>

                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ count($cart) }} productos
                    </span>

                </div>

                @if (count($cart) > 0)

                    {{-- Productos del carrito --}}
                    <div class="space-y-4">

                        @foreach ($cart as $item)
                            <div class="border-b border-gray-100 pb-4 dark:border-zinc-700">

                                <div class="flex justify-between gap-4">

                                    <div>

                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ $item['name'] }}
                                        </p>

                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            ${{ number_format($item['price'], 2) }} c/u
                                        </p>

                                    </div>

                                    <button type="button" wire:click="removeProduct({{ $item['id'] }})"
                                        class="text-sm text-red-600 hover:text-red-800">
                                        Eliminar
                                    </button>

                                </div>

                                <div class="mt-3 flex items-center justify-between">

                                    {{-- Cantidad --}}
                                    <div
                                        class="flex items-center rounded-lg border border-gray-200 dark:border-zinc-600">

                                        <button type="button" wire:click="decreaseQuantity({{ $item['id'] }})"
                                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-zinc-800">
                                            −
                                        </button>

                                        <span class="px-3 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $item['quantity'] }}
                                        </span>

                                        <button type="button" wire:click="increaseQuantity({{ $item['id'] }})"
                                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-zinc-800">
                                            +
                                        </button>

                                    </div>

                                    {{-- Subtotal --}}
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                    </span>

                                </div>

                            </div>
                        @endforeach

                    </div>

                    {{-- Total --}}
                    <div class="mt-6 border-t border-gray-200 pt-4 dark:border-zinc-700">

                        <div class="flex items-center justify-between">

                            <span class="text-base font-medium text-gray-600 dark:text-gray-400">
                                Total
                            </span>

                            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                ${{ number_format($this->total, 2) }}
                            </span>

                        </div>

                        {{-- Cobrar --}}
                        <button type="button" wire:click="checkout" wire:loading.attr="disabled"
                            class="mt-5 w-full rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50">

                            <span wire:loading.remove wire:target="checkout">
                                Cobrar
                            </span>

                            <span wire:loading wire:target="checkout">
                                Procesando...
                            </span>

                        </button>

                    </div>
                @else
                    {{-- Carrito vacío --}}
                    <div class="py-10 text-center">

                        <div class="mb-3 text-4xl">
                            🛒
                        </div>

                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            El carrito está vacío
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Selecciona un producto para comenzar.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>
