<div class="mx-auto max-w-2xl space-y-6">

    <div>
        <h1 class="text-2xl font-semibold">
            Nuevo usuario
        </h1>

        <p class="text-sm text-zinc-500">
            Crea un usuario para el punto de venta.
        </p>
    </div>


    <form wire:submit="save" class="space-y-6 rounded-xl border bg-white p-6 shadow-sm">

        {{-- Nombre --}}

        <div>

            <label class="mb-1 block text-sm font-medium">
                Nombre
            </label>

            <input type="text" wire:model="name" class="w-full rounded-lg border-zinc-300" placeholder="Nombre completo">

            @error('name')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Correo --}}

        <div>

            <label class="mb-1 block text-sm font-medium">
                Correo electrónico
            </label>

            <input type="email" wire:model="email" autocomplete="new-email" class="w-full rounded-lg border-zinc-300"
                placeholder="usuario@ejemplo.com">

            @error('email')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Contraseña --}}

        <div>

            <label class="mb-1 block text-sm font-medium">
                Contraseña
            </label>

            <input type="password" wire:model="password" autocomplete="new-password" class="w-full rounded-lg border-zinc-300"
                placeholder="Mínimo 8 caracteres">

            @error('password')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Confirmación --}}

        <div>

            <label class="mb-1 block text-sm font-medium">
                Confirmar contraseña
            </label>

            <input type="password" wire:model="password_confirmation" class="w-full rounded-lg border-zinc-300"
                placeholder="Repite la contraseña">

        </div>


        {{-- Rol --}}

        <div>

            <label class="mb-1 block text-sm font-medium">
                Rol
            </label>

            <select wire:model="role" class="w-full rounded-lg border-zinc-300">

                <option value="seller">
                    Vendedor
                </option>

                <option value="admin">
                    Administrador
                </option>

            </select>

            @error('role')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Estado --}}

        <div class="flex items-center gap-3">

            <input type="checkbox" wire:model="active" class="rounded border-zinc-300">

            <label class="text-sm">
                Usuario activo
            </label>

        </div>


        {{-- Botones --}}

        <div class="flex justify-end gap-3 border-t pt-4">

            <a href="{{ route('users.index') }}" wire:navigate
                class="rounded-lg border px-4 py-2 text-sm font-medium hover:bg-zinc-50">
                Cancelar
            </a>

            <button type="submit" wire:loading.attr="disabled"
                class="rounded-lg bg-black px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 disabled:opacity-50">
                <span wire:loading.remove>
                    Crear usuario
                </span>

                <span wire:loading>
                    Creando...
                </span>
            </button>

        </div>

    </form>

</div>
