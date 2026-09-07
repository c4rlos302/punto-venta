<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Punto de Venta</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">

                <h1 class="text-xl font-bold">
                    Punto de Venta
                </h1>

                <nav class="flex gap-6">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600">
                        Inicio
                    </a>

                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-indigo-600">
                        Productos
                    </a>

                    <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-indigo-600">
                        Categorías
                    </a>
                </nav>

            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>
