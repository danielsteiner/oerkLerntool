@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Fragenkatalog</div>
                <div class="card-body">
                    @foreach ($questions as $q)
                        <div>
                            <header>
                                <h3>Frage {{ $q->id }}</h3>
                                <h4>{{ $q->question }}</h4>
                                <small>{{ $q->category->title }}</small>
                            </header>
                            <form>
                                <input type="hidden" name="question_id" value="{{ $q->id }}" />
                                @foreach($q->answers as $id => $answer)
                                    <!-- {{dd($answer)}} -->
                                    <!-- <input type="check" name="answer" value="{{ $id }}">{{ $answer->text }} -->
                                @endforeach
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
