<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <!-- Aquí puedes personalizar el logo -->
            <img src="{{ asset('storage/img/logo.png') }}" alt="Logo" class="w-40 h-auto mx-auto">
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Campo de Email -->
            <div>
                <x-label for="email" value="Correo Electrónico" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <!-- Campo de Contraseña -->
            <div class="mt-4">
                <x-label for="password" value="Contraseña" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- Checkbox de Recordarme -->
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Recordarme</span>
                </label>
            </div>

            <!-- Enlaces de recuperación de contraseña y botón de login -->
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <x-button class="ms-4 bg-green-500 hover:bg-green-600 focus:bg-green-600 focus:ring-green-500">
                    Iniciar Sesión
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
