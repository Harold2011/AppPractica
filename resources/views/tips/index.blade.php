<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tips sobre Alternativas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-3xl font-semibold text-center mb-4">Tips sobre Alternativas</h1>
                
                @if(session('success'))
                    <div class="bg-green-500 text-white p-2 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between mb-4">
                    <a href="{{ route('tips.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Crear Nuevo Tip</a>
                    <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Atrás</a>
                </div>

                <table class="min-w-full bg-white border border-gray-300 mt-4 rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">ID</th>
                            <th class="border px-4 py-2 text-left">Tip</th>
                            <th class="border px-4 py-2 text-left">Alternativa</th>
                            <th class="border px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tips as $tip)
                            <tr class="hover:bg-gray-100">
                                <td class="border px-4 py-2">{{ $tip->id }}</td>
                                <td class="border px-4 py-2">{{ $tip->tip }}</td>
                                <td class="border px-4 py-2">{{ $tip->alternative->name }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('tips.edit', $tip) }}" class="text-blue-500 hover:underline">Editar</a>
                                    <form action="{{ route('tips.destroy', $tip) }}" method="POST" class="inline">
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
