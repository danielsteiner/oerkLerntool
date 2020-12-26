@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Menü</div>
                <div class="card-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/admin/users') }}">User anzeigen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/statistik') }}">Statistik anzeigen</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administration</div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
