<div class="card border-secondary mb-3" id="question">
  <div class="card-body text-secondary">
    <h5 class="card-title">
        {{ $question["question"] }}
        @if(isset($category)) <br> <small class="text-right">{{ $category }}</small> @endif
    </h5>
    <p class="card-text">
        @foreach($question["answers"] as $key => $answer)

            <label><input type="checkbox" name="answers[{{ $question['catalog_id'] }}][]" value="{{ $key }}"> {{ $answer['text'] }}</label></br>
        @endforeach
    </p>
  </div>
</div>
