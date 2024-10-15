<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Tip') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-3xl font-semibold text-center mb-4">Crear Nuevo Tip</h1>
                <form action="{{ route('tips.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="tip" class="block text-sm font-medium">Tip</label>
                        <input type="text" name="tip" id="tip" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label for="alternative_id" class="block text-sm font-medium">Alternativa</label>
                        <select name="alternative_id" id="alternative_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Seleccione una alternativa</option>
                            @foreach($alternatives as $alternative)
                                <option value="{{ $alternative->id }}">{{ $alternative->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Crear</button>
                        <a href="{{ route('tips.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
