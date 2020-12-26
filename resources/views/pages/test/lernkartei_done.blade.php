@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $test->title }}</div>
                <div class="card-body">
                    <p>Glückwunsch, du hast alle Fragen aus diesem Level beantwortet. In der Übersicht siehst du deinen Fortschritt.</p>
                    <a href="{{ url('/tests/'.$test->id) }}">Zurück zur Übersicht</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
