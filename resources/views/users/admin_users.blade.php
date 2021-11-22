@extends('layouts.app')
@section('content')
<script type="application/javascript">
$(document).ready(function () {
    $("#search").keyup(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.post("/users", { search: $('#search').val(), _token: CSRF_TOKEN }, function(data) {
            $('.spec').html('');
            $.each(data, function(i, spec) {
                var c = '<p>' + spec.email + '<\p>';
                 $('.spec').append(c);
            });
        });
    })
});
</script>

<div class="container">
    <div>
        {{ Form::open() }}    
            {{ Form::text('search', '', ['class' => 'form-control', 'id' => 'search'])}} 
        {{ Form::close() }}
    </div>
    <div class="spec"></div>
    <div>           
        <table class="table">
            <tr>
                <th>User ID</th>
                <th>E-mail</th>
                <th>Full name</th>
                <th>Company</th>
                <th>Role</th>
                <th>Edit</th>
            </tr>
            @foreach($users as $user)
            <tr>
                <th>{{$user->id}}</th>
                <th>{{$user->email}}</th>
                <th>{{$user->fullNames->title ?? ''}} {{$user->fullNames->name ?? '-'}} {{$user->fullNames->surname ?? ''}}</th>
                <th>{{$user->companies->name ?? '-'}}</th>
                <th>{{$user->roles->name}}</th>
                <th> 
                    {{ Form::open(['action' => ['App\Http\Controllers\UserController@edit', $user->id]]) }}
                        {{ Form::submit(('Edit'), ['class' => 'btn btn-primary'])}}
                    {{ Form::close() }}
                </th>
            </tr>
            
            
            
            @endforeach
        </table>
        
        {!!$users->links()!!}
    </div>
</div>
@endsection

