<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.store') }}">
                    @csrf
                    <div class="mb-4">
                        <x-label for="name" value="Nombre" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="email" value="Correo Electrónico" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="cedula" value="Cédula" />
                        <x-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="password" value="Contraseña" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="password_confirmation" value="Confirmar Contraseña" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>
                    <div class="mb-4">
                        <x-label for="role" value="Rol" />
                        <select id="role" name="role" class="block mt-1 w-full" required>
                            <option value="3">Profesor</option>
                            <option value="4">Coordinador</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <x-label for="programs" value="Programas" />
                        <select id="programs" name="programs[]" class="block mt-1 w-full" multiple required>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->ficha }} - {{ $program->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Command (Mac) para seleccionar múltiples.</small>
                    </div>
                    <x-button class="bg-green-500 hover:bg-green-600 focus:bg-green-600 focus:ring-green-500">Crear Usuario</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
