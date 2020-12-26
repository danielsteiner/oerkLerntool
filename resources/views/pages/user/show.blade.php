@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <img src="{{ $user->avatar_url }}" class="col-md-2"/>
                        <div class="col-md-10">
                            <h3>{{ $user->name }}</h3>
                            <p>{{ count($tests_taken) }} absolvierte Tests</p>
                            <p>{{ count($passed_tests) }} bestandene Tests</p>
                        </div>
                    </div>
                    <hr>
                    <h3>Errungenschaften</h3>
                    @foreach($user->achievements as $achievement)
                        @include('components.achievement', $achievement)
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
