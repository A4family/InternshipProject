@extends('backend.layouts.login-template')

@section('content')
<div class="form-place">
    <span class="login-dashboard-text">Forgot Password</span>
    <form action={{ route('admin.forgot.password') }} method="POST" autocomplete="off">
        @csrf
        <label for="email">Email</label><br>
        <input type="text" name="email" id="" placeholder="Enter Email">
        <br>
        <input type="submit" value="Send Reset Link">
    </form>
    <span class="error-message">
    @if(session('message'))
        {{ session('message') }}
    @endif

    @if($errors->any())
        @foreach ($errors->all() as $error)
            {{ $error}} <br>
        @endforeach                    
    @endif
    </span>

</div>
@endsection