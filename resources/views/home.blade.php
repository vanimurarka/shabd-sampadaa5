<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>शब्द सम्पदा: Shabd Sampadaa: Hindi Thesaurus</title>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<script type="text/javascript">
	function hexc(colorval) {
	    var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
	    delete(parts[0]);
	    for (var i = 1; i <= 3; ++i) {
	        parts[i] = parseInt(parts[i]).toString(16);
	        if (parts[i].length == 1) parts[i] = '0' + parts[i];
	    }
	    return '#' + parts.join('');
	}
	function selectword(id)
	{
		// alert(id);
		color = hexc($(id).css('background-color'));
		if (color=="#ffffff")
			$(id).css( "background-color", "red" );
		else
			$(id).css( "background-color", "white" );
	}
	function getSelectedWords()
	{
		words = '';
		$('.word').each(function(index) {
		    color = hexc($(this).css('background-color'));
		    if (color=="#ff0000")
		    	words += $(this).text() + ",";
		    // console.log(index + ": " + $( this ).text());
		});
		console.log(words);
		return words;
	}
	function markUrdu()
	{
		//get selected words
		words = getSelectedWords();
		console.log(words);
		//call api
		$("#ur-selected-words").val(words);
		$("#set-urdu-form").submit();
		console.log('form submitted');
	}
	function markEnglish()
	{
		//get selected words
		words = getSelectedWords();
		console.log(words);
		//call api
		$("#en-selected-words").val(words);
		$("#set-english-form").submit();
		console.log('form submitted');
	}
</script>
</head>
<body>

<h1>Shabd Sampadaa शब्द सम्पदा</h1>
@if (Auth::check())
    Welcome editing user<br/><br/>
@endif

<form method="GET" action="{{route('search')}}">
Word: <input name="word" type="text" value="{{$word}}">
<input class="submit" type="submit" value="Search">
</form>

{{$word}}<br/><br/>
<?php $loggedIn = Auth::check(); ?>
@if ($synsets != NULL)
	<?php $wordid = 1 ?>
	@foreach ($synsets as $synset)
		@if (count($synset->linkedwords)>0)
			<?php 
				$hiwordsHTML = '';
				$urwordsHTML = '';
				$enwordsHTML = '';
			?>
			@foreach ($synset->linkedwords as $word)
				@if ($loggedIn)
					@if ($word->language == 'ur')
						<?php $urwordsHTML .= "<div style='display:inline-block;min-width:100px;background-color:white' class='word' id='word".$wordid."' onclick=".'"'."selectword('#word".$wordid++ ."');".'"'.">".$word->word."</div>";
						?>
					@elseif ($word->language == 'en')
						<?php $enwordsHTML .= "<div style='display:inline-block;min-width:100px;background-color:white' class='word' id='word".$wordid."' onclick=".'"'."selectword('#word".$wordid++ ."');".'"'.">".$word->word."</div>";
						?>
					@else
						<?php $hiwordsHTML .= "<div style='display:inline-block;min-width:100px;background-color:white' class='word' id='word".$wordid."' onclick=".'"'."selectword('#word".$wordid++ ."');".'"'.">".$word->word."</div>";
						?>
					@endif
				@else
					@if ($word->language == 'ur')
						<?php $urwordsHTML .= "<div style='display:inline-block;min-width:100px;background-color:white' class='word'>".$word->word."</div>";
						?>
					@elseif ($word->language == 'en')
						<?php $enwordsHTML .= "<div style='display:inline-block;min-width:100px;background-color:white' class='word'>".$word->word."</div>";
						?>
					@else
						<?php $hiwordsHTML .= "<div style='display:inline-block;min-width:100px;background-color:white' class='word'>".$word->word."</div>";
						?>
					@endif
				@endif
				
			@endforeach
			<div>{{$hiwordsHTML}}</div>
			<div>{{$urwordsHTML}}</div>
			<div>{{$enwordsHTML}}</div>
		@else
			<?php
				$words = '';
				$words = explode(', ', $synset->words);
			?>
			@foreach ($words as $synsetWord)
				@if ($loggedIn)
					<div style="display:inline-block;min-width:100px;background-color:white" id="word{{$wordid}}" class="word" onclick="selectword('{{'#word'.$wordid++}}');">{{$synsetWord}}</div>
				@else
					<div style="display:inline-block;min-width:100px;background-color:white" class="word">{{$synsetWord}}</div>
				@endif
			@endforeach
			<br/>
		@endif
		{{$synset->sense}}
		<br/><br/>
	@endforeach
	@if ($loggedIn)
		<form method="GET" action="{{route('set-urdu')}}" id="set-urdu-form">
		<input name="words" id="ur-selected-words" type="hidden">
		<input class="submit" type="button" value="Mark Selected Words as Urdu" onclick="markUrdu();">
		</form>
		<br/>
		<form method="GET" action="{{route('set-english')}}" id="set-english-form">
		<input name="words" id="en-selected-words" type="hidden">
		<input class="submit" type="button" value="Mark Selected Words as English" onclick="markEnglish();">
		</form>
	@endif
@endif


</body>
</html>