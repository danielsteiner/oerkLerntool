<div class="card border-{{ $question->answeredCorrectly? 'success' : 'danger' }} mb-3" id="$question->id">
  <div class="card-body text-{{ $question->answeredCorrectly? 'success' : 'danger' }}">
    <h5 class="card-title">{{ $question->question }}</h5>
    <p class="card-text">
        @foreach($question->answers as $key => $answer)
            {{ $answer->correct ? '✔️' : '❌' }}<input type="checkbox" {{ property_exists($answer, "wasAnswered") && $answer->wasAnswered ? 'checked="checked"' : '' }} disabled/>{{ $answer->text }}<br>
        @endforeach
        @include('components.answer', ["question"=>$question])
    </p>
  </div>
</div>
