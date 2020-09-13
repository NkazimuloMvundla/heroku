@extends('layouts.main')
@section('title' ,'Account Type')
@section('meta_keywords', 'account type')
@section('meta_description', 'choose an account type')
<link rel="canonical" href="{{url()->current()}}"/>
@section('content')
<style nonce="{{ csp_nonce() }}">
div.container > div.row{display:flex;
justify-content:center;
padding: 5em;}

div#beforeForm{height:150px;}
button#bstype{cursor:pointer}
</style>
<div class="container">
 <div class="row">
  <div class="col-md-10">
        <div class="row">
        <div  id="beforeForm">
        <form name="business-type" action="/account-registration" method="POST">
            @csrf
            <div class="form-group">
                    <label for="account_type">{{ __('Account Type') }}</label>
                                <select id="account_type" class=" form-control @error('account_type') is-invalid @enderror" name="account_type" >
                                <?php
                                $array = ["Supplier" , "Buyer" , "Both" ];

                                ?>
                                <option>Choose Account Type</option>
                                @foreach($array as $role)
                                <option value="{{$role}}" {{ old('account_type') ? 'selected' : '' }} >{{$role}}</option>
                                @endforeach
                                </select>

                                @error('account_type')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                </div>
            <div class="form-group" >
            <button value="submit" name="submit" id="bstype"  class="btn btn-primary ">Submit</button>
            </div>
            </form>
        </div>
        </div>
        </div>

        </div>
        </div>
@endsection
