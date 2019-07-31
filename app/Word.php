<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
