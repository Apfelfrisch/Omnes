<form method='post' action='/user/{{ $user->id }}/league/{{ $league->id }}'>
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button>Delete</button>
</form
