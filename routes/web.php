<?php

use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('pages.welcome');
})->middleware(['auth'])->name('home');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('admin',function() { return redirect('/login'); });

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('user', UserController::class);
    Route::post('user/datatable', [UserController::class, 'datatable'])->name('user.datatable');


    Route::get('peserta/import', [PesertaController::class, 'import'])->name('peserta.import');
    Route::post('peserta/import', [PesertaController::class, 'importStore'])->name('peserta.import-save');

    Route::post('peserta/datatable', [PesertaController::class, 'datatable'])->name('peserta.datatable');
    Route::delete('peserta', [PesertaController::class, 'batchDestroy'])->name('peserta.destroy-batch');
    Route::resource('peserta', PesertaController::class)->parameters(['peserta' => 'peserta'])->except('show');
});

// error route
Route::view('404', "errors.404");
// Route::view('403', "errors.403");
Route::view('500', "errors.500");


Route::get('/', [PesertaController::class, 'homepage'])->name('homepage.index');
Route::get('/data/{no_req}', [PesertaController::class, 'homepageData'])->name('homepage.data');