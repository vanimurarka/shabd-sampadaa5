<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Word extends Model
{
    protected $table = 'words';

    public static function findWord($word)
	{
		$words = Word::where('word','=',$word)
					->select('word','pos','synsets')
					->get();
		return $words;
	}

	// set the language [hi,ur,en] for the given words
	public static function setLanguage($words,$language)
	{
		try {
			DB::table('words')
			->whereIn('word',explode(',', $words))
			->update(array('language'=>$language));
			return 1;	
		} catch (Exception $e) {
			return 0;
		}
	}
}
