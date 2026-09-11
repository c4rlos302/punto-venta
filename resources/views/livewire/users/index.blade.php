<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold">
                Usuarios
            </h1>

            <p class="text-sm text-zinc-500">
                Gestiona los usuarios del punto de venta.
            </p>
        </div>

        <a href="{{ route('users.create') }}" wire:navigate
            class="rounded-lg bg-black px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
            Nuevo usuario
        </a>

    </div>


    <div class="rounded-xl border bg-white p-4 shadow-sm">

        <input type="text" wire:model.live="search" placeholder="Buscar por nombre o correo..."
            class="w-full rounded-lg border-zinc-300">

    </div>


    <div class="overflow-hidden rounded-xl border bg-white shadow-sm">

        <table class="min-w-full divide-y divide-zinc-200">

            <thead class="bg-zinc-50">

                <tr>

                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">
                        Usuario
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">
                        Correo
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">
                        Rol
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">
                        Estado
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-medium uppercase">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-zinc-200">

                @forelse ($users as $user)
                    <tr>

                        <td class="px-6 py-4">

                            <div class="font-medium">
                                {{ $user->name }}
                            </div>

                        </td>


                        <td class="px-6 py-4 text-sm text-zinc-600">

                            {{ $user->email }}

                        </td>


                        <td class="px-6 py-4">

                            @if ($user->isAdmin())
                                <span
                                    class="rounded-full bg-purple-100 px-2.5 py-1 text-xs font-medium text-purple-700">
                                    Administrador
                                </span>
                            @else
                                <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">
                                    Vendedor
                                </span>
                            @endif

                        </td>


                        <td class="px-6 py-4">

                            @if ($user->isActive())
                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                    Activo
                                </span>
                            @else
                                <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                    Inactivo
                                </span>
                            @endif

                        </td>


                        <td class="px-6 py-4 text-right">

                            <a href="{{ route('users.edit', $user) }}" wire:navigate
                                class="text-sm font-medium hover:underline">
                                Editar
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="px-6 py-12 text-center text-sm text-zinc-500">
                            No se encontraron usuarios.
                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>


    <div>
        {{ $users->links() }}
    </div>

</div>
