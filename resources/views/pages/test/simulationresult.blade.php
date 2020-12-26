@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
            <div class="card-header">{{ $test->title }}</div>
                <div class="card-body">
                    <p> Bei dem letzten Versuch hattest du {{ $reachedPoints }} von 30 Fragen korrekt. Wäre dies ein echter Test, @if($reachedPoints >= 23) hättest du bestanden. @else hättest du nicht bestanden.@endif</p>
                    <div class="btn-group" role="group" aria-label="Aktionen">
                        <a href="{{ url('/tests/'.$test->id.'/simulation') }}" class="btn btn-primary">Erneut versuchen!</a>
                        <a href="{{ url('/tests/'.$test->id) }}" class="btn btn-secondary">Zurück zur Übersicht</a>
                    </div>
                    <div class="questions mt-3 mb-3">
                        @foreach($questions as $question)
                            @include('components.questionresult', ["question"=>$question])
                        @endforeach
                    </div>
                    <div class="btn-group" role="group" aria-label="Aktionen">
                        <a href="{{ url('/tests/'.$test->id.'/simulation') }}" class="btn btn-primary">Erneut versuchen!</a>
                        <a href="{{ url('/tests/'.$test->id) }}" class="btn btn-secondary">Zurück zur Übersicht</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
