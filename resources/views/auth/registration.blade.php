@extends('layouts.app')

@section('content')
<style type="text/css" nonce="{{ csp_nonce() }}">
    a.account-type{text-decoration: underline;background: #fff68a;text-decoration: underline; }
</style>
<div class="container"> 

    <div class="row" id="register">
        <div class="col-md-8">
            <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <label for="Account type">Account Type</label>
                        <p>{{ Session::get('account_type') }} <span><a class="account-type" href="/account-type" >change</a></span></p>
                        </div> 
            </div>
            <div>
                <div>
                    <form method="POST" action="/register" id="registration_form">
                        @csrf
                        <div class="row form-group">
                                <div class="col-md-6">
                                <label for="Province">Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-md-6">
                                        <label for="Province">Lastname</label>
                                        <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" autocomplete="lastname" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                        </div>
                        <div class="row form-group">
                                <div class="col-md-6">
                                <label for="country">Country</label>
                                <select id="country" name="country"  class="form-control">
                                        @if($countries->first()->cn_name != 'South Africa')
                                        <option selected disabled>Select</option>
                                        @endif
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->cn_name }}">{{ $country->cn_name }}</option>
                                        @endforeach
                                    </select>
                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                </div>

                        </div>

                        <div class="row form-group">
                                <div class="col-md-6">
                                <label for="email">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                        </div>
                        <div class="row form-group">
                                <div class="col-md-6">
                                <label for="company_name">Company Name</label>
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" autocomplete="company_name">

                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                        </div>
                        <div class="row form-group">

                            <div class="col-md-6">
                            <h5> Please select atleast one industry you intrested in or cover</h5>
                            <label for="industry">Industry</label>
                            <?php
                            $industries = ["Agricultural Products" , "Coal" , "Steel", "Minerals" , "Industrial Products" , "Machinery", "Consumer Goods" , "Food" ];

                            ?>
                        @foreach ($industries as $industry )
                        <div>
                            <input class="industry" type="checkbox"   name="industry[]" value="{{  $industry }}"  />  {{  $industry }}
                        </div>
                        @endforeach
                        @error('industry')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                            </div>

                    </div>

                        <div class="row form-group">
                          <div class="col-md-6">
                            <label for="phone_number">Business Phone Number</label>
                                <div class="input-group">
                                <div class="input-group-addon">
                                  +27
                                </div>
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="off" >
                
                                </div>
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                         </div>

                            <div class="row form-group">
                                <div class="col-md-6">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                        </div>
                        <div class="row form-group">
                                <div class="col-md-6">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">

                                </div>
                        </div>

                        <div class="row form-group">
                                <div class="col-md-6">
                                <label for="checkbox-terms"></label>
                                <input type="checkbox" id="check" name="check"> I agree to the <a href="#">terms</a>
                            <div>
                                 @error('check')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                                </div>
                        </div>
                    </div>
                        <div class="form-group row">
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


@endsection
