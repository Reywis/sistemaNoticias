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
            color: #4A90E2;
            transition: visibility 0s, opacity 0.2s ease;
        }
        .copy-cell:hover .copy-icon {
            visibility: visible;
        }

    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">

                <!-- BOTONES DE ACCIÓN -->
                <div class="flex justify-between mb-4">
                    <a href="{{ route('noticias.exportar') }}" class="btn btn-success mb-3" style="background:blue;border-radius:10px;color:white;padding:12px;">📥 Exportar a Excel</a>
                    <form method="POST" action="{{ route('noticias.eliminarTodas') }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar todas las noticias?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Eliminar Todas</button>
                    </form>



                    <form method="POST" action="{{ route('noticias.eliminarLotes') }}" id="loteForm" onsubmit="return confirm('¿Estás seguro de que deseas eliminar las noticias seleccionadas?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ids" id="selected_ids">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" style="background:red;border-radius:10px;color:white;padding:12px;">Eliminar Seleccionados</button>
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
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Fecha de inicio</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Días</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Horas</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Duración</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Requisitos</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Email</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Estado</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700 dark:text-gray-200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($noticias as $noticia)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-2 text-center">
                                        <input type="checkbox" class="form-checkbox row-checkbox" value="{{ $noticia->id }}">
                                    </td>
                                    <td class="px-4 py-2 text-gray-800 dark:text-gray-100 copy-cell">
                                        <span>{{ $noticia->id }}</span>
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
                                                <option value="requerido" {{ $noticia->estado == 'requerido' ? 'selected' : '' }} style="background:red;color:white;">Requerido</option>
                                                <option value="en proceso" {{ $noticia->estado == 'en proceso' ? 'selected' : '' }} style="background:yellow;">En Proceso</option>
                                                <option value="listo" {{ $noticia->estado == 'listo' ? 'selected' : '' }} style="background:green;color:white;">Listo</option>
                                                <option value="verificado" {{ $noticia->estado == 'verificado' ? 'selected' : '' }} style="background:blue;color:white;">Verificado</option>
                                            </select>
                                            <button type="submit" class="btn mt-3 px-4 py-2 rounded-lg shadow text-white" style="background:#0d6efd;">Actualizar</button>
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
</x-app-layout>
