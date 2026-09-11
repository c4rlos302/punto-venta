<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Encabezado --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Productos
            </h1>

            <flux:text class="mt-1">
                Administra los productos de tu inventario.
            </flux:text>
        </div>

        <flux:button variant="primary" :href="route('products.create')" wire:navigate>
            Nuevo producto
        </flux:button>

    </div>


    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div
            class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900 dark:bg-green-950/30 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif


    {{-- Barra de herramientas --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="w-full sm:max-w-md">

            <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre o código..."
                autocomplete="off" />

        </div>

        <flux:text>
            {{ $products->total() }}
            {{ $products->total() === 1 ? 'producto' : 'productos' }}
        </flux:text>

    </div>


    {{-- Tabla --}}
    <div
        class="overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">

                <thead class="bg-zinc-50 dark:bg-zinc-800">

                    <tr>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Código
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Producto
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Categoría
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Precio
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Stock
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">

                    @forelse ($products as $product)
                        <tr wire:key="product-{{ $product->id }}"
                            class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                            {{-- Código --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <span class="font-mono text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                    {{ $product->code }}
                                </span>

                            </td>


                            {{-- Producto --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="text-sm font-semibold text-zinc-900 dark:text-white">
                                    {{ $product->name }}
                                </div>

                            </td>


                            {{-- Categoría --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                @if ($product->category)
                                    <flux:badge color="zinc">
                                        {{ $product->category->name }}
                                    </flux:badge>
                                @else
                                    <span class="text-sm text-zinc-400">
                                        Sin categoría
                                    </span>
                                @endif

                            </td>


                            {{-- Precio --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-white">

                                ${{ number_format($product->price, 2) }}

                            </td>


                            {{-- Stock --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <span class="text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ $product->stock }}
                                    </span>

                                    @if ($product->stock > 10)
                                        <flux:badge color="green">
                                            Disponible
                                        </flux:badge>
                                    @elseif ($product->stock > 0)
                                        <flux:badge color="yellow">
                                            Stock bajo
                                        </flux:badge>
                                    @else
                                        <flux:badge color="red">
                                            Agotado
                                        </flux:badge>
                                    @endif

                                </div>

                            </td>


                            {{-- Acciones --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <flux:button variant="ghost" size="sm" :href="route('products.edit', $product)"
                                        wire:navigate>
                                        Editar
                                    </flux:button>

                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">

                                        @csrf
                                        @method('DELETE')

                                        <flux:button type="submit" variant="ghost" size="sm"
                                            class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            Eliminar
                                        </flux:button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto max-w-md">

                                    <flux:heading size="sm">
                                        No se encontraron productos.
                                    </flux:heading>

                                    <flux:text class="mt-1">

                                        @if ($search)
                                            Intenta con otro nombre o código.
                                        @else
                                            Comienza agregando tu primer producto.
                                        @endif

                                    </flux:text>

                                    @if (!$search)
                                        <div class="mt-4">

                                            <flux:button variant="primary" :href="route('products.create')"
                                                wire:navigate>
                                                Crear producto
                                            </flux:button>

                                        </div>
                                    @endif

                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Paginación --}}
        @if ($products->hasPages())
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-700">

                {{ $products->links() }}

            </div>
        @endif

    </div>

</div>
