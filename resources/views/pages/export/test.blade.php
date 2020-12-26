@extends('layouts.export')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>{{ $data["name"] }}</h1>
            <p>Dieser Export beinhält {{ $data["questionCount"] }} Fragen aus folgenden Kategorien:<br><small>@foreach($data["categories"] as $category) {{$category["name"]}}@if(!$loop->last), @endif @endforeach</small></p>
            @foreach($data["categories"] as $category)
                @foreach($category["questions"] as $question)
                    @if($prechecked)
                        @include('components.precheckedexport', ["question"=>$question, "category" => $category["name"]])
                    @else
                        @include('components.questionexport', ["question"=>$question, "category" => $category["name"]])
                    @endif
                @endforeach
            @endforeach
        </div>
        <div class="footer">Zeitpunkt des Fragenexports: {{ $data["time"] }}</div>
    </div>
</div>
@endsection
