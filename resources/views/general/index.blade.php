@extends('layouts.app')

@section('content')

<div class="container">
 
    @if(!empty($publics) && $publics->count())
        @if(Auth::guest())
            <div class="card-deck">
                @php 
                
                    $counter = 0; 
                
                @endphp
                
                @foreach($publics as $public)
                    @php 
                    
                        $counter++; 
                    
                    @endphp
                    
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <b>{{$public->header}}</b>
                            </h5>
                            <p class="card-text">
                                {!! nl2br(e($public->message)) !!}
                            </p>
                        </div>
                        <div class="card-footer">
                          <small class="text-muted">
                              Date: {{$public->created_at}} 
                              Author: {{$public->users->name}}
                          </small>
                        </div>
                    </div>
                    
                    @if($counter == 3)
                        
                        </div> <br> 
                        
                        <div class="card-deck">
                            @php 
                            
                                $counter=0; 
                            
                            @endphp
                    @endif
                @endforeach
                        </div>
        @endif

    @endif
        

    @if(Auth::guest())
        <br>
        {!! $publics->links() !!}
    @endif  
    
    @if(!empty($privates) && $privates->count())
        @if(!Auth::guest() && !Auth::user()->isBlocked())
            <div class="card-deck">
                @php 
                
                    $counter_private = 0; 
                
                @endphp
                
                @foreach($privates as $private)
                    @php 
                    
                        $counter_private++; 
                    
                    @endphp
                    
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <b>{{$private->header}}</b>
                            </h5>
                            <p class="card-text">
                                {!! nl2br(e($private->message)) !!}
                            </p>
                        </div>
                        <div class="card-footer">
                          <small class="text-muted">
                              Date: {{$private->created_at}} 
                              Author: {{$private->users->name}}
                          </small>
                        </div>
                    </div>
                    
                    @if($counter_private == 3)
                        
                        </div> <br> 
                        
                        <div class="card-deck">
                            @php 
                            
                                $counter_private=0; 
                            
                            @endphp
                    @endif
                @endforeach
                        </div>
        @endif

    @endif
    
    @if(!Auth::guest() && !Auth::user()->isBlocked())
        <br>
        {!! $publics->links() !!}
    @endif  
    
</div>

@endsection
