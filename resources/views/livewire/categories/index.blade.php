<div class="mx-auto max-w-7xl px-6 py-8">

    {{-- Encabezado --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Categorías
            </h1>

            <flux:text class="mt-1">
                Organiza los productos de tu inventario.
            </flux:text>
        </div>

        <flux:button variant="primary" :href="route('categories.create')" wire:navigate>
            Nueva categoría
        </flux:button>

    </div>


    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div
            class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900 dark:bg-green-950/30 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif


    {{-- Mensaje de error --}}
    @if (session('error'))
        <div
            class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900 dark:bg-red-950/30 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif


    {{-- Barra de herramientas --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="w-full sm:max-w-md">

            <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar categoría..." autocomplete="off" />

        </div>

        <flux:text>
            {{ $categories->total() }}
            {{ $categories->total() === 1 ? 'categoría' : 'categorías' }}
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
                            Categoría
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Descripción
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Productos
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">

                    @forelse ($categories as $category)
                        <tr wire:key="category-{{ $category->id }}"
                            class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800/50">

                            {{-- Categoría --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="text-sm font-semibold text-zinc-900 dark:text-white">
                                    {{ $category->name }}
                                </div>

                            </td>


                            {{-- Descripción --}}
                            <td class="max-w-md px-6 py-4">

                                @if ($category->description)
                                    <p class="truncate text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ $category->description }}
                                    </p>
                                @else
                                    <span class="text-sm text-zinc-400">
                                        Sin descripción
                                    </span>
                                @endif

                            </td>


                            {{-- Productos --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <flux:badge color="zinc">
                                    {{ $category->products_count }}
                                    {{ $category->products_count === 1 ? 'producto' : 'productos' }}
                                </flux:badge>

                            </td>


                            {{-- Acciones --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <flux:button variant="ghost" size="sm"
                                        :href="route('categories.edit', $category)" wire:navigate>
                                        Editar
                                    </flux:button>


                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">

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

                            <td colspan="4" class="px-6 py-16 text-center">

                                <div class="mx-auto max-w-md">

                                    <flux:heading size="sm">
                                        No se encontraron categorías.
                                    </flux:heading>

                                    <flux:text class="mt-1">

                                        @if ($search)
                                            Intenta con otro nombre.
                                        @else
                                            Comienza creando tu primera categoría.
                                        @endif

                                    </flux:text>


                                    @if (!$search)
                                        <div class="mt-4">

                                            <flux:button variant="primary" :href="route('categories.create')"
                                                wire:navigate>
                                                Crear categoría
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
        @if ($categories->hasPages())
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-700">

                {{ $categories->links() }}

            </div>
        @endif

    </div>

</div>
