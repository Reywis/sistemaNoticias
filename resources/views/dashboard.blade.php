<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lista de Noticias') }}
        </h2>
    </x-slot>

    <style>
        .max-w-7xl {
            max-width: 105rem;
        }
        .copy-icon {
            visibility: hidden;
            cursor: pointer;
            font-size: 1.25rem;
            color: #5FCFDE;
            transition: visibility 0s, opacity 0.2s ease;
        }
        .copy-cell:hover .copy-icon {
            visibility: visible;
        }
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

        .card-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
        }

        .card-header h3 {
          margin: 0;
          font-size: 25px;
        }

        .card-header i {
          font-size: 25px;
        }

        .card p {
          margin-top: 10px;
          font-size: 15px;
          color: #555;
        }

        /* Colores por estado */
        .verde { background-color: #d4edda; }
        .rojo { background-color: #f8d7da; }
        .amarillo { background-color: #fff3cd; }
        .azul { background-color: #d1ecf1; }

        /* Colores de íconos */
        .verde .card-header i { color: #28a745; }
        .rojo .card-header i { color: #dc3545; }
        .amarillo .card-header i { color: #ffc107; }
        .azul .card-header i { color: #17a2b8; }
    </style>

    <div class="container">
        <div class="card rojo">
          <div class="card-header">
            <h3>Requerido</h3>
            <i class="fas fa-check-circle"></i>
          </div>
          <p style="font-size:25px;font-weight:bold;">{{ $conteos['requerido'] ?? 0 }}</p>
        </div>

        <div class="card amarillo">
          <div class="card-header">
            <h3>En Proceso </h3>
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <p style="font-size:25px;font-weight:bold;">{{ $conteos['en proceso'] ?? 0 }}</p>
        </div>

        <div class="card azul">
          <div class="card-header">
            <h3>Listo</h3>
            <i class="fas fa-exclamation-circle"></i>
          </div>
          <p style="font-size:25px;font-weight:bold;">{{ $conteos['listo'] ?? 0 }}</p>
        </div>

        <div class="card verde">
          <div class="card-header">
            <h3>Verificado</h3>
            <i class="fas fa-info-circle"></i>
          </div>
          <p style="font-size:25px;font-weight:bold;">{{ $conteos['verificado'] ?? 0 }}</p>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">

                <!-- FILTROS -->
                <form id="filtrosForm" method="GET" action="{{ route('dashboard') }}" style="margin-bottom: 20px;">
                    <select name="estado" onchange="this.form.submit()" style="padding:6px; margin-right:8px;">
                        <option value="todos" {{ request('estado', 'todos') == 'todos' ? 'selected' : '' }}>Todos los estados</option>
                        <option value="requerido" {{ request('estado') == 'requerido' ? 'selected' : '' }}>Requerido</option>
                        <option value="en proceso" {{ request('estado') == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="listo" {{ request('estado') == 'listo' ? 'selected' : '' }}>Listo</option>
                        <option value="verificado" {{ request('estado') == 'verificado' ? 'selected' : '' }}>Verificado</option>
                    </select>

                    <select name="mes" onchange="this.form.submit()" style="padding:6px; margin-right:8px;">
                        <option value="">Todos los meses</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('mes') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create(2020, $m, 1)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    <select name="año" onchange="this.form.submit()" style="padding:6px;">
                        <option value="">Todos los años</option>
                        @php
                            $years = $noticias->pluck('fecha_inicio')->map(fn($f) => \Carbon\Carbon::parse($f)->year)->unique()->sortDesc();
                        @endphp
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ request('año') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </form>

                <div class="overflow-x-auto w-full">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">Código</th>
                                <th class="px-4 py-2">Centro</th>
                                <th class="px-4 py-2">Teléfonos</th>
                                <th class="px-4 py-2">Curso</th>
                                <th class="px-4 py-2">Forma Curso</th>
                                <th class="px-4 py-2">Fecha de inicio</th>
                                <th class="px-4 py-2">Días</th>
                                <th class="px-4 py-2">Horas</th>
                                <th class="px-4 py-2">Duración</th>
                                <th class="px-4 py-2">Requisitos</th>
                                <th class="px-4 py-2">Descripción de Curso</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($noticias as $noticia)
                                <tr>
                                    <td class="px-4 py-2">{{ $noticia->id }}</td>
                                    <td class="px-4 py-2">{{ $noticia->centro }}</td>
                                    <td class="px-4 py-2">{{ $noticia->telefonos }}</td>
                                    <td class="px-4 py-2">{{ $noticia->curso }}</td>
                                    <td class="px-4 py-2">{{ $noticia->forma_curso }}</td>
                                    <td class="px-4 py-2">{{ $noticia->fecha_inicio }}</td>
                                    <td class="px-4 py-2">{{ $noticia->dias_curso }}</td>
                                    <td class="px-4 py-2">{{ $noticia->horas }}</td>
                                    <td class="px-4 py-2">{{ $noticia->duracion }}</td>
                                    <td class="px-4 py-2">{{ $noticia->requisitos }}</td>
                                    <td class="px-4 py-2">{{ $noticia->descripcion_curso }}</td>
                                    <td class="px-4 py-2">{{ $noticia->email }}</td>
                                    <td class="px-4 py-2">{{ $noticia->estado }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $noticias->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
