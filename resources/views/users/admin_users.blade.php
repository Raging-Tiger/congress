@extends('layouts.app')
@section('content')
<script type="application/javascript">
$(document).ready(function () {
    $("#search").keyup(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.post("/users", { search: $('#search').val(), _token: CSRF_TOKEN }, function(data) {
            
            $('.spec').empty();
            $.each(data, function(i, spec) {
                
                var c = '<tr><td>' + spec.id + 
                        '</td><td>' + spec.email +  
                        '</td><td>' + spec.name + ' '+ spec.surname +  
                        '</td><td>' + spec.companyName +  
                        '</td><td>' + spec.roleName +  
                        '</td></tr>';
                 $('.spec').append(c);
            });
        });
    })
});
</script>

<div class="container">
    <div>
        {{ Form::open(['onsubmit' => 'return false;']) }}    
            {{ Form::text('search', '', ['class' => 'form-control', 'id' => 'search'])}} 
        {{ Form::close() }}
    </div>

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
            <tbody class="spec">
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->fullNames->title ?? ''}} {{$user->fullNames->name ?? '-'}} {{$user->fullNames->surname ?? ''}}</td>
                    <td>{{$user->companies->name ?? '-'}}</td>
                    <td>{{$user->roles->name}}</td>
                    <td> 
                        {{ Form::open(['action' => ['App\Http\Controllers\UserController@edit', $user->id]]) }}
                            {{ Form::submit(('Edit'), ['class' => 'btn btn-primary'])}}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            
            
            
        </table>
        
        {!!$users->links()!!}
    </div>
</div>
@endsection

