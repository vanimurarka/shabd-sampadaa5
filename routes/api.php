<?php

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

Route::get('/test', function () {
    return response('Test API', 200)
                  ->header('Content-Type', 'application/json');
});

Route::get('word', function() {
    $data = [];
    return response()->json($data);
	    
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
