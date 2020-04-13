@extends('layouts.main')
@section('title' ,'Account Type')
@section('content')

<div class="container">
 <div class="row" style="display:flex;justify-content:center;padding: 5em;">
  <div class="col-md-10">
        <div class="row">
        <div style="height:150px;">
        <form name="business-type" action="/account-registration" method="POST">
            @csrf
            <div class="form-group">
                    <label for="account_type">{{ __('Account Type') }}</label>
                                <select id="account_type" class=" form-control @error('account_type') is-invalid @enderror" name="account_type" >
                                <?php
                                $array = ["Supplier" , "Buyer" , "Both" ];

                                ?>
                                <option value="">Choose Account Type</option>
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
            <button value="submit" name="submit" id="bstype" style="cursor:pointer;" class="btn btn-primary ">Submit</button>
            </div>
            </form>
        </div>
        </div>
        </div>

        </div>
        </div>
@endsection
