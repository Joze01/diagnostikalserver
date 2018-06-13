<?php

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

//Route::resource('control', 'controladorhl7');


Route::post('hl7/checkin','hl7controller@checkin');
/*Route::post('hl7/checkin', function()
{
    return 'Hello World';
});
*/

Route::post('hl7/checkout','hl7controller@checkout');
Route::post('hl7/acceptMessage','hl7controller@acceptMessage');


Route::post('hl7/acceptMessage2','hl7controller@acceptMessage2');



//EnviarRespueta a SIAPS:
Route::post('hl7/responder','controllersiaps@responder');
Route::post('hl7/marcarEnviada','controllersiaps@marcarEnviada');

//servicios minsal
Route::get('hl7/minCheckin','controllersiaps@checkin');
Route::get('hl7/minCheckout','controllersiaps@checkout');
//servicio asp:
Route::get('hl7/aspCheckin','hl7controller@checkinAsp');
