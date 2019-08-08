<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;

class DBEnhancer extends Controller
{
    public function setUrdu(Request $request)
    {
		$words = $request->input('words');
		$result = Word::setLanguage($words,'ur');
		return $result;
    }

    public function setEnglish(Request $request)
    {
		$words = $request->input('words');
		$result = Word::setLanguage($words,'en');
		return $result;
    }
}
