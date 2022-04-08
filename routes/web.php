<?php
use App\Http\Controllers\StudentController;
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
    return view('welcome');
});
Route::get('student', 'App\Http\Controllers\StudentController@index');
Route::post('student', 'App\Http\Controllers\StudentController@store')->name('student.store');
Route::get('student/{id}/edit', 'App\Http\Controllers\StudentController@edit')->name('student.edit');
Route::put('student/update', 'App\Http\Controllers\StudentController@update')->name('student.update');
Route::delete('student/{id}/delete', 'App\Http\Controllers\StudentController@destroy')->name('student.delete');

