<div class="alert alert-warning" role="alert">
    Die richtige{{ $question->correctAnswerCount > 1 ? 'n' : ''}} Antwort{{ $question->correctAnswerCount > 1 ? 'en' : ''}} lauten: <br>
    <ul>
        @foreach($question->answers as $key => $answer)
            @if($answer->correct)
                <li><b> {{ $answer->text }}</b></li>
            @endif
        @endforeach
    </ul>
</div>
