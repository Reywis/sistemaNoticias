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
                if ($noticia !== null) {
                // Aquí accedes a las propiedades de $noticia de manera segura
                // Enviar el correo
                Mail::send('emails.template',[ 'noticia' => $noticia], function ($message) use ($noticia) {
                    $message->to($noticia->email)
                            ->subject('Confirmación de solicitud de publicación');
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

       // return redirect()->back()->with('success', 'Noticia creada exitosamente.');
       return redirect()->route('welcome')->with('success', 'Noticia creada exitosamente.');
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
            Mail::send('emails.templateEstado',[ 'noticia' => $noticia], function ($message) use ($noticia) {
                $message->to($noticia->email)
                        ->subject('Actualizacion del estadi de la publicación');
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
