@extends('layouts.app')

@section('styles')
<link href="css/login.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="login-container">
        <div id="output">            
            @if ($errors->has('email'))
                <p class="text-center text-danger">{{ $errors->first('email') }}</p>
            @endif

            @if ($errors->has('password'))
                <p class="text-center text-danger">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <div class="avatar"></div>
        <div class="form-box">
            <form method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                <input name="email" type="email" placeholder="Email" class="normalcase" value="{{ old('email') }}">
                <input type="password" name="password" placeholder="Password" class="normalcase">
                <button class="btn btn-primary btn-block login" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection