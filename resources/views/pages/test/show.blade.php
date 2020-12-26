@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $test->title }}</div>
                <div class="card-body">
                    <p>
                        Diese Lernkartei beinhält die Fragen aus folgenden Kategorien:<br>
                        <small>
                        @foreach($test->categories as $category)
                            {{ $category->title }}@unless($loop->last), @endunless
                        @endforeach
                        </small>
                    </p>
                    <h4>Druckansicht aller Fragen</h4>
                    <a href="{{url('/export/tests/3')}}">Ohne Antworten</a> &middot; <a href="{{url('/export/tests/3/true')}}">Mit Antworten</a>
                    <h4>Lernkartei</h4>
                    <p>Die Lernkartei bietet dir ein Tool, mit dem du die Fragen der jeweiligen Kategorie schnell und einfach lernen kannst.</p>
                    <p>Bei der Lernkartei, bekommst du jeweils eine Frage angezeigt. Wenn du sie richtig beantwortest, wird sie in das nächste Level geschoben. Wenn du sie falsch beantwortest, wird sie in das vorherige Level geschoben. So soll erreicht werden, dass Fragen, die falsch beantwortet wurden öfters geübt werden.</p>
                    <p>Erfahrungsgemäß ist man ziemlich gut vorbereitet, wenn man alle Fragen in Level 4 gebracht hat.</p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Fragen in diesem Level</th>
                                    <th>Verbleibende Fragen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($levels as $levelNumber => $level)
                                    <tr>
                                        <td> <a href="{{ url('/lernkartei/'.$test->id.'/level/'.$levelNumber) }}">{{ $levelNumber }}</a></td>
                                        <td> {{ array_key_exists("questions", $level) ? count($level["questions"]) : 0 }} </td>
                                        <td> {{ array_key_exists("questions", $level) ? $test->questionCount - count($level["questions"]) : $test->questionCount}} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @if(count($attempts) > 0)
                        <h4>Bisherige Prüfungssimulationen</h4>
                        <div class="mt-3 mb-3">
                            <a href="{{ url('/tests/'.$test->id.'/simulation') }}">Neue Prüfungssimulation starten</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Versuch vom</th>
                                    <th>Erreichte Punkte</th>
                                    <th>Auswertung anzeigen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attempts as $attempt)
                                    <tr>
                                        <td> {{ $attempt->created_at->format('d.m.Y H:i') }} </td>
                                        <td> {{ $attempt->reachedPoints }} / 30</td>
                                        <td>
                                        <a href="{{ url('/tests/'.$test->id.'/simulation/'.$attempt->id) }}">Zum Ergebnis</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h4>Du hast bisher noch keine Prüfungssimulation gestartet</h4>
                    @endif
                    <div class="mt-3 mb-3">
                        <a href="{{ url('/tests/'.$test->id.'/simulation') }}">Neue Prüfungssimulation starten</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
