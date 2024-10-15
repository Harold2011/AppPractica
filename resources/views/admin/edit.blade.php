<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Editar Usuario</h1>

                <form action="{{ route('admin.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" />
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" />
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="role" id="role" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="" disabled>Seleccionar rol</option>
                            <option value="3" {{ $user->roles->first()->id == 3 ? 'selected' : '' }}>Profesor</option>
                            <option value="4" {{ $user->roles->first()->id == 4 ? 'selected' : '' }}>Coordinador</option>
                        </select>
                    </div>

                    @if($user->roles->first()->id == 3)
                        <div class="mb-4">
                            <label for="programs" class="block text-sm font-medium text-gray-700">Programas Asignados</label>
                            <select name="programs[]" id="programs" multiple
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ $user->programs->contains($program->id) ? 'selected' : '' }}>
                                        {{ $program->ficha }} - {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Command (Mac) para seleccionar múltiples.</small>
                        </div>
                    @elseif($user->roles->first()->id == 4)
                        <div class="mb-4">
                            <label for="programs" class="block text-sm font-medium text-gray-700">Programas Asignados</label>
                            <select name="programs[]" id="programs" multiple
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ $user->coordinatorPrograms->contains($program->id) ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Command (Mac) para seleccionar múltiples.</small>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 focus:bg-green-600 focus:ring-green-500 text-white font-bold py-2 px-4 rounded">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
