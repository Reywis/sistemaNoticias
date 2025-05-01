<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Confirmación de Solicitud de Publicación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }
        .email-header img {
            width: 150px;
            margin-bottom: 10px;
        }
        .email-content {
            font-size: 16px;
            color: #333;
        }
        .email-content h2 {
            color: #5FCFDE;
            font-size: 18px;
        }
        .email-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .email-table th,
        .email-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .email-table th {
            background-color: #5FCFDE;
            color: white;
        }
        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
        .btn {
            background-color: #5FCFDE;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class='email-container'>
        <div class='email-header'>
            <img src="https://artespublicitarios.infop.hn/images/logo-black.png" alt="logo" class="flex h-8" style="width:200px;height:auto;">
            <h2>Actualizacion del estado de la publicación</h2>
        </div>

        <div class='email-content'>
            <p>Hola, hemos Actualizado el estado de tu curso. Te avisaremos cuando tu curso cambie de estado.</p>
            <p>A continuación, te dejamos un resumen de tu solicitud:</p>

            <table class='email-table'>
                <tr>
                    <th>Código de consulta</th>
                    <td>{{$noticia->id}}</td>
                </tr>
                <tr>
                    <th>Curso</th>
                    <td>{{$noticia->curso}}</td>
                </tr>
                <tr>
                    <th>Forma Curso</th>
                    <td>{{$noticia->forma_curso}}</td>
                </tr>
                <tr>
                    <th>Requisitos</th>
                    <td>{{$noticia->requisitos}}</td>
                </tr>
                <tr>
                    <th>Teléfonos</th>
                    <td>{{$noticia->telefonos}}</td>
                </tr>
                <tr>
                    <th>Fecha de publicación</th>
                    <td>{{$noticia->fecha_inicio}}</td>
                </tr>
                <tr>
                    <th>Estado actual</th>
                    <td>{{$noticia->estado}}</td>
                </tr>
            </table>

            <p>Gracias por utilizar nuestro sistema.</p>
            <a href='https://artespublicitarios.infop.hn/' class='btn'>Visitar nuestro sitio</a>
        </div>

        <div class='email-footer'>
            <p>&copy; 2025 Tu Empresa. Todos los derechos reservados.</p>
        </div>
    </div>

</body>
</html>
