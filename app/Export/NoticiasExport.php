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
            'fecha_inicio',
            'dias_curso',
            'horas',
            'duracion',
            'email',
            'requisitos'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Centro',
            'Teléfonos',
            'Curso',
            'Fecha de Inicio',
            'Días del Curso',
            'Horas',
            'Duración',
            'Correo Electrónico',
            'Requisitos'
        ];
    }
}
