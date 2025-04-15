<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registramos tu noticia</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .step {
            text-align: center;
            position: relative;
            width: 25%;
        }
        .step::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 5px;
            background-color: #ccc;
            z-index: -1;
            transform: translate(-50%, -50%);
        }
        .step .circle {
            width: 40px;
            height: 40px;
            margin: 0 auto 10px;
            border-radius: 50%;
            background-color: #ccc;
            line-height: 40px;
            color: white;
            font-weight: bold;
        }
        .step.active .circle {
            background-color: #5FCFDE;
        }
        .step.completed .circle {
            background-color: #5FCFDE;
        }
        .step .label {
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="bg-light">
    <button class="btn btn-primary" onclick="new bootstrap.Modal(document.getElementById('noticiaGuardadaModal')).show();">
        Probar modal
    </button>
    <div class="modal fade" id="noticiaGuardadaModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-success text-white">
              <h5 class="modal-title" id="modalTitle">Noticia Registrada</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              Tu noticia se ha cargado correctamente. Hemos enviado los datos a tu correo electrónico.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
            </div>
          </div>
        </div>
      </div>

      @if(session('success'))
    <script>
        window.onload = function() {
            var modal = new bootstrap.Modal(document.getElementById('noticiaGuardadaModal'));
            modal.show();
        };
    </script>
    @endif
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white text-center" style="background:#5FCFDE !important;">
                    <h3 class="mb-0" >Registra tu Noticia</h3>
                </div>
                <div class="card-body">
                    <!-- Tabs de navegación -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="registrar-tab" data-bs-toggle="tab" href="#registrar" role="tab" aria-controls="registrar" aria-selected="true">Registrar Noticia</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="consultar-tab" data-bs-toggle="tab" href="#consultar" role="tab" aria-controls="consultar" aria-selected="false">Consultar Estado</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Formulario Registrar Noticia -->
                        <div class="tab-pane fade show active" id="registrar" role="tabpanel" aria-labelledby="registrar-tab">
                            <form action="{{ route('noticias.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="centro" class="form-label">Centro</label>
                                    <select class="form-select" id="centro" name="centro" required>
                                        <option value="" disabled selected>Seleccione un centro</option>
                                        <option value="Regional Sur">Regional Sur</option>
                                        <option value="Regional Centro">Regional Centro</option>
                                        <option value="Regional Centro CFPIM">Regional Centro CFPIM</option>
                                        <option value="Regional Litoral Atlántico">Regional Litoral Atlántico</option>
                                        <option value="Regional Noroccidental">Regional Noroccidental</option>
                                                                             <!-- Agrega más opciones según necesites -->
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="telefonos" class="form-label">Teléfonos</label>
                                    <input type="text" class="form-control" id="telefonos" name="telefonos" required>
                                </div>

                                <div class="mb-3">
                                    <label for="curso" class="form-label">Curso</label>
                                    <input type="text" class="form-control" id="curso" name="curso" required>
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                </div>

                                <div class="mb-3">
                                    <label for="dias_curso" class="form-label">Días del Curso</label>
                                    <input type="text" class="form-control" id="dias_curso" name="dias_curso" required>
                                </div>

                                <div class="mb-3">
                                    <label for="horas" class="form-label">Horas</label>
                                    <input type="text" class="form-control" id="horas" name="horas" required>
                                </div>

                                <div class="mb-3">
                                    <label for="duracion" class="form-label">Duración</label>
                                    <input type="text" class="form-control" id="duracion" name="duracion" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="requisitos" class="form-label">Requisitos</label>
                                    <textarea class="form-control" id="requisitos" name="requisitos" rows="4" placeholder="Escribe aquí los requisitos del curso..." required></textarea>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary" style="background:#5FCFDE !important;">Enviar Noticia</button>
                                </div>
                            </form>
                        </div>

                        <!-- Formulario Consultar Estado -->
                        <div class="tab-pane fade" id="consultar" role="tabpanel" aria-labelledby="consultar-tab">
                            <form method="GET" action="{{ route('noticias.estado') }}">
                                <div class="mb-3">
                                    <label for="id" class="form-label">Código de la noticia</label>
                                    <input type="number" name="id" id="id" class="form-control" placeholder="Ej. 12" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success" style="background:#5FCFDE !important;">Consultar Estado</button>
                                </div>
                            </form>
                            @if(isset($noticia))
                                @php
                                    $estados = ['Requerido', 'En Proceso', 'Listo', 'Verificado'];
                                    $colores = [
                                        'Requerido' => 'red',      // Azul
                                        'En Proceso' => 'yellow',     // Naranja
                                        'Listo' => 'green',          // Verde
                                        'Verificado' => 'blue'      // Morado
                                    ];

                                    $estadoActual = ucwords(strtolower($noticia->estado));
                                    $estadoIndex = array_search($estadoActual, $estados);
                                @endphp

                                <div class="text-center my-4">
                                    <h5 class="mb-3">Estado Actual de la Noticia código {{$noticia->id}}</h5>
                                    <div class="d-flex justify-content-between align-items-center px-5" style="position: relative;">
                                        @foreach($estados as $index => $estado)
                                            @php
                                                $color = $colores[$estado] ?? '#ccc';
                                                $isActive = $index <= $estadoIndex;
                                            @endphp
                                            <div class="text-center" style="flex: 1;">
                                                <div class="rounded-circle"
                                                    style="width: 30px; height: 30px; margin: 0 auto; line-height: 30px;
                                                            background-color: {{ $isActive ? $color : '#e9ecef' }};
                                                            color: {{ $isActive ? '#fff' : '#6c757d' }};">
                                                    {{ $index + 1 }}
                                                </div>
                                                <small class="d-block mt-1"
                                                    style="color: {{ $isActive ? $color : '#6c757d' }};
                                                            font-weight: {{ $isActive ? 'bold' : 'normal' }};">
                                                    {{ $estado }}
                                                </small>
                                            </div>
                                            @if($index < count($estados) - 1)
                                                <div style="flex: none; width: 25%; height: 2px;
                                                            background-color: {{ $index < $estadoIndex ? $colores[$estados[$index]] : '#ccc' }};">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-center mt-3 text-muted">Gracias por contribuir con tu información.</p>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const newsId = urlParams.get('id'); // Obtén el id de la URL

        if (newsId) {
            // Si hay un id en la URL, activa el tab "Consultar Estado"
            const consultarTab = new bootstrap.Tab(document.getElementById('consultar-tab'));
            consultarTab.show();

            // Rellenar el campo con el id
            document.querySelector('input[name="id"]').value = newsId;

            // Opcional: Enviar la consulta para obtener el estado (no se debe enviar el formulario automáticamente)
            // Si ya existe el parámetro "id", la vista se debe cargar con el estado de la noticia
        }
    };
</script>

</body>
</html>
