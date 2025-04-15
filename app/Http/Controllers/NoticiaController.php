<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NoticiaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'centro' => 'required',
            'telefonos' => 'required',
            'fecha_inicio' => 'required|date',
            'dias_curso' => 'required',
            'horas' => 'required',
            'duracion' => 'required',
            'email' => 'required|email'
        ]);
        $requestData = $request->all();
        $requestData['estado'] = 'Requerido'; // Estado inicial
        $noticia = Noticia::create($requestData);
        session(['tab' => 'registro']);
        // Armar el contenido del correo con los datos de la noticia
          /*  $contenido = "Hola, hemos recibido tu solicitud de publicación. Te avisaremos cuando tu noticia cambie de estado.\n\n";
            $contenido .= "Aquí está el resumen de tu solicitud:\n";
            $contenido .= "-------------------------------------\n";
            $contenido .= "Codigo de consulta: {$noticia->id}\n";
            $contenido .= "Curso: {$noticia->curso}\n";
            $contenido .= "Requisitos: {$noticia->requisitos}\n";
            $contenido .= "Telefonos: {$noticia->Telefonos}\n";
            $contenido .= "Fecha de publicación: {$noticia->fecha_inicio}\n";
            $contenido .= "Estado actual: {$noticia->estado}\n";
            $contenido .= "-------------------------------------\n";
            $contenido .= "Gracias por usar nuestro sistema.";*/
            $contenido = "
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
                            color: #4CAF50;
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
                            background-color: #4CAF50;
                            color: white;
                        }
                        .email-footer {
                            text-align: center;
                            font-size: 14px;
                            color: #777;
                            margin-top: 20px;
                        }
                        .btn {
                            background-color: #4CAF50;
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
                            <img src='https://www.tu-sitio.com/logo.png' alt='Logo'>
                            <h2>Confirmación de Solicitud de Publicación</h2>
                        </div>

                        <div class='email-content'>
                            <p>Hola, hemos recibido tu solicitud de publicación. Te avisaremos cuando tu noticia cambie de estado.</p>
                            <p>A continuación, te dejamos un resumen de tu solicitud:</p>

                            <table class='email-table'>
                                <tr>
                                    <th>Código de consulta</th>
                                    <td>{$noticia->id}</td>
                                </tr>
                                <tr>
                                    <th>Curso</th>
                                    <td>{$noticia->curso}</td>
                                </tr>
                                <tr>
                                    <th>Requisitos</th>
                                    <td>{$noticia->requisitos}</td>
                                </tr>
                                <tr>
                                    <th>Teléfonos</th>
                                    <td>{$noticia->Telefonos}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de publicación</th>
                                    <td>{$noticia->fecha_inicio}</td>
                                </tr>
                                <tr>
                                    <th>Estado actual</th>
                                    <td>{$noticia->estado}</td>
                                </tr>
                            </table>

                            <p>Gracias por utilizar nuestro sistema.</p>
                            <a href='https://www.tu-sitio.com' class='btn'>Visitar nuestro sitio</a>
                        </div>

                        <div class='email-footer'>
                            <p>&copy; 2025 Tu Empresa. Todos los derechos reservados.</p>
                        </div>
                    </div>

                </body>
                </html>
                ";

            if ($noticia !== null) {
                // Aquí accedes a las propiedades de $noticia de manera segura
                // Enviar el correo
                Mail::raw($contenido, function ($message) use ($noticia) {
                    $message->to($noticia->email)
                            ->subject('Confirmación de solicitud de publicación')
                            ->setBody($contenido, 'text/html'); // 👈 IMPORTANTE: HTML aquí
                });
                // Mail::raw('Ya hemos registrado tu solicitud. Te informaremos cuando se suba tu noticia.', function ($message) use ($noticia) {
                //     $message->to($noticia->email)
                //             ->subject('Confirmación de solicitud');
                // });

                Log::info('Correo generado para la noticia con ID: ' . $noticia->id);
            } else {
                // Si la noticia es null, puedes hacer algo (registrar el error, etc.)
                Log::error('La noticia no se encontró o es null');
            }

        return redirect()->back()->with('success', 'Noticia creada exitosamente.');
    }

    public function buscarEstado(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);
        $noticia = Noticia::find($request->id); // Buscar la noticia por el ID

        // Si la noticia no existe, redirigir a la vista 'welcome' con un mensaje
        if (!$noticia) {
            return redirect()->route('welcome')->with('mensaje', 'Noticia no encontrada');
        }
        session(['tab' => 'estado']);
        // Si la noticia existe, retornar la vista con los detalles de la noticia
        return view('welcome', compact('noticia'));
    }

    public function index()
    {
        $noticias = Noticia::orderBy('created_at', 'desc')->get();
        return view('admin.noticias.index', compact('noticias'));
    }

    public function actualizarEstado(Request $request, $id)
    {
       /* $noticia = Noticia::findOrFail($id);

        // Validación (opcional)
        $request->validate([
            'estado' => 'required|in:requerido,en proceso,listo,verificado',
        ]);

        // Actualizar el estado
        $noticia->estado = $request->estado;
        $noticia->save();

        return redirect()->route('dashboard')->with('success', 'Estado actualizado exitosamente');*/
            // Encuentra la noticia
            $noticia = Noticia::findOrFail($id);

            // Validación
            $request->validate([
                'estado' => 'required|in:requerido,en proceso,listo,verificado',
            ]);

            // Actualiza el estado
            $noticia->estado = $request->estado;
            $noticia->save();

            // Enviar el correo al usuario informando el cambio de estado
            $contenido = "Hola, el estado de tu noticia ha cambiado a: {$noticia->estado}\n\n";
            $contenido .= "Aquí está el resumen actualizado de tu solicitud:\n";
            $contenido .= "-------------------------------------\n";
            $contenido .= "Codigo de consulta: {$noticia->id}\n";
            $contenido .= "Curso: {$noticia->curso}\n";
            $contenido .= "Requisitos: {$noticia->requisitos}\n";
            $contenido .= "Telefonos: {$noticia->Telefonos}\n";
            $contenido .= "Fecha de publicación: {$noticia->fecha_inicio}\n";
            $contenido .= "Estado actual: {$noticia->estado}\n";
            $contenido .= "-------------------------------------\n";
            $contenido .= "Gracias por usar nuestro sistema.";

            // Enviar correo al usuario
            Mail::raw($contenido, function ($message) use ($noticia) {
                $message->to($noticia->email)
                        ->subject('Estado actualizado de tu solicitud de publicación');
            });

            // Redirigir con mensaje de éxito
            return redirect()->route('dashboard')->with('success', 'Estado actualizado exitosamente');
    }

    // Eliminar todas
    public function eliminarTodas()
    {
        Noticia::truncate();
        return redirect()->back()->with('success', '¡Todas las noticias fueron eliminadas!');
    }

    // Eliminar por lotes
    public function eliminarLotes(Request $request)
    {
        $ids = explode(',', $request->ids);
        Noticia::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', '¡Noticias seleccionadas eliminadas!');
    }

}
