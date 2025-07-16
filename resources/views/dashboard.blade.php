<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Noticias') }}
        </h2>
    </x-slot>

    <style>
        .max-w-7xl { max-width: 105rem; }
        .copy-icon { visibility: hidden; cursor: pointer; font-size: 1.25rem; color: #5FCFDE; transition: visibility 0s, opacity 0.2s ease; }
        .copy-cell:hover .copy-icon { visibility: visible; }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            padding: 30px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .card-header { display: flex; justify-content: space-between; align-items: center; }
        .card-header h3 { margin: 0; font-size: 25px; }
        .card-header i { font-size: 25px; }
        .card p { margin-top: 10px; font-size: 15px; color: #555; }

        .verde { background-color: #d4edda; }
        .rojo { background-color: #f8d7da; }
        .amarillo { background-color: #fff3cd; }
        .azul { background-color: #d1ecf1; }

        .verde .card-header i { color: #28a745; }
        .rojo .card-header i { color: #dc3545; }
        .amarillo .card-header i { color: #ffc107; }
        .azul .card-header i { color: #17a2b8; }
    </style>

    <div class="container">
        <div class="card rojo">
            <div class="card-header"><h3>Requerido</h3><i class="fas fa-check-circle"></i></div>
            <p style="font-size:25px;font-weight:bold;">{{ $conteos['requerido'] ?? 0 }}</p>
        </div>
        <div class="card amarillo">
            <div class="card-header"><h3>En Proceso</h3><i class="fas fa-exclamation-triangle"></i></div>
            <p style="font-size:25px;font-weight:bold;">{{ $conteos['en proceso'] ?? 0 }}</p>
        </div>
        <div class="card azul">
            <div class="card-header"><h3>Listo</h3><i class="fas fa-exclamation-circle"></i></div>
            <p style="font-size:25px;font-weight:bold;">{{ $conteos['listo'] ?? 0 }}</p>
        </div>
        <div class="card verde">
            <div class="card-header"><h3>Verificado</h3><i class="fas fa-info-circle"></i></div>
            <p style="font-size:25px;font-weight:bold;">{{ $conteos['verificado'] ?? 0 }}</p>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">

                <div style="display: inline-block; float: right; margin-bottom: 20px;">
                    <select id="filtroMes" style="padding:6px; margin-right:8px;">
                        <option value="">Todos los meses</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create(2020, $m, 1)->translatedFormat('F') }}</option>
                        @endfor
                    </select>
                    <select id="filtroYear" style="padding:6px;">
                        <option value="">Todos los años</option>
                        @php
                            $years = $noticias->pluck('fecha_inicio')->map(fn($f) => \Carbon\Carbon::parse($f)->year)->unique()->sortDesc();
                        @endphp
                        @foreach($years as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <h2 style="padding-bottom:15px;">Estado del Arte</h2>
                    <button onclick="redirigirConFiltros('todos')">Todos</button>
                <button onclick="redirigirConFiltros('requerido')">Requerido</button>
                <button onclick="redirigirConFiltros('en proceso')">En Proceso</button>
                <button onclick="redirigirConFiltros('listo')">Listo</button>
                <button onclick="redirigirConFiltros('verificado')">Verificado</button>

                </div>

                <!-- Aquí va la tabla, que no repito por brevedad -->
                @include('noticias.tabla') <!-- asumiendo que la tabla está en un archivo parcial -->

                <div class="mt-4">
                    {{ $noticias->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        let estadoActual = 'todos';

        function aplicarFiltros() {
            const filas = document.querySelectorAll('tbody tr');
            const mes = document.getElementById('filtroMes').value;
            const ano = document.getElementById('filtroYear').value;

            filas.forEach(fila => {
                const filaEstado = fila.getAttribute('data-estado')?.trim().toLowerCase();
                const filaMes = fila.getAttribute('data-mes');
                const filaAno = fila.getAttribute('data-year');

                const coincideEstado = (estadoActual === 'todos') || (filaEstado === estadoActual);
                const coincideMes = (mes === '') || (filaMes === mes);
                const coincideAno = (ano === '') || (filaAno === ano);

                fila.style.display = (coincideEstado && coincideMes && coincideAno) ? 'table-row' : 'none';
            });
        }

        function filtrarEstado(estadoSeleccionado) {
            estadoActual = estadoSeleccionado.trim().toLowerCase();
            aplicarFiltros();
        }

        function filtrarFecha() {
            aplicarFiltros();
        }

        document.addEventListener('DOMContentLoaded', function () {
            aplicarFiltros();
            document.getElementById('filtroMes').addEventListener('change', filtrarFecha);
            document.getElementById('filtroYear').addEventListener('change', filtrarFecha);
        });
    </script>
</x-app-layout>
