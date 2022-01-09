@extends('layouts.app')

@section('content')

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            
                            <label for="RadioGroupUserType" class="col-md-4 col-form-label text-md-right">{{ __('Participation type') }}</label>
                            <div class="col-md-4">
                                 
                                
                                <div id="RadioGroupUserType">
                                    Private participant <input type="radio" name="userType" value="1"  required/>
                                    Commercial participant <input type="radio" name="userType" value="2" />
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-group row desc" id="Type1" style="display: none;">
                            <label for="PersonName" class="col-md-4 col-form-label text-md-right">{{ __('First name') }}</label>

                            <div class="col-md-6">
                                <input id="name1" type="text" class="form-control @error('name') is-invalid @enderror" name="PersonName" maxlength="255" value="{{ old('PersonName') }}">

                                @error('PersonName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                       </div>
                       
                        <div class="form-group row desc" id="Type2" style="display: none;">
                            <label for="PersonSurname" class="col-md-4 col-form-label text-md-right">{{ __('Second name') }}</label>
                            <div class="col-md-6">
                                <input id="name2" type="text" class="form-control @error('name') is-invalid @enderror" name="PersonSurname" maxlength="255" value="{{ old('PersonSurname') }}">

                                @error('PersonSurname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  
                            
                        <div class="form-group row desc" id="Type3" style="display: none;">
                            <label for="Title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input id="name3" type="text" class="form-control @error('name') is-invalid @enderror" name="Title" maxlength="255" value="{{ old('Title') }}">

                                @error('Title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        
                        <div class="form-group row desc" id="Type4" style="display: none;">
                            <label for="CompanyName" class="col-md-4 col-form-label text-md-right">{{ __('Company name') }}</label>

                            <div class="col-md-6">
                                <input id="name4" type="text" class="form-control @error('name') is-invalid @enderror" name="CompanyName" maxlength="255" value="{{ old('CompanyName') }}">

                                @error('CompanyName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row desc" id="Type5" style="display: none;">
                            <label for="CompanyCountry" class="col-md-4 col-form-label text-md-right">{{ __('Company country') }}</label>

                            <div class="col-md-6">
                                <input id="name5" type="text" class="form-control @error('name') is-invalid @enderror" name="CompanyCountry" maxlength="255" value="{{ old('CompanyCountry') }}">

                                @error('CompanyCountry')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
 <script type="text/javascript">
   
    $(document).ready(function() {
    $("input[name$='userType']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
                
        if(test === "1")
        {
           $("#Type" + "1").show();
           $("#Type" + "2").show();
           $("#Type" + "3").show();
           $("#name" + "1").prop('required',true);
           $("#name" + "2").prop('required',true);
           $("#name" + "4").prop('required',false);
           $("#name" + "5").prop('required',false);
           
           
        }
        else
        {
            $("#Type" + "4").show();
            $("#Type" + "5").show();
            $("#name" + "1").prop('required',false);
            $("#name" + "2").prop('required',false);
            $("#name" + "4").prop('required',true);
            $("#name" + "5").prop('required',true);
        }
    });
});
</script>
@endsection
