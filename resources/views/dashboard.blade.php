<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-4">
            @role('Aprendiz')
            <!-- Verificamos si el usuario ya ha completado su información -->
            <div class="flex flex-col space-y-4">
                @if ($studentInfo)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 flex-grow">
                        <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200 mb-4">
                            Información de aprendiz completada
                        </h3>
                        <a href="{{ route('student.edit', $studentInfo->id) }}" class="bg-green-500 hover:bg-green-600 focus:bg-green-600 focus:ring-green-500 text-white px-4 py-2 rounded">
                            Actualizar Información
                        </a>
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-800 dark:text-gray-200">Progreso Curricular</h4>
                            <div class="w-full bg-gray-200 rounded-full h-6 dark:bg-gray-700">
                                <div class="bg-green-500 h-6 rounded-full" style="width: {{ $progressPercentage }}%;"></div>
                            </div>
                            <p class="mt-2 text-gray-800 dark:text-gray-200">{{ round($progressPercentage) }}% completado</p>
                        </div>

                        <!-- Verificamos si ya seleccionaste una alternativa de práctica -->
                        @if ($selectedAlternative)
                            <div class="bg-green-100 text-green-700 p-4 rounded-lg mt-4">
                                <p>Ya seleccionaste una alternativa de práctica.</p>
                            </div>
                        @else
                            @if (Carbon\Carbon::today()->greaterThanOrEqualTo($threeMonthsBeforeEnd))
                                <!-- Mostrar el formulario para seleccionar la alternativa -->
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 flex-grow mt-4">
                                    <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200 mb-4">Selecciona una Alternativa</h3>
                                    <form method="POST" action="{{ route('select_alternative.store') }}">
                                        @csrf
                                        <div class="mb-4">
                                            <x-label for="alternative_id" value="Alternativa" />
                                            <select id="alternative_id" name="alternative_id" class="block mt-1 w-full" required>
                                                <option value="">Selecciona una alternativa</option>
                                                @foreach($alternatives as $alternative)
                                                    <option value="{{ $alternative->id }}">{{ $alternative->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <x-label for="description" value="Descripción" />
                                            <textarea id="description" name="description" class="block mt-1 w-full" required></textarea>
                                        </div>
                                        <x-button class="bg-green-500 hover:bg-green-600 focus:bg-green-600 focus:ring-green-500">
                                            Guardar Alternativa
                                        </x-button>
                                    </form>
                                </div>
                            @else
                                <!-- Mensaje para indicar que aún están en la fase lectiva -->
                                <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg mt-4">
                                    <p>Aún estás en la fase lectiva. En el momento que debas seleccionar una alternativa de práctica, tendrás habilitada esta opción.</p>
                                </div>
                            @endif
                        @endif

                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 flex-grow">
                        <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200 mb-4">
                            Completa tu información de aprendiz
                        </h3>
                        <form method="POST" action="{{ route('student.store') }}">
                            @csrf
                            <div class="mb-4 flex items-center">
                                <x-input id="agreement" class="mr-2" type="checkbox" name="agreement" />
                                <x-label for="agreement" value="Acepta el acuerdo, la información suministrada se usará solo con fines académicos y de trazabilidad del Sena." />
                            </div>
                            <div class="mb-4">
                                <x-label for="entry_date" value="Fecha de Entrada" />
                                <x-input id="entry_date" class="block mt-1 w-full" type="date" name="entry_date" required />
                            </div>
                            <div class="mb-4">
                                <x-label for="end_date" value="Fecha de Terminación" />
                                <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" />
                            </div>
                            <div class="mb-4">
                                <x-label for="program_id" value="Programa" />
                                <select id="program_id" name="program_id" class="block mt-1 w-full" required>
                                    <option value="">Selecciona un programa</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->ficha }} - {{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-button class="bg-green-500 hover:bg-green-600 focus:bg-green-600 focus:ring-green-500">
                                Guardar Información
                            </x-button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sección de Tips de Alternativas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 flex-grow">
                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200 mb-4">
                    Tips de Alternativas de Prácticas
                </h3>
                
                <!-- Listado de Cards de Tips -->
                <div class="grid grid-cols-1 gap-4">
                    @foreach($tipAlternatives as $tipAlternative)
                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                            {{ $tipAlternative->alternative->name }}
                        </h4>
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ $tipAlternative->tip }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endrole
        </div>
    </div>
</x-app-layout>
