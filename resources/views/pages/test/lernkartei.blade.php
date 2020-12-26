@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $test->title }}</div>
                <div class="card-body">
                    <form method="post" action="{{ url('lernkartei/'.$test->id.'/answer') }}" name="lernkartei">
                        @include('components.question', ["question"=>$question->question, 'category' => $category])
                        @csrf
                        <div id="answer" class="hidden">
                            @include("components.answer", ["question"=> json_decode(json_encode($question->question))])
                        </div>
                        <input type="hidden" name="currentLevel" value="{{ $question->currentLevel }}">
                        <input type="hidden" name="test_id" value="{{ $test->id}} ">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="btn-group" role="group" aria-label="Aktionen">
                            <a class="btn btn-primary pull-right" id="submit">Nächste Frage</a>
                            <a class="btn btn-danger pull-right" href="{{ url('/lernkartei/'.$test->id.'/level/'.$level) }}">Frage überspringen</a>
                            <a class="btn btn-warning pull-right" id="idontknow">Ich weiß es nicht</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    document.addEventListener('click', function (event) {
        var answerarea = document.getElementById('answer');
        if(event.target.matches('#idontknow')) {
            var submit = document.getElementById('submit');
            answerarea.classList.remove("hidden");
            checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.disabled = true
            });
            submit.classList.add('disabled');
        }
        if(event.target.matches('#submit')) {
            var submit = document.getElementById('submit');
            answerarea.classList.remove("hidden");
            checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var answers = JSON.parse('{!! addslashes(json_encode($question->question['answers'])) !!}');
            var correctAnswers = [];
            for (var k in answers){
                if (answers.hasOwnProperty(k)) {
                    if(answers[k].correct) {
                        correctAnswers.push(k);
                    }
                }
            }

            var answeredCorrectly = false;
            checkedAnswers = [];
            for (var index in checkboxes) {
                if(checkboxes.hasOwnProperty(index)) {
                    if(checkboxes[index].checked == true) {
                        checkedAnswers.push(index);
                    }
                }
            }
            var card = document.querySelector('#question');
            var body = card.querySelector('.card-body');
            submit.classList.add('disabled');
            if(arrays_equal(checkedAnswers, correctAnswers)){
                card.classList.add('border-success');
                body.classList.add('text-success');
                card.classList.remove('border-secondary');
                body.classList.remove('text-secondary');
                setTimeout(function(){ document.forms["lernkartei"].submit(); }, 2500);
            } else {
                card.classList.add('border-danger');
                body.classList.add('text-danger');
                card.classList.remove('border-secondary');
                body.classList.remove('text-secondary');
                setTimeout(function(){ document.forms["lernkartei"].submit(); }, 5000);
            }

        }
    }, false);

    function arrays_equal(a, b) {
        return JSON.stringify(a) == JSON.stringify(b);
    }
    </script>
@endsection
