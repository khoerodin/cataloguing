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
                <input id="username" type="text" class="normalcase" name="username" placeholder="Username or Email" value="{{ old('username') }}" required autofocus>
                <input type="password" name="password" placeholder="Password" class="normalcase">
                <button class="btn btn-primary btn-block login" type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection