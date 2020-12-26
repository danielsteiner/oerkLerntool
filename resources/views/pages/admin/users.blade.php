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
                <div class="card-header">User</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Typ</th>
                                <th>Aktionen</th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td><a href="{{ url('/admin/user/'.$user->id) }}">{{ $user->name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td>@canImpersonate
                                            <a href="{{ route('impersonate', $user->id) }}">Impersonate</a>
                                        @endCanImpersonate
                                    </td>
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
