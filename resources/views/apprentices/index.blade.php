<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Aprendices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Lista de Aprendices</h1>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">Nombre</th>
                                <th class="py-2 px-4 border-b text-left">Correo Electrónico</th>
                                <th class="py-2 px-4 border-b text-left">Cédula</th>
                                <th class="py-2 px-4 border-b text-left">Programa</th>
                                <th class="py-2 px-4 border-b text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apprentices as $apprentice)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $apprentice->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $apprentice->email }}</td>
                                    <td class="py-2 px-4 border-b">{{ $apprentice->cedula }}</td>
                                    <td class="py-2 px-4 border-b">{{ $apprentice->infostudent->program->ficha }} - {{ $apprentice->infostudent->program->name ?? 'Sin Programa' }}</td>
                                    <td class="py-2 px-4 border-b flex space-x-2">
                                        <!-- Botón Editar -->
                                        <a href="{{ route('apprentices.edit', $apprentice->id) }}" class="bg-green-500 hover:bg-green-600 focus:bg-green-600 focus:ring-green-500 text-white font-bold py-2 px-4 rounded">
                                            Editar
                                        </a>
                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('apprentices.destroy', $apprentice->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este aprendiz?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
