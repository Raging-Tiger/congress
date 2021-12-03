@extends('layouts.app')
@section('content')
<div class="container">
    
   <div div class="row">
        <table class="table table-responsive-sm table-bordered">
            <tr>
                <td style="width: 150px;"> <b>{{__('user_messages.article_title')}}</b> </td>
                <td>{{$article->title}}</td>
            </tr>
            <tr>
                <td style="width: 150px;"> <b>{{__('user_messages.abstract')}}</b> </td>
                <td>{{$article->abstract}}
                </td>
            </tr>
        </table>
   </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="list-group-item list-group-item bg-primary text-white">{{__('user_messages.edit_status')}}</h4>
                <div class="card-body">
                    {{ Form::open(['action' => ['App\Http\Controllers\ReviewController@update', $article->id], 'onsubmit' => 'return ConfirmChange()']) }}
                    <div class="form-group">
                        
                             {{ Form::label('status', 'Article status', ['class' => 'control-label']) }}
                                {{ Form::select('status', $statuses , $article->articleStatuses->id)}}
                                @if ($errors->has('status'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('status') }}
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
<script type="application/javascript"> 
function ConfirmChange() {
    var acceptance = <?php echo json_encode(trans('user_messages.edit_article_status_warning'))?>;
    
    var confirmation = confirm(acceptance);
    if(confirmation === true)
    {
        return true;
    }
    else
    {
        return false;
    }
    
}
</script>
@endsection



