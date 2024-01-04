@extends('backend.layouts.login-template')

@section('content')
<div class="form-place">
    <span class="login-dashboard-text">Reset Password</span>
    <form action={{ route('admin.new.password') }} method="POST" autocomplete="off">
        @csrf
        <label for="new-password">New Password</label><br>
        <input type="password" name="new-password" id="" placeholder="Enter New Password">
        <br>
        <label for="confirm-password">Confirm Password</label><br>
        <input type="password" name="confirm-password" id="" placeholder="Confirm New Password">

        <input type="hidden" name="token" value="{{ $token }}">
        
        <input type="submit" value="Confirm Password">

        
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