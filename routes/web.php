<?php
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('Login.Login');
});

//Proses Logout - Add By Giri 04-Okt-2021
Route::get('/Logout', 'Login@Logout');

//Proses Login - Add By Giri 28-Sept-2021
Route::POST('/Auth', 'Login@Auth');

//View Dashboard - Add By Giri 28-Sept-2021
Route::get('/Dashboard', 'Login@Success');

//View Pembagian Pagu - Add By Giri 28-Sept-2021
Route::get('/PembagianPagu', 'Anggaran\PembagianPagu@index');
//Tabel - Add By Giri 28-Sept-2021
Route::get('getPembagianPagu', 'Anggaran\PembagianPagu@getAnggaran');
//Inline Editing - Add By Giri 30-Sept-2021
Route::post('PembagianPagu/Update','Anggaran\PembagianPagu@UpdateAnggaran');

//View Mapping APP - Add By Giri 04-Okt-2021
Route::get('/MappingApp', 'Anggaran\MappingApp@index');
//Tabel - Add By Giri 28-Sept-2021
Route::get('getMapping', 'Anggaran\MappingApp@getMapping');



//DROPDOWN - Add By Giri 28-Sept-2021
Route::post('/findtingkat1', 'Dropdown\Dropdown@findtingkat1');
Route::post('/findtingkat2/req', 'Dropdown\Dropdown@findtingkat2_req');
Route::post('/findtingkat2/multiple', 'Dropdown\Dropdown@findtingkat2_multiple');
Route::post('/findtingkat2', 'Dropdown\Dropdown@findtingkat2');
Route::post('/findtingkat3', 'Dropdown\Dropdown@findtingkat3');
Route::post('/findtingkat4', 'Dropdown\Dropdown@findtingkat4');
Route::post('/findgolongan', 'Dropdown\Dropdown@findgolongan');
Route::post('/findeselon', 'Dropdown\Dropdown@findeselon');
Route::post('/findaktif', 'Dropdown\Dropdown@findaktif');
Route::post('/findbank', 'Dropdown\Dropdown@findbank');
Route::post('/findjenis', 'Dropdown\Dropdowr@findjenis');
Route::post('/findhak', 'Dropdown\Dropdown@findhak');
Route::post('/findhak/Rule', 'Dropdown\Dropdown@findhak_Rule');
Route::post('/findsex', 'Dropdown\Dropdown@findsex');
Route::post('/findagama', 'Dropdown\Dropdown@findagama');
Route::post('/findsatker', 'Dropdown\Dropdown@findsatker');
Route::post('/findapp', 'Dropdown\Dropdown@findapp');
