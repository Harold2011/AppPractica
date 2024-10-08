<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prácticas CIAA SENA</title>
    @vite('resources/css/app.css')
</head>
<body class="h-screen flex items-center justify-center bg-gray-100">
    <div class="text-center">
        <!-- Aquí puedes colocar el logo -->
        <img src="{{ asset('storage/img/logo.png') }}" class="w-96 h-auto mb-8 mx-auto" alt="Logo"> 

        <!-- Título -->
        <div class="text-3xl font-bold mb-6 text-gray-800">
            Prácticas CIAA SENA
        </div>

        <!-- Botones de Login y Register -->
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-700 transition">
                Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-700 transition">
                Registrarse
            </a>
        </div>
    </div>
</body>
</html>
