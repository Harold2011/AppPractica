<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Actualizar Información de Aprendiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200 mb-4">Actualizar Información de Aprendiz</h3>

            <form method="POST" action="{{ route('student.update', $studentInfo->id) }}">
                @csrf
                @method('PUT')

                <!-- Campo Fecha de Entrada (solo visualización) -->
                <div class="mb-4">
                    <x-label for="entry_date" value="Fecha de Entrada" />
                    <x-input id="entry_date" class="block mt-1 w-full" type="date" name="entry_date" value="{{ $studentInfo->entry_date }}" readonly />
                </div>

                <!-- Campo Fecha de Terminación (solo visualización) -->
                <div class="mb-4">
                    <x-label for="end_date" value="Fecha de Terminación" />
                    <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" value="{{ $studentInfo->end_date }}" readonly />
                </div>

                <!-- Campo Programa -->
                <div class="mb-4">
                    <x-label for="program_id" value="Programa" />
                    <select id="program_id" name="program_id" class="block mt-1 w-full" required>
                        <option value="">Selecciona un programa</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ $studentInfo->program_id == $program->id ? 'selected' : '' }}>
                                {{ $program->ficha }} - {{ $program->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Solo muestra el checkbox si no ha sido marcado antes -->
                @if (!$studentInfo->agreement)
                    <div class="mb-4 flex items-center">
                        <x-input id="agreement" class="mr-2" type="checkbox" name="agreement" required />
                        <x-label for="agreement" value="Acepta el acuerdo, la información suministrada se usará solo con fines académicos y de trazabilidad del Sena." />
                    </div>
                @endif

                <!-- Botón Actualizar -->
                <x-button class="bg-green-500 hover:bg-green-600 focus:bg-green-600 focus:ring-green-500">
                    Actualizar Información
                </x-button>
            </form>
        </div>
    </div>
</x-app-layout>
