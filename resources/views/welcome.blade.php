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
            background-color: #0d6efd;
        }
        .step.completed .circle {
            background-color: #198754;
        }
        .step .label {
            font-size: 0.9rem;
        }
    </style>
</head>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Registra tu Noticia</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('noticias.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="centro" class="form-label">Centro</label>
                            <input type="text" class="form-control" id="centro" name="centro" required>
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
                            <button type="submit" class="btn btn-primary">Enviar Noticia</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Consultar estado por ID -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white text-center">
        <h4 class="mb-0">Consultar Estado</h4>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('noticias.estado') }}">
            <div class="mb-3">
                <label for="id" class="form-label">Código de la noticia</label>
                <input type="number" name="id" id="id" class="form-control" placeholder="Ej. 12" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Consultar Estado</button>
            </div>
        </form>
    </div>
</div>

@if(isset($noticia))
    @php
        $estados = ['Requerido', 'En Proceso', 'Listo', 'Verificado'];
        $estadoActual = ucwords(strtolower($noticia->estado));
        $estadoIndex = array_search($estadoActual, $estados);
    @endphp

    <div class="text-center my-4">
        <h5 class="mb-3">Estado Actual de la Noticia codigo {{$noticia->id}}</h5>
        <div class="d-flex justify-content-between align-items-center px-5" style="position: relative;">
            @foreach($estados as $index => $estado)
                <div class="text-center" style="flex: 1;">
                    <div class="rounded-circle {{ $index <= $estadoIndex ? 'bg-success text-white' : 'bg-light text-muted' }}"
                         style="width: 30px; height: 30px; margin: 0 auto; line-height: 30px;">
                        {{ $index + 1 }}
                    </div>
                    <small class="d-block mt-1 {{ $index <= $estadoIndex ? 'text-success fw-bold' : 'text-muted' }}">
                        {{ $estado }}
                    </small>
                </div>
                @if($index < count($estados) - 1)
                    <div style="flex: none; width: 25%; height: 2px; background-color: {{ $index < $estadoIndex ? '#28a745' : '#ccc' }};"></div>
                @endif
            @endforeach
        </div>
    </div>
@endif


            <p class="text-center mt-3 text-muted">Gracias por contribuir con tu información.</p>
        </div>
    </div>
</div>



<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
