@extends('layouts.app')
@section('content')

{{-- Carousel styling - dark controls and indicators --}}
<style>
.carousel-control-next-icon,
.carousel-control-prev-icon {
  filter: invert(1);
}

.carousel .carousel-indicators li {
  background-color: #fff;
  background-color: rgba(70, 70, 70, 0.25);
}

.carousel .carousel-indicators .active {
  background-color: #444;
}
</style>

{{-- Received: $materials --}}
<div class="container">
     <div class="row">
        <div class="col-md-12">       
                    <div class="card">
                        <div class="card-body">
                            <div class="bd-example">
                              <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                  <ol class="carousel-indicators">
                                  @foreach($materials as $material)
                                    <li data-target="#carouselExampleCaptions" data-slide-to="{{$loop->index}}" class="active"></li>
                                  @endforeach
                                  </ol>
                                <div class="carousel-inner">
                                    @foreach($materials as $material)
                                        @if($loop->first)
                                            <div class="carousel-item active">
                                        @else
                                            <div class="carousel-item">
                                        @endif
                                         @php
                                            //dd('storage'.App\Http\Controllers\MaterialController::path($material->events->name).$material->reference);
                                         @endphp
                                            {{-- Getting image from storage by path and reference --}}
                                            <img src="{{ url('storage'.App\Http\Controllers\MaterialController::path($material->events->name).$material->reference) }}" class="d-block w-100" alt="Not found">    
                                            <div class="carousel-caption d-none d-md-block">
                                              <h5 style="color:black;">{{$material->users->companies->name}}, {{$material->users->companies->country}}</h5>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="sr-only">Next</span>
                                </a>
                              </div>
                            </div>
                        </div>
                        </div>
            </div>
        </div>
</div>                              
                                
                                
                             
@endsection

