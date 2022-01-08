@extends('layouts.app')
@section('content')
<script type="application/javascript">
// AJAX user search
$(document).ready(function () {
    $("#search").keyup(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.post("/users", { search: $('#search').val(), _token: CSRF_TOKEN }, function(data) {
            
            $('.spec').empty();
            $.each(data, function(i, spec) {
                var CSRF_TOKEN_inp = $('meta[name="csrf-token"]').attr('content');
                var full_name = '';
                var company_name = spec.companyName;
                
                if(spec.name == null)
                {
                    full_name = '-';
                }
                else
                {
                    full_name = spec.name + ' ' + spec.surname;
                }
                if(company_name == null)
                {
                    company_name = '-';
                }
                
                //Create HTML table row filled with necessary data
                var row_content = '<tr><td>'  + spec.id + 
                                  '</td><td>' + spec.login +
                                  '</td><td>' + spec.email +
                                  '</td><td>' + full_name +  
                                  '</td><td>' + company_name +  
                                  '</td><td>' + spec.roleName + 
                                  '</td><td>' + '<form method="POST" action="http://medcongress.test/users/'+ spec.id +
                                  '" accept-charset="UTF-8">'+
                                  '<input name= "_token" type="hidden" value="'+ CSRF_TOKEN_inp +
                                  '"><input class= "btn btn-primary" type="submit" value="Edit"></form>' +
                                  '</td></tr>';
                 $('.spec').append(row_content);
            });
        });
    })
});
</script>

{{-- Received: $users, AJAX search query --}}
{{-- Pass: search --}}
<div class="container">
    
    {{-- AJAX seach form, submit disabled --}}
    <div>
        {{ Form::label('search', __('admin_messages.search'), ['class' => 'control-label']) }}
        {{ Form::open(['onsubmit' => 'return false;']) }}    
            {{ Form::text('search', '', ['id' => 'search'])}} 
        {{ Form::close() }}
    </div>
        <br>
    <div>           
        <table class="table">
            <tr>
                <th>{{__('admin_messages.user_id')}}</th>
                <th>{{__('admin_messages.login')}}</th>
                <th>{{__('admin_messages.email')}}</th>
                <th>{{__('admin_messages.full_name')}}</th>
                <th>{{__('admin_messages.company')}}</th>
                <th>{{__('admin_messages.role')}}</th>
                <th>{{__('admin_messages.edit')}}</th>
            </tr>
            <tbody class="spec">
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->fullNames->title ?? ''}} {{$user->fullNames->name ?? '-'}} {{$user->fullNames->surname ?? ''}}</td>
                    <td>{{$user->companies->name ?? '-'}}</td>
                    <td>{{$user->roles->name}}</td>
                    
                    {{-- Edit user role --}}
                    <td> 
                        {{ Form::open(['action' => ['App\Http\Controllers\UserController@edit', $user->id]]) }}
                            {{ Form::submit((__('admin_messages.edit')), ['class' => 'btn btn-primary'])}}
                        {{ Form::close() }}
                    </td>
                </tr>
                @endforeach
            </tbody>
           
        </table>
        
        {{-- Pagination --}}
        {!!$users->links()!!}
    </div>
</div>
@endsection

