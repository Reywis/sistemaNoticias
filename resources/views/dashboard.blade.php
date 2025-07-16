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
              <p style="font-size:25px;font-weight:bold;">{{$conteos['en proceso'] ?? 0 }}</p>
            </div>

            <div class="card azul">
              <div class="card-header">
                <h3>Listo</h3>
                <i class="fas fa-exclamation-circle"></i>
              </div>
              <p style="font-size:25px;font-weight:bold;">{{$conteos['listo'] ?? 0 }}</p>
            </div>

            <div class="card verde">
              <div class="card-header">
                <h3>Verificado</h3>
                <i class="fas fa-info-circle"></i>
              </div>
              <p style="font-size:25px;font-weight:bold;">{{$conteos['verificado'] ?? 0 }}</p>
            </div>
          </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
                <div style="display: inline-block; float: right; margin-bottom: 20px;">
                    <!-- FILTRO MES -->
                    <select id="filtroMes" onchange="filtrarFecha()" style="padding:6px; margin-right:8px;">
                      <option value="">Todos los meses</option>
                      @for($m = 1; $m <= 12; $m++)
                      <option value="{{ $m }}">
                        {{ \Carbon\Carbon::create(2020, $m, 1)->translatedFormat('F') }}
                      </option>
                      @endfor
                    </select>

                    <!-- FILTRO AÑO -->
                    <select id="filtroYear" onchange="filtrarFecha()" style="padding:6px;">
                      <option value="">Todos los años</option>
                      @php
                        $years = $noticias->pluck('fecha_inicio')
                                          ->map(fn($f) => \Carbon\Carbon::parse($f)->year)
                                          ->unique()
                                          ->sortDesc();
                      @endphp
                      @foreach($years as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                      @endforeach
                    </select>
                  </div>
                <div style="margin-bottom: 20px;">
                    <h2 style="padding-bottom:15px;">Estado del Arte</h2>
                    <button onclick="filtrarEstado('todos')" style="border-radius:8px;background: gray; color: black; padding: 8px 12px; margin-right: 8px;">Todos</button>
                    <button onclick="filtrarEstado('requerido')" style="border-radius:8px;background: #f8d7da; color: black; padding: 8px 12px; margin-right: 8px;">Requerido</button>
                    <button onclick="filtrarEstado('en proceso')" style="border-radius:8px;background: #fff3cd; color: black; padding: 8px 12px; margin-right: 8px;">En Proceso</button>
                    <button onclick="filtrarEstado('listo')" style="border-radius:8px;background: #d1ecf1; color: black; padding: 8px 12px; margin-right: 8px;">Listo</button>
                    <button onclick="filtrarEstado('verificado')" style="border-radius:8px;background: #d4edda; color: black; padding: 8px 12px;">Verificado</button>
                </div>


                <!-- BOTONES DE ACCIÓN -->
                <div class="flex mb-4">
                    <a href="{{ route('noticias.exportar') }}" class="btn btn-success mb-3" style="margin-left:15px !important;background:#d1ecf1;border-radius:10px;color:white;padding:12px;">📥 Exportar a Excel</a>
                    <form method="POST" action="{{ route('noticias.eliminarTodas') }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar todas las noticias?')" style="margin-left:15px !important;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" style="background:#f8d7da !important;">Eliminar Todas</button>
                    </form>



                    <form method="POST" action="{{ route('noticias.eliminarLotes') }}" id="loteForm" onsubmit="return confirm('¿Estás seguro de que deseas eliminar las noticias seleccionadas?')" style="margin-left:15px !important;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ids" id="selected_ids">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" style="background:#d1ecf1;border-radius:10px;color:white;padding:12px;">Eliminar Seleccionados</button>
                    </form>
                </div>

                <div class="overflow-x-auto w-full">

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">
                                    <input type="checkbox" id="select_all" class="form-checkbox">
                                </th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Código</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Centro</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Teléfonos</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Curso</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Forma Curso</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Fecha de inicio</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Días</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Horas</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Duración</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Requisitos</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Descripcion de Curso</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Email</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Estado</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($noticias as $noticia)
                            @php $dt = \Carbon\Carbon::parse($noticia->fecha_inicio); @endphp
                                {{-- <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition"> --}}
                                    <tr data-mes="{{ $dt->month }}" data-year="{{ $dt->year }}" data-estado="{{ strtolower($noticia->estado) }}"
                                        @if($noticia->estado == 'requerido')
                                            style="background: #f8d7da; color: black;color:black;"
                                        @elseif($noticia->estado == 'Requerido')
                                            style="background: #f8d7da; color: black;color:black;"
                                        @elseif($noticia->estado == 'en proceso')
                                            style="background: #fff3cd; color: black;"
                                        @elseif($noticia->estado == 'listo')
                                            style="background: #d1ecf1; color: black !important;"
                                        @elseif($noticia->estado == 'verificado')
                                            style="background: #d4edda; color: black;"
                                        @endif
                                    >
                                    {{-- <tr class=" hover:bg-gray-50 dark:hover:bg-gray-700 transition"> --}}
                                    <td class="px-4 py-2 text-center">
                                        <input type="checkbox" class="form-checkbox row-checkbox" value="{{ $noticia->id }}">
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100 copy-cell">
                                        <span>{{ $noticia->estado }}</span>
                                        <span class="copy-icon" onclick="copyToClipboard('{{ $noticia->id }}')">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100 copy-cell">
                                        <span>{{ $noticia->centro }}</span>
                                        <span class="copy-icon" onclick="copyToClipboard('{{ $noticia->centro }}')">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100 copy-cell">
                                        <span>{{ $noticia->telefonos }}</span>
                                        <span class="copy-icon" onclick="copyToClipboard('{{ $noticia->telefonos }}')">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100 truncate max-w-xs" title="{{ $noticia->curso }}">
                                        <span>{{ $noticia->curso }}</span>
                                        <span class="copy-icon" onclick="copyToClipboard('{{ $noticia->curso }}')">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100 truncate max-w-xs" title="{{ $noticia->forma_curso }}">
                                        <span>{{ $noticia->forma_curso }}</span>
                                        <span class="copy-icon" onclick="copyToClipboard('{{ $noticia->forma_curso }}')">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $noticia->fecha_inicio }}</td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $noticia->dias_curso }}</td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $noticia->horas }}</td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $noticia->duracion }}</td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100 truncate max-w-xs" title="{{ $noticia->requisitos }}">
                                        <span>{{ $noticia->requisitos }}</span>
                                        <span class="copy-icon" onclick="copyToClipboard('{{ $noticia->requisitos }}')">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </td>
                                     <td class="px-4 py-2 text-gray-800 dark:text-gray-100 truncate max-w-xs" title="{{ $noticia->descripcion_curso }}">
                                        <span>{{ $noticia->descripcion_curso }}</span>
                                        <span class="copy-icon" onclick="copyToClipboard('{{ $noticia->descripcion_curso }}')">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100 truncate max-w-xs" title="{{ $noticia->email }}">
                                        <span>{{ $noticia->email }}</span>
                                        <span class="copy-icon" onclick="copyToClipboard('{{ $noticia->email }}')">
                                            <i class="fas fa-copy"></i>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100">{{ $noticia->estado }}</td>
                                    <td class="px-4 py-2">
                                        <form method="POST" action="{{ route('noticias.actualizarEstado', $noticia->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="estado" class="form-select px-3 py-2 text-xs font-semibold rounded-lg w-full">
                                                <option value="requerido" {{ $noticia->estado == 'requerido' ? 'selected' : '' }} style="background:#f8d7da;color:white !important;">Requerido</option>
                                                <option value="en proceso" {{ $noticia->estado == 'en proceso' ? 'selected' : '' }} style="background:#fff3cd;">En Proceso</option>
                                                <option value="listo" {{ $noticia->estado == 'listo' ? 'selected' : '' }} style="background:#d1ecf1;color:white !important;">Listo</option>
                                                <option value="verificado" {{ $noticia->estado == 'verificado' ? 'selected' : '' }} style="background:#d4edda;color:white !important;">Verificado</option>
                                            </select>
                                            <button type="submit" class="btn mt-3 px-4 py-2 rounded-lg shadow text-white" style="background:#5FCFDE;">Actualizar</button>
                                        </form>
                                    </td>
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

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert("¡Texto copiado!");
            }).catch(function(error) {
                alert("Error al copiar: " + error);
            });
        }

        // Seleccionar todos los checkboxes
        document.getElementById('select_all').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Al enviar el formulario de eliminar por lote
        document.getElementById('loteForm').addEventListener('submit', function (e) {
            const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
            document.getElementById('selected_ids').value = selected.join(',');
        });
    </script>
<script>
    // function filtrarEstado(estadoSeleccionado) {
    //     const filas = document.querySelectorAll("tbody tr");

    //     filas.forEach(fila => {
    //         const estadoFila = fila.getAttribute("data-estado");

    //         if (estadoSeleccionado === 'todos') {
    //             fila.style.display = 'table-row'; // ← esto asegura que se vea
    //         } else if (estadoFila === estadoSeleccionado) {
    //             fila.style.display = 'table-row';
    //         } else {
    //             fila.style.display = 'none';
    //         }
    //     });
    // }
    function filtrarEstado(estadoSeleccionado) {
    const filas = document.querySelectorAll("tbody tr");

    filas.forEach(fila => {
        const estadoFila = fila.getAttribute("data-estado");
        console.log(`Seleccionado: ${estadoSeleccionado} | Fila: ${estadoFila}`);

        if (estadoSeleccionado === 'todos') {
            fila.style.display = 'table-row';
        } else if (estadoFila === estadoSeleccionado) {
            fila.style.display = 'table-row';
        } else {
            fila.style.display = 'none';
        }
    });
}
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
      const filtroMes = document.getElementById('filtroMes');
      const filtroAño = document.getElementById('filtroYear');

      // Llamamos a la función de filtrado inicial
      filtrarFecha(filtroMes.value, filtroAño.value);

      // Escuchamos los cambios en los selectores
      filtroMes.addEventListener('change', function () {
        filtrarFecha(filtroMes.value, filtroAño.value);
      });

      filtroAño.addEventListener('change', function () {
        filtrarFecha(filtroMes.value, filtroAño.value);
      });
    });

    function filtrarFecha(mes, año) {
      const filas = document.querySelectorAll('tbody tr');
      filas.forEach(fila => {
        const filaMes = fila.getAttribute('data-mes');
        const filaAño = fila.getAttribute('data-year');

        console.log(`Filtrando fila: mes=${filaMes}, año=${filaAño} | filtro: mes=${mes}, año=${año}`);

        // Comprobamos si el mes y el año de la fila coinciden con lo seleccionado
        if ((mes === '' || filaMes === mes) && (año === '' || filaAño === año)) {
          fila.style.display = 'table-row'; // Mostramos la fila
        } else {
          fila.style.display = 'none'; // Ocultamos la fila
        }
      });
    }
  </script>

</x-app-layout>
