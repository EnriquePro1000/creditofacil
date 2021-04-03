<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('RegistrarUsuario',[App\Http\Controllers\Seguridad\UsuarioController::class, 'RegistrarUsuario']);
Route::post('RegistrarUsuario',[App\Http\Controllers\Seguridad\UsuarioController::class, 'registrar']);

Route::get('RegistrarCliente',[App\Http\Controllers\Seguridad\ClienteController::class, 'RegistrarCliente']);
Route::post('RegistrarCliente',[App\Http\Controllers\Seguridad\ClienteController::class, 'create']);

Route::get('ModificarCliente',[App\Http\Controllers\Seguridad\ClienteController::class, 'ObtenerClientes']);

Route::get('ModificarCliente{id}',[App\Http\Controllers\Seguridad\ClienteController::class, 'ModificarClientes']);
Route::post('ModificarCliente{id}',[App\Http\Controllers\Seguridad\ClienteController::class, 'ModificarClient']);

Route::get('ModificarSaldo',[App\Http\Controllers\Prestamos\PrestamoController::class, 'ShowViewModiSal']);
Route::post('ModificarSaldo',[App\Http\Controllers\Prestamos\PrestamoController::class, 'ModificarSaldo']);

Route::get ('HacerPrestamo',[App\Http\Controllers\Prestamos\PrestamoController::class, 'TipoPrestamo']);
Route::post('HacerPrestamo',[App\Http\Controllers\Prestamos\PrestamoController::class, 'HacerPrestamo']);

Route::get ('EditarPrestamo',[App\Http\Controllers\Prestamos\PrestamoController::class, 'EditarPrestamos']);
Route::get ('EditarPrestamo{id}',[App\Http\Controllers\Prestamos\PrestamoController::class, 'EditarPrestamo']);
Route::post('EditarPrestamo{id}',[App\Http\Controllers\Prestamos\PrestamoController::class, 'EditPrestamo']);
Route::get('EliminarPrestamo{id}',[App\Http\Controllers\Prestamos\PrestamoController::class, 'EliminarPrestamo']);

Route::get('RegistrarPago',[App\Http\Controllers\Prestamos\PrestamoController::class, 'ObtenerPrestamos']);

Route::get('RegistrarPago{id}',[App\Http\Controllers\Prestamos\PrestamoController::class, 'ObtenerInformacion']);
Route::post('RegistrarPago{id}',[App\Http\Controllers\Prestamos\PrestamoController::class, 'RegistrarPago']);

Route::post('LiquidarDeuda{id}',[App\Http\Controllers\Prestamos\PrestamoController::class, 'LiquidarDeuda']);

Route::get('HistorialPago',[App\Http\Controllers\Prestamos\PrestamoController::class, 'ObtenerCliente']);

Route::get('HistorialPago{id}',[App\Http\Controllers\Prestamos\PrestamoController::class, 'ObtenerAllPrestamos']);
Route::post('HistorialPago{id}',[App\Http\Controllers\Prestamos\PrestamoController::class, 'ObtenerAllPagos']);


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('home', [App\Http\Controllers\HomeController::class, 'consulta']);
Route::get('/', function () {return redirect('login');});
