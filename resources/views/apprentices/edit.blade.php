<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Aprendiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-xl sm:rounded-lg p-6">
            <form method="POST" action="{{ route('apprentices.update', $apprentice->id) }}">
                @csrf
                @method('PUT')

                <!-- Campo Nombre -->
                <div class="mb-4">
                    <x-label for="name" value="Nombre" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $apprentice->name }}" required />
                </div>

                <!-- Campo Email -->
                <div class="mb-4">
                    <x-label for="email" value="Correo Electrónico" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $apprentice->email }}" required />
                </div>

                <!-- Campo Cédula -->
                <div class="mb-4">
                    <x-label for="cedula" value="Cédula" />
                    <x-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" value="{{ $apprentice->cedula }}" required />
                </div>

                <!-- Campo Programa -->
                <div class="mb-4">
                    <x-label for="program_id" value="Programa" />
                    <select id="program_id" name="program_id" class="block mt-1 w-full" required>
                        <option value="">Selecciona un programa</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}"
                                @if($apprentice->infostudent && $apprentice->infostudent->program_id == $program->id)
                                    selected
                                @endif>
                                {{$program->ficha}} - {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Campo Fecha de Entrada -->
                <div class="mb-4">
                    <x-label for="entry_date" value="Fecha de Entrada" />
                    <x-input id="entry_date" class="block mt-1 w-full" type="date" name="entry_date" value="{{ $apprentice->infostudent->entry_date ?? '' }}" required />
                </div>

                <!-- Campo Fecha de Fin -->
                <div class="mb-4">
                    <x-label for="end_date" value="Fecha de Fin" />
                    <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" value="{{ $apprentice->infostudent->end_date ?? '' }}" required />
                </div>

                <!-- Botón Actualizar -->
                <x-button class="bg-green-500 hover:bg-green-600">
                    Actualizar
                </x-button>
            </form>
        </div>
    </div>
</x-app-layout>
