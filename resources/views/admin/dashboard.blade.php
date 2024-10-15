<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin - Alertas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Alertas por Usuario</h1>

                <!-- Formulario de búsqueda -->
                <form action="{{ route('admin.dashboard') }}" method="GET" class="mb-4">
                    <div class="flex items-center">
                        <input type="text" name="cedula" value="{{ request('cedula') }}" placeholder="Buscar por cédula" class="border rounded px-4 py-2 flex-grow" />
                        <button type="submit" class="ml-2 bg-green-500 text-white rounded px-4 py-2">Buscar</button>
                    </div>
                </form>

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
                        @foreach($alerts as $alert)
                            <tr class="hover:bg-gray-100 {{ $alert->total_alerts == 1 ? 'bg-green-100' : ($alert->total_alerts == 2 ? 'bg-yellow-100' : ($alert->total_alerts >= 3 ? 'bg-red-100' : '')) }}">
                                <td class="border px-4 py-2">{{ $alert->user->cedula ?? 'Usuario no encontrado' }}</td>
                                <td class="border px-4 py-2">{{ $alert->user->name ?? 'Usuario no encontrado' }}</td>
                                <td class="border px-4 py-2">{{ $alert->total_alerts }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @if($alert->has_selected_alternative)
                                        ✔️
                                    @else
                                        <!-- Dejar vacío si no ha seleccionado alternativa -->
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Mostrar los enlaces de paginación -->
                <div class="mt-4">
                    {{ $alerts->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Sección para mostrar los gráficos -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Gráfico de torta -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Cantidad de Personas por Alternativa</h1>
                <canvas id="pieChart" class="w-full h-64 mx-auto"></canvas>
            </div>

            <!-- Estadística de alternativas seleccionadas por programa -->
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
                        @foreach($programs as $program)
                            <tr class="hover:bg-gray-100">
                                <td class="border px-4 py-2">{{ $program->name }}</td>
                                <td class="border px-4 py-2">{{ $program->select_alternatives_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Mostrar los enlaces de paginación -->
                <div class="mt-4">
                    {{ $programs->links() }}
                </div>
            </div>
        </div>

        <!-- Sección para el gráfico de barras -->
        <div class="mt-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Gráfico de Barras - Alertas por Programa</h1>
                <canvas id="barChart" class="w-full h-64 mx-auto"></canvas>
            </div>
        </div>
    </div>

    <!-- Script para los gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de torta
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const labelsPie = @json($alternatives->pluck('alternative.name'));
        const dataPie = @json($alternatives->pluck('total'));

        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: labelsPie,
                datasets: [{
                    label: 'Cantidad de Personas por Alternativa',
                    data: dataPie,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Cantidad de Personas por Alternativa',
                    }
                }
            }
        });

        // Gráfico de barras
        const ctxBar = document.getElementById('barChart').getContext('2d');
        const labelsBar = @json($programs->pluck('name'));
        const dataBar = @json($programs->pluck('select_alternatives_count'));

        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labelsBar,
                datasets: [{
                    label: 'Cantidad de Alertas por Programa',
                    data: dataBar,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
