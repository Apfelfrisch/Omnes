@extends('layouts.app')

@section('content')
    <ul class="nav nav-tabs">
    @foreach($leagues as $league)
        <li><a data-toggle="tab" href="#{{ $league->id }}">{{ $league->name }}</a></li>
    @endforeach
    </ul>
    <div class="tab-content">
        @foreach($leagues as $league)
        <div id="{{ $league->id }}" class="tab-pane fade in active">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gruppe</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($league->users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roleFor($league) ? $user->roleFor($league)->name : '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
@endsection
