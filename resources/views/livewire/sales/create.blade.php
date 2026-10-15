<div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    {{-- =========================================================
         ENCABEZADO
         ========================================================= --}}
    <div class="mb-6">

        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    Nueva venta
                </h1>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    Selecciona los productos para agregarlos al carrito.
                </p>
            </div>

            @if (count($cart) > 0)
                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                    {{ count($cart) }} {{ count($cart) === 1 ? 'producto' : 'productos' }}
                </div>
            @endif

        </div>

    </div>


    {{-- =========================================================
         MENSAJES
         ========================================================= --}}
    @if (session('success'))
        <div
            class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-950/40 dark:text-green-300">

            <flux:icon name="check-circle" variant="mini" class="mt-0.5 shrink-0" />

            <span>
                {{ session('success') }}
            </span>

        </div>
    @endif


    @if (session('error'))
        <div
            class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-950/40 dark:text-red-300">

            <flux:icon name="exclamation-circle" variant="mini" class="mt-0.5 shrink-0" />

            <span>
                {{ session('error') }}
            </span>

        </div>
    @endif


    {{-- =========================================================
         CONTENIDO PRINCIPAL
         ========================================================= --}}
    <div class="grid min-w-0 items-start gap-6 lg:grid-cols-3">


        {{-- =====================================================
             PRODUCTOS
             ===================================================== --}}
        <section class="min-w-0 lg:col-span-2">

            <div
                class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                {{-- -------------------------------------------------
                     CABECERA PRODUCTOS
                     ------------------------------------------------- --}}
                <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-700">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                            <flux:icon name="cube" class="size-5" />
                        </div>

                        <div>

                            <h2 class="font-semibold text-zinc-900 dark:text-white">
                                Productos
                            </h2>

                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                Busca y selecciona un producto
                            </p>

                        </div>

                    </div>

                </div>


                {{-- -------------------------------------------------
                     BUSCADOR
                     ------------------------------------------------- --}}
                <div class="border-b border-zinc-200 p-5 dark:border-zinc-700">

                    <label for="search" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Buscar producto
                    </label>

                    <div class="relative">

                        <flux:icon name="magnifying-glass"
                            class="pointer-events-none absolute start-3 top-1/2 z-10 size-5 -translate-y-1/2 text-zinc-400" />

                        <input id="search" type="text" wire:model.live="search"
                            placeholder="Buscar por nombre o código..." autocomplete="off"
                            class="block w-full rounded-xl border border-zinc-300 bg-white py-3 ps-10 pe-4 text-sm text-zinc-900 outline-none transition placeholder:text-zinc-400 focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:focus:border-zinc-400 dark:focus:ring-zinc-700" />

                    </div>

                </div>


                {{-- -------------------------------------------------
                     LISTA DE PRODUCTOS
                     ------------------------------------------------- --}}
                <div class="p-5">

                    <div class="grid min-w-0 grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">

                        @forelse ($products as $product)
                            <button type="button" wire:click="addProduct({{ $product->id }})"
                                @disabled($product->stock <= 0)
                                class="group rounded-xl border border-zinc-200 bg-white p-4 text-left transition hover:-translate-y-0.5 hover:border-zinc-400 hover:shadow-sm disabled:cursor-not-allowed disabled:opacity-50 dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-500">

                                {{-- Producto --}}
                                <div class="flex min-w-0 items-start justify-between gap-3">

                                    <div class="min-w-0">

                                        <p class="truncate font-semibold text-zinc-900 dark:text-white">
                                            {{ $product->name }}
                                        </p>

                                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                            {{ $product->code }}
                                        </p>

                                    </div>

                                    <flux:icon name="plus-circle"
                                        class="size-5 shrink-0 text-zinc-300 transition group-hover:text-zinc-700 dark:text-zinc-600 dark:group-hover:text-zinc-300" />

                                </div>


                                {{-- Precio --}}
                                <div class="mt-4">

                                    <span class="text-lg font-bold text-zinc-900 dark:text-white">
                                        ${{ number_format($product->price, 2) }}
                                    </span>

                                </div>


                                {{-- Stock --}}
                                <div class="mt-3 flex items-center justify-between">

                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                        Stock
                                    </span>

                                    @if ($product->stock <= 0)
                                        <span
                                            class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700 dark:bg-red-950 dark:text-red-300">
                                            Agotado
                                        </span>
                                    @elseif ($product->stock <= 5)
                                        <span
                                            class="rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300">
                                            {{ $product->stock }} disponibles
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-950 dark:text-green-300">
                                            {{ $product->stock }} disponibles
                                        </span>
                                    @endif

                                </div>

                            </button>

                        @empty

                            <div class="col-span-full py-12 text-center">

                                <div
                                    class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">
                                    <flux:icon name="magnifying-glass" class="size-6 text-zinc-400" />
                                </div>

                                <p class="font-medium text-zinc-700 dark:text-zinc-300">
                                    No se encontraron productos
                                </p>

                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    Intenta buscar con otro nombre o código.
                                </p>

                            </div>
                        @endforelse

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             CARRITO / COBRO
             ===================================================== --}}
        <aside class="min-w-0 lg:sticky lg:top-6">

            <div
                class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

                {{-- -------------------------------------------------
                     CABECERA CARRITO
                     ------------------------------------------------- --}}
                <div class="flex items-center justify-between border-b border-zinc-200 px-5 py-4 dark:border-zinc-700">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">
                            <flux:icon name="shopping-cart" class="size-5" />
                        </div>

                        <div>

                            <h2 class="font-semibold text-zinc-900 dark:text-white">
                                Venta actual
                            </h2>

                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ count($cart) }} {{ count($cart) === 1 ? 'producto' : 'productos' }}
                            </p>

                        </div>

                    </div>

                </div>


                @if (count($cart) > 0)

                    {{-- -------------------------------------------------
                         PRODUCTOS DEL CARRITO
                         ------------------------------------------------- --}}
                    <div class="max-h-[420px] overflow-y-auto">

                        <div class="divide-y divide-zinc-100 dark:divide-zinc-800">

                            @foreach ($cart as $item)
                                <div class="p-4">

                                    <div class="flex min-w-0 gap-3">

                                        {{-- Icono --}}
                                        <div
                                            class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                            <flux:icon name="cube" class="size-5" />
                                        </div>


                                        {{-- Información --}}
                                        <div class="min-w-0 flex-1">

                                            <div class="flex min-w-0 items-start justify-between gap-2">

                                                <div class="min-w-0">

                                                    <p
                                                        class="truncate text-sm font-medium text-zinc-900 dark:text-white">
                                                        {{ $item['name'] }}
                                                    </p>

                                                    <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400">
                                                        ${{ number_format($item['price'], 2) }} c/u
                                                    </p>

                                                </div>

                                                <button type="button" wire:click="removeProduct({{ $item['id'] }})"
                                                    class="shrink-0 text-zinc-400 transition hover:text-red-600"
                                                    title="Eliminar producto">
                                                    <flux:icon name="trash" variant="mini" />
                                                </button>

                                            </div>


                                            <div class="mt-3 flex min-w-0 items-center justify-between">

                                                {{-- Cantidad --}}
                                                <div
                                                    class="flex items-center overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700">

                                                    <button type="button"
                                                        wire:click="decreaseQuantity({{ $item['id'] }})"
                                                        class="flex size-8 items-center justify-center text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-white">
                                                        −
                                                    </button>

                                                    <span
                                                        class="flex min-w-8 justify-center text-sm font-semibold text-zinc-900 dark:text-white">
                                                        {{ $item['quantity'] }}
                                                    </span>

                                                    <button type="button"
                                                        wire:click="increaseQuantity({{ $item['id'] }})"
                                                        class="flex size-8 items-center justify-center text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-900 dark:hover:bg-zinc-800 dark:hover:text-white">
                                                        +
                                                    </button>

                                                </div>


                                                {{-- Subtotal --}}
                                                <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                    </div>


                    {{-- -------------------------------------------------
                         COBRO
                         ------------------------------------------------- --}}
                    <div class="border-t border-zinc-200 dark:border-zinc-700">

                        <div class="space-y-4 p-5">

                            {{-- Método de pago --}}
                            <div>

                                <label for="paymentMethod"
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    Método de pago
                                </label>

                                <select id="paymentMethod" wire:model.live="paymentMethod"
                                    class="mt-2 block w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:focus:border-zinc-400 dark:focus:ring-zinc-700">

                                    <option value="cash">
                                        Efectivo
                                    </option>

                                    <option value="card">
                                        Tarjeta
                                    </option>

                                    <option value="transfer">
                                        Transferencia
                                    </option>

                                </select>

                                @error('paymentMethod')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Pago recibido --}}
                            @if ($paymentMethod === 'cash')
                                <div>

                                    <label for="paidAmount"
                                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                        Pago recibido
                                    </label>

                                    <div class="relative mt-2">

                                        <span
                                            class="pointer-events-none absolute start-3 top-1/2 -translate-y-1/2 text-sm text-zinc-400">
                                            $
                                        </span>

                                        <input id="paidAmount" type="number" step="0.01" min="0"
                                            wire:model.live="paidAmount" placeholder="0.00"
                                            class="block w-full rounded-xl border border-zinc-300 bg-white py-2.5 ps-7 pe-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-500 focus:ring-2 focus:ring-zinc-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white dark:focus:border-zinc-400 dark:focus:ring-zinc-700" />

                                    </div>

                                    @error('paidAmount')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Cambio --}}
                                <div
                                    class="flex items-center justify-between rounded-xl bg-zinc-100 px-4 py-3 dark:bg-zinc-800">

                                    <span class="text-sm text-zinc-600 dark:text-zinc-400">
                                        Cambio
                                    </span>

                                    <span class="text-lg font-bold text-zinc-900 dark:text-white">
                                        ${{ number_format($this->change, 2) }}
                                    </span>

                                </div>
                            @endif

                        </div>


                        {{-- -------------------------------------------------
                             TOTAL
                             ------------------------------------------------- --}}
                        <div class="border-t border-zinc-200 px-5 py-5 dark:border-zinc-700">

                            <div class="flex items-end justify-between">

                                <span class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                                    Total
                                </span>

                                <span class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">
                                    ${{ number_format($this->total, 2) }}
                                </span>

                            </div>


                            {{-- Cobrar --}}
                            <button type="button" wire:click="checkout" wire:loading.attr="disabled"
                                class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-zinc-900 px-4 py-3.5 text-sm font-semibold text-white transition hover:bg-zinc-700 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">

                                <span wire:loading.remove wire:target="checkout">
                                    <flux:icon name="banknotes" class="size-5" />
                                </span>

                                <span wire:loading.remove wire:target="checkout">
                                    Cobrar ${{ number_format($this->total, 2) }}
                                </span>

                                <span wire:loading wire:target="checkout">
                                    Procesando...
                                </span>

                            </button>

                        </div>

                    </div>
                @else
                    {{-- =================================================
                         CARRITO VACÍO
                         ================================================= --}}
                    <div class="px-5 py-12 text-center">

                        <div
                            class="mx-auto mb-4 flex size-14 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">
                            <flux:icon name="shopping-cart" class="size-7 text-zinc-400" />
                        </div>

                        <p class="font-medium text-zinc-700 dark:text-zinc-300">
                            El carrito está vacío
                        </p>

                        <p class="mx-auto mt-1 max-w-xs text-sm text-zinc-500 dark:text-zinc-400">
                            Selecciona un producto para comenzar la venta.
                        </p>

                    </div>

                @endif

            </div>

        </aside>

    </div>

</div>
