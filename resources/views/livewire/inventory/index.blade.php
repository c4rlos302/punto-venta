<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- ENCABEZADO --}}
    <div class="mb-8 flex items-start justify-between">

        <div>

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Inventario
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Consulta y administra el stock de tus productos.
            </p>

        </div>

        <a href="{{ route('inventory.movements') }}" wire:navigate
            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-800">
            Historial de movimientos
        </a>

    </div>


    {{-- MENSAJES --}}
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


    {{-- BUSCADOR --}}
    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Buscar producto
        </label>

        <input id="search" type="text" wire:model.live.debounce.300ms="search"
            placeholder="Buscar por nombre o código..."
            class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

    </div>


    {{-- TABLA --}}
    <div
        class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-gray-200 bg-gray-50 dark:border-zinc-700 dark:bg-zinc-800">

                    <tr>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Producto
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Categoría
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Precio
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                            Stock
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-gray-700 dark:text-gray-300">
                            Acción
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-zinc-700">

                    @forelse ($products as $product)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-zinc-800">

                            <td class="px-6 py-4">

                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $product->name }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Código: {{ $product->code }}
                                </p>

                            </td>

                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $product->category?->name ?? 'Sin categoría' }}
                            </td>

                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                ${{ number_format($product->price, 2) }}
                            </td>

                            <td class="px-6 py-4">

                                @if ($product->stock <= 5)
                                    <span
                                        class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-950 dark:text-red-300">
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-950 dark:text-green-300">
                                        {{ $product->stock }}
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4 text-right">

                                <button type="button" wire:click="openMovementModal({{ $product->id }})"
                                    class="font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                                    Ajustar stock
                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-12 text-center">

                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    No se encontraron productos.
                                </p>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}
        @if ($products->hasPages())
            <div class="border-t border-gray-200 px-6 py-4 dark:border-zinc-700">

                {{ $products->links() }}

            </div>
        @endif

    </div>


    {{-- MODAL --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
            wire:click.self="closeMovementModal">

            <div class="w-full max-w-lg rounded-xl bg-white p-6 shadow-xl dark:bg-zinc-900">

                <div class="mb-6">

                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Movimiento de inventario
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Registra una entrada, salida o ajuste.
                    </p>

                </div>


                {{-- TIPO --}}
                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tipo de movimiento
                    </label>

                    <select wire:model="movementType"
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                        <option value="entrada">
                            Entrada
                        </option>

                        <option value="salida">
                            Salida
                        </option>

                        <option value="ajuste">
                            Ajuste
                        </option>

                    </select>

                </div>


                {{-- CANTIDAD --}}
                <div class="mb-5">

                    <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $movementType === 'ajuste' ? 'Nuevo stock' : 'Cantidad' }}
                    </label>

                    <input id="quantity" type="number" min="1" wire:model="quantity"
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">

                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- MOTIVO --}}
                <div class="mb-6">

                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Motivo
                    </label>

                    <textarea id="reason" wire:model="reason" rows="3" placeholder="Ej. Reposición de proveedor..."
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white"></textarea>

                    @error('reason')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- BOTONES --}}
                <div class="flex justify-end gap-3">

                    <button type="button" wire:click="closeMovementModal"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-800">
                        Cancelar
                    </button>

                    <button type="button" wire:click="saveMovement" wire:loading.attr="disabled"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 disabled:opacity-50">

                        <span wire:loading.remove wire:target="saveMovement">
                            Guardar movimiento
                        </span>

                        <span wire:loading wire:target="saveMovement">
                            Guardando...
                        </span>

                    </button>

                </div>

            </div>

        </div>
    @endif

</div>
