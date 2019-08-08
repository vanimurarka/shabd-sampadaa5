<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{

    public function showIndex(Request $request)
	{
		$word = $request->input('word');
		$synsets = NULL;
		if ($word != NULL)
	    {
	        $utf = urlencode($word);
	        $url = config('shabd-sampadaa.api-base-url')."word?word=".$utf;
	        $output = file_get_contents($url);
	        $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
	            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
	        }, $output);
	        $str = str_replace([":","_"], [", "," "], $str);
	        $receivedData = json_decode($output);
	        // var_dump($receivedData);
	        if (isset($receivedData->synsets))
	        	$synsets = $receivedData->synsets;
	    }
		return view('home',
                   array('word' => $word,'synsets'=>$synsets))->render();
	}

	// mark words as urdu
	public function setUrdu(Request $request)
	{
		$words = $request->input('words');
		if ($words != NULL)
	    {
	    	$utf = urlencode($words);
	        $url = config('shabd-sampadaa.api-base-url')."set-urdu?words=".$utf;
	        $context = "";
	        // $key = ApiKey::where('user_id', '=', Auth::user()->userid)->first();
	        // $key = $key->key;
	        // // var_dump($key);
	        $key = '';
	        $context = stream_context_create(array(
	            'http' => array(
	                'header'  => "X-Authorization: ".$key)
	        ));
	        $output = file_get_contents($url, false, $context);
	        var_dump($output);
	    }
	}

	// mark words as of english origin
	public function setEnglish(Request $request)
	{
		$words = $request->input('words');
		if ($words != NULL)
	    {
	    	$utf = urlencode($words);
	        $url = config('shabd-sampadaa.api-base-url')."set-english?words=".$utf;
	        $context = "";
	        // $key = ApiKey::where('user_id', '=', Auth::user()->userid)->first();
	        // $key = $key->key;
	        // // var_dump($key);
	        $key = '';
	        $context = stream_context_create(array(
	            'http' => array(
	                'header'  => "X-Authorization: ".$key)
	        ));
	        $output = file_get_contents($url, false, $context);
	        var_dump($output);
	    }
	}
}
