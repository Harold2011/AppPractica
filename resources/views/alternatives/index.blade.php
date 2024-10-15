<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Alternativas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-3xl font-semibold text-center mb-4">Alternativas</h1>

                @if(session('success'))
                    <div class="bg-green-500 text-white p-2 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between mb-4">
                    <a href="{{ route('alternatives.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Crear Nueva Alternativa</a>
                    <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Atrás</a>
                </div>

                <table class="min-w-full bg-white border border-gray-300 mt-4 rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">ID</th>
                            <th class="border px-4 py-2 text-left">Nombre</th>
                            <th class="border px-4 py-2 text-left">Descripción</th>
                            <th class="border px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatives as $alternative)
                            <tr class="hover:bg-gray-100">
                                <td class="border px-4 py-2">{{ $alternative->id }}</td>
                                <td class="border px-4 py-2">{{ $alternative->name }}</td>
                                <td class="border px-4 py-2">{{ $alternative->description }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('alternatives.edit', $alternative) }}" class="text-blue-500 hover:underline">Editar</a>
                                    <form action="{{ route('alternatives.destroy', $alternative) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
