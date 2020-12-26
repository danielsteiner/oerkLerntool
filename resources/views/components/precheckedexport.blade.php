<div class="my-5 question" id="question">
   <header class="mb-3">
        <h3>
            {{ $question["question"] }}
        </h3>
        <small>FragenID: {{$question["catalogid"]}} | Kategorie: {{$category}}</small>
    </header>
    <p>
        @foreach($question["answers"] as $key => $answer)
            <label>@if($answer->correct) &#x1f5f9; @else &#x2610; @endif {{ $answer->text }}</label></br>
        @endforeach
    </p>
</div>
