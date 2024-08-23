<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Tratamientos;
use App\Http\Livewire\Consultas;
use App\Http\Livewire\Pacientes;
use App\Http\Livewire\Reportes;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('consultas',Consultas::class);
    Route::get('tratamientos',Tratamientos::class);
    Route::get('pacientes', Pacientes::class)->name('pacientes');
    Route::get('reportes',Reportes::class);
    Route::get('/exportar-pdf', [Reportes::class, 'exportarPDF'])->name('exportar-pdf');
});





