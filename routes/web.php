<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoticiaController;
use App\Models\Noticia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NoticiasExport;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    session(['tab' => 'registro']);
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    $estados = [
        'Requerido' => 0,
        'listo' => 0,
        'verificado' => 0,
        'en proceso' => 0,
    ];
    $noticias = Noticia::orderBy('id', 'asc')->paginate(20);
    $conteos = Noticia::select('estado', DB::raw('count(*) as total'))
        ->groupBy('estado')
        ->pluck('total', 'estado')
        ->toArray();
    $conteos = array_merge($estados, $conteos);

    return view('dashboard',compact('noticias','conteos'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
    Route::post('/admin/noticias/{id}/estado', [NoticiaController::class, 'actualizarEstado'])->name('noticias.actualizarEstadoAdmin');
    Route::delete('/noticias/eliminar-todas', [NoticiaController::class, 'eliminarTodas'])->name('noticias.eliminarTodas');
    Route::delete('/noticias/eliminar-lotes', [NoticiaController::class, 'eliminarLotes'])->name('noticias.eliminarLotes');
    Route::get('/exportar-noticias', function () {
        return Excel::download(new NoticiasExport, 'noticias.xlsx');
    })->name('noticias.exportar');

});
Route::put('/noticias/{id}/estado', [NoticiaController::class, 'actualizarEstado'])->name('noticias.actualizarEstado');

Route::get('/noticias/create', [NoticiaController::class, 'create'])->name('noticias.create');
Route::post('/noticias/store', [NoticiaController::class, 'store'])->name('noticias.store');
Route::get('/noticias/estado', [NoticiaController::class, 'buscarEstado'])->name('noticias.estado');

require __DIR__.'/auth.php';
