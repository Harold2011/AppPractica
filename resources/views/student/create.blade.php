<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Completar Información de Estudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('student.store') }}">
                    @csrf

                    <!-- Acuerdo -->
                    <div>
                        <x-label for="agreement" value="¿Acepta el acuerdo?" />
                        <x-input id="agreement" class="block mt-1 w-full" type="checkbox" name="agreement" required />
                    </div>

                    <!-- Fecha de ingreso -->
                    <div class="mt-4">
                        <x-label for="entry_date" value="Fecha de Ingreso" />
                        <x-input id="entry_date" class="block mt-1 w-full" type="date" name="entry_date" required />
                    </div>

                    <!-- Ficha -->
                    <div class="mt-4">
                        <x-label for="ficha" value="Ficha" />
                        <x-input id="ficha" class="block mt-1 w-full" type="text" name="ficha" required />
                    </div>

                    <!-- Programa -->
                    <div class="mt-4">
                        <x-label for="programa" value="Programa" />
                        <x-input id="programa" class="block mt-1 w-full" type="text" name="programa" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Guardar Información') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
