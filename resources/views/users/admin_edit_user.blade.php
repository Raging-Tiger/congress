@extends('layouts.app')
@section('content')
<div class="container">          
    <div div class="row">
        <table class="table table-responsive-sm table-bordered">
            <tr>
                <td> {{__('admin_messages.user_id')}} </td>
                <td>{{$user->id}}</td>
            </tr>
            <tr>
                <td> {{__('admin_messages.login')}} </td>
                <td>{{$user->name}}</td>
            </tr>
            <tr>
                <td> {{__('admin_messages.email')}} </td>
                <td>{{$user->email}}

                </td>
            </tr>

            <tr>
                <td> {{__('admin_messages.company')}} </td>
                <td>{{$user->fullNames->title ?? ''}} {{$user->fullNames->name ?? ''}} {{$user->fullNames->surname ?? ''}}
                    {{$user->companies->name ?? ''}}</td>
            </tr>

            <tr>
                <td> {{__('admin_messages.role')}} </td>
                <td>{{$user->roles->name}}
                </td>
            </tr>

            <tr>
                <td> {{__('admin_messages.articles')}} </td>
                <td>{{count($user->articles)}}
                </td>
            </tr>


        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item bg-primary text-white">{{__('admin_messages.edit_user_role')}}</h4>
                <div class="card-body">
                    {{ Form::open(['action' => ['App\Http\Controllers\UserController@update', $user->id]]) }}
                    <div class="form-group">
                        
                             {{ Form::label('role', 'User role', ['class' => 'control-label']) }}
                                {{ Form::select('role', $roles , $user->roles->id)}}
                                @if ($errors->has('role'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('role') }}
                                    </div>
                                @endif
                    </div>
                        {{ Form::submit(('Save changes'), ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

