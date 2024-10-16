<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Profesor/Coordinador - Alertas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Alertas por Usuario</h1>

                <table class="min-w-full bg-white border border-gray-300 mt-4 rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">Cedula</th>
                            <th class="border px-4 py-2 text-left">Usuario</th>
                            <th class="border px-4 py-2 text-left">Cantidad de Alertas</th>
                            <th class="border px-4 py-2 text-left">¿Selecciona alguna alternativa?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($alerts->isEmpty())
                            <tr>
                                <td colspan="4" class="border px-4 py-2 text-center">No hay alertas para mostrar</td>
                            </tr>
                        @else
                            @foreach($alerts as $alert)
                                <tr class="hover:bg-gray-100 {{ $alert['total_alerts'] >= 3 ? 'bg-red-100' : ($alert['total_alerts'] == 2 ? 'bg-yellow-100' : 'bg-green-100') }}">
                                    <td class="border px-4 py-2">{{ $alert['user']->cedula ?? 'Usuario no encontrado' }}</td>
                                    <td class="border px-4 py-2">{{ $alert['user']->name ?? 'Usuario no encontrado' }}</td>
                                    <td class="border px-4 py-2">{{ $alert['total_alerts'] }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        @if($alert['has_selected_alternative'])
                                            ✔️
                                        @else
                                            ❌
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mostrar gráficos -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Cantidad de Personas por Alternativa</h1>
                <canvas id="pieChart" class="w-full h-64 mx-auto"></canvas>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Alternativas Seleccionadas por Programa</h1>
                <table class="min-w-full bg-white border border-gray-300 mt-4 rounded-lg overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2 text-left">Programa</th>
                            <th class="border px-4 py-2 text-left">Cantidad de Alternativas Seleccionadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($programs->isEmpty())
                            <tr>
                                <td colspan="2" class="border px-4 py-2 text-center">No hay programas para mostrar</td>
                            </tr>
                        @else
                            @foreach($programs as $program)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $program->name }}</td>
                                    <td class="border px-4 py-2">{{ $program->select_alternatives_count }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Gráficos JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        const pieLabels = @json($programs->pluck('name'));
        const pieData = @json($programs->pluck('select_alternatives_count'));

        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56'],
                    hoverBackgroundColor: ['#36A2EB', '#FF6384', '#FFCE56']
                }]
            },
        });
    </script>
</x-app-layout>
