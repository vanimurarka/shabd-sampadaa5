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

Route::get('/test', function () {
    return response('Test API', 200)
                  ->header('Content-Type', 'application/json');
});

Route::get('word', function(Request $request) {
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
	    
});
Route::get('/set-urdu','DBEnhancer@setUrdu');
Route::get('/set-english','DBEnhancer@setEnglish');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
