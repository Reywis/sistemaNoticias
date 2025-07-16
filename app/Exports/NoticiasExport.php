<?php
namespace App\Exports;

use App\Models\Noticia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NoticiasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Noticia::select(
            'centro',
            'telefonos',
            'curso',
            'forma_curso',
            'fecha_inicio',
            'dias_curso',
            'horas',
            'duracion',
            'email',
            'requisitos',
            'descripcion_curso'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Centro',
            'Teléfonos',
            'Curso',
            'Forma Curso',
            'Fecha de Inicio',
            'Días del Curso',
            'Horas',
            'Duración',
            'Correo Electrónico',
            'Requisitos',
            'Descripcion del Curso'
        ];
    }
}
