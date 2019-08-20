<?php

use Illuminate\Http\Request;
use App\Word;
use App\Synset;

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

//SIMPLE API KEY AUTHENTICATION FROM
// https://medium.com/@kevincristella/basic-token-based-api-authentication-with-laravel-aeed0050dd0d
Route::get('/set-urdu/{api_token}', 'DBEnhancer@setUrdu')->middleware('api_token');
Route::get('/set-english/{api_token}', 'DBEnhancer@setEnglish')->middleware('api_token');
Route::get('/word/{api_token}', function(Request $request) 
{
    $word = $request->input('word');
    // return mb_strpos($word, "ज़");
    $words = Word::findWord($word);
    $data = [];
    $data['word']=$words;
    if (count($words) > 0)
    {
        $synsets = Synset::getSynsets($words[0]->synsets);
        $data['synsets'] = $synsets;
    }
    else
    {
        // return "in else";
        // return mb_substr($word,0,1);
        // return mb_strpos($word,'ज़');
        if (mb_strpos($word,'ज़') >= 0)
        {
            $word = str_replace("ज़", "ज़", $word);
            // return $word;
            $words = Word::findWord($word);
            if (count($words) > 0)
            {
                $synsets = Synset::getSynsets($words[0]->synsets);
                $data['synsets'] = $synsets;
            }
        }
    }
    return response()->json($data);
	    
})->middleware('api_token','cors');


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
