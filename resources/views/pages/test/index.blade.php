@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Verfügbare Lernkarteien</div>
                <div class="card-body">
                    <p>In dieser Liste findest du alle derzeit verfügbaren Lernkarteien und siehst, welche Kategorien Enthalten sind.</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titel</th>
                                <th>Fragen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tests as $test)
                                <tr>
                                    <td> {{ $test->id }} </td>
                                    <td>
                                        <a href="{{ url('/tests/'.$test->id) }}">{{ $test->title }}</a><br>
                                        <small>
                                            @foreach($test->categories as $category)
                                                {{ $category->title }}@unless($loop->last), @endunless
                                            @endforeach
                                        </small>
                                    </td>
                                    <td>{{ $test->questionCount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
