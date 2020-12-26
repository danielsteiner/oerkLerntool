@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $test->title }}</div>
                <div class="card-body">
                    <p>Mit der folgenden Testsimulation kann schriftlicher Test simuliert werden. Die Bewertung des Tests entspricht den Richtlinien des WRK. Der Punkteschlüssel lautet wie folgt:</p>
                    <ul>
                        <li>EIN Punkt pro korrekt beantworteter Frage</li>
                        <li>KEINE Teilpunkte pro teilweise richtiger Frage</li>
                        <li>KEINE Minuspunkte für falsch beantwortete Fragen</li>
                        <li>Positiv bei einer Punktezahl >=23</li>
                    </ul>
                    <form method="post" action="{{ url('tests/'.$test->id.'/simulation/auswerten') }}">
                        @foreach($questions as $question)
                            @include('components.question', ["question"=>$question])
                        @endforeach
                        @csrf
                        <input type="hidden" name="questions" value="{{ json_encode($questions) }}"/>
                        <input type="hidden" name="test_id" value="{{ $test->id}} ">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="submit" class="btn btn-primary" value="Versuch abgeben">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
