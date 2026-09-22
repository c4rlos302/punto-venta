<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    {{-- =========================================================
         SIDEBAR
         ========================================================= --}}
    <flux:sidebar sticky collapsible="mobile"
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

        {{-- =====================================================
             LOGO
             ===================================================== --}}
        <flux:sidebar.header>

            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />

            {{-- Solo se muestra en móvil --}}
            <flux:sidebar.collapse class="lg:hidden" />

        </flux:sidebar.header>


        {{-- =====================================================
             NAVEGACIÓN PRINCIPAL
             ===================================================== --}}
        <flux:sidebar.nav>

            {{-- =================================================
                 SECCIÓN PRINCIPAL
                 ================================================= --}}
            <div class="px-2 pb-2 pt-3">

                <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                    Principal
                </flux:text>

            </div>


            {{-- =================================================
                 PUNTO DE VENTA
                 ================================================= --}}
            <flux:sidebar.group heading="Punto de Venta" icon="shopping-cart" expandable
                :expanded="request()->routeIs('dashboard', 'sales.create')" class="grid">

                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    Inicio
                </flux:sidebar.item>

                <flux:sidebar.item icon="shopping-cart" :href="route('sales.create')"
                    :current="request()->routeIs('sales.create')" wire:navigate>
                    Nueva venta
                </flux:sidebar.item>

            </flux:sidebar.group>


            {{-- =================================================
                 VENTAS
                 ================================================= --}}
            <flux:sidebar.group heading="Ventas" icon="receipt-percent" expandable
                :expanded="request()->routeIs('sales.index', 'sales.show')" class="grid">

                <flux:sidebar.item icon="clock" :href="route('sales.index')"
                    :current="request()->routeIs('sales.index', 'sales.show')" wire:navigate>
                    Historial
                </flux:sidebar.item>

            </flux:sidebar.group>


            {{-- =================================================
                 CATÁLOGO
                 ================================================= --}}
            <flux:sidebar.group heading="Catálogo" icon="cube" expandable
                :expanded="request()->routeIs('products.*', 'categories.*')" class="grid">

                <flux:sidebar.item icon="cube" :href="route('products.index')"
                    :current="request()->routeIs('products.*')" wire:navigate>
                    Productos
                </flux:sidebar.item>

                <flux:sidebar.item icon="tag" :href="route('categories.index')"
                    :current="request()->routeIs('categories.*')" wire:navigate>
                    Categorías
                </flux:sidebar.item>

            </flux:sidebar.group>


            {{-- =================================================
                 INVENTARIO
                 ================================================= --}}
            <flux:sidebar.group heading="Inventario" icon="archive-box" expandable
                :expanded="request()->routeIs('inventory.*')" class="grid">

                <flux:sidebar.item icon="archive-box" :href="route('inventory.index')"
                    :current="request()->routeIs('inventory.index')" wire:navigate>
                    Existencias
                </flux:sidebar.item>

                <flux:sidebar.item icon="clipboard-document-list" :href="route('inventory.movements')"
                    :current="request()->routeIs('inventory.movements')" wire:navigate>
                    Movimientos
                </flux:sidebar.item>

            </flux:sidebar.group>


            {{-- =================================================
                 REPORTES
                 ================================================= --}}
            <flux:sidebar.group heading="Reportes" icon="chart-bar" expandable
                :expanded="request()->routeIs('reports.*')" class="grid">

                <flux:sidebar.item icon="chart-bar" :href="route('reports.sales')"
                    :current="request()->routeIs('reports.sales')" wire:navigate>
                    Ventas
                </flux:sidebar.item>

                <flux:sidebar.item icon="archive-box" :href="route('reports.inventory')"
                    :current="request()->routeIs('reports.inventory')" wire:navigate>
                    Inventario
                </flux:sidebar.item>

            </flux:sidebar.group>


            {{-- =================================================
                 ADMINISTRACIÓN
                 ================================================= --}}
            @if (auth()->user()->isAdmin())
                <div class="px-2 pb-2 pt-6">

                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                        Administración
                    </flux:text>

                </div>


                <flux:sidebar.item icon="users" :href="route('users.index')"
                    :current="request()->routeIs('users.*')" wire:navigate>
                    Usuarios
                </flux:sidebar.item>
            @endif

        </flux:sidebar.nav>


        {{-- =====================================================
             PARTE INFERIOR
             ===================================================== --}}
        <flux:spacer />

        {{-- =====================================================
             USUARIO - ESCRITORIO
             ===================================================== --}}
        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />

    </flux:sidebar>


    {{-- =========================================================
         HEADER MÓVIL
         ========================================================= --}}
    <flux:header class="lg:hidden">

        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />


        {{-- =====================================================
             MENÚ DE USUARIO MÓVIL
             ===================================================== --}}
        <flux:dropdown position="top" align="end">

            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />


            <flux:menu>

                {{-- Información del usuario --}}
                <flux:menu.radio.group>

                    <div class="p-0 text-sm font-normal">

                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">

                            <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">

                                <flux:heading class="truncate">
                                    {{ auth()->user()->name }}
                                </flux:heading>

                                <flux:text class="truncate">
                                    {{ auth()->user()->email }}
                                </flux:text>

                            </div>

                        </div>

                    </div>

                </flux:menu.radio.group>


                <flux:menu.separator />


                {{-- Configuración --}}
                <flux:menu.radio.group>

                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>

                </flux:menu.radio.group>


                <flux:menu.separator />


                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}" class="w-full">

                    @csrf

                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer" data-test="logout-button">
                        {{ __('Log out') }}
                    </flux:menu.item>

                </form>

            </flux:menu>

        </flux:dropdown>

    </flux:header>


    {{-- =========================================================
         CONTENIDO DE LA PÁGINA
         ========================================================= --}}
    {{ $slot }}


    {{-- =========================================================
         TOASTS
         ========================================================= --}}
    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist


    {{-- =========================================================
         SCRIPTS DE FLUX
         ========================================================= --}}
    @fluxScripts

</body>

</html>
