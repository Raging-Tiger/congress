@extends('layouts.app')
@section('content')

{{-- Received: $publics, $private --}}
<div class="container">
    
    {{-- Main picture --}}
    <div class="row">
         <div class="col-md-12">
             <img src="{{ asset('/images/main_pic.jpg') }}" class="img-fluid mx-auto d-block" alt="Medical congress">
         </div>
    </div>
    
    <br>
    
    {{-- Public messages rendering --}}
    @if(!empty($publics) && $publics->count())
        @if(Auth::guest())
            <div class="card-deck">
                
                {{-- Counter for card structure --}}
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
        
    {{-- Public messages pagination --}}
    @if(Auth::guest())
        <br>
        {!! $publics->links() !!}
    @endif  
    
    {{-- Public and private messages rendering --}}
    @if(!empty($privates) && $privates->count())
        @if(!Auth::guest() && !Auth::user()->isBlocked())
            <div class="card-deck">
                
                {{-- Counter for card structure --}}
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
    
    {{-- Private messages pagination --}}
    @if(!Auth::guest() && !Auth::user()->isBlocked())
        <br>
        {!! $privates->links() !!}
    @endif  
    
</div>

@endsection
