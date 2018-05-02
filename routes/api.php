<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers:Authorization, X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers, X-XSRF-TOKEN, Origin, X-Auth-Token, Authorization');//nerima header apa aja
header('Access-Control-Allow-Methods:GET,POST,PUT,PATCH,DELETE,HEAD, OPTIONS');

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/rooms', 'Admin\RoomsController@allroom'); //ALL ROOMS
Route::get('/rooms/{roomid}', 'Admin\RoomsController@getroomid'); //GET A ROOM BY ID
Route::post('/rooms', "Admin\RoomsController@postroom"); // POST A ROOM
Route::delete('/rooms/{roomid}', "Admin\RoomsController@deleteroom"); // DELETE A ROOM
Route::put('/rooms/{roomid}', "Admin\RoomsController@updateroom"); // UPDATE A ROOM
Route::post('availablerooms', "Admin\RoomsController@availablerooms"); // AVAILABLE ROOMS


Route::get('/bookings', 'Admin\BookingsController@allbookings'); //ALL BOOKINGS
Route::get('/bookings/{bookingid}', 'Admin\BookingsController@getbookingid'); //GET A BOOKINGS BY ID
Route::post('/postbooking', "Admin\BookingsController@postbooking"); // POST A BOOKINGS
Route::delete('/bookings/{bookingid}', "Admin\BookingsController@deletebooking"); // DELETE A BOOKINGS
Route::put('/bookings/{bookingid}', "Admin\BookingsController@updatebooking"); // UPDATE A BOOKINGS
