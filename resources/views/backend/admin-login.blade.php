@extends('backend.layouts.login-template')

@section('content')
            <div class="form-place">
                <span class="login-dashboard-text">Login to Dashboard</span>
                <form action="/admin-validate" method="POST" autocomplete="off">
                    @csrf
                    <label for="username">Username</label><br>
                    <input type="text" name="username" id="" placeholder="Enter Username">
                    <br>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="" placeholder="Enter Password"><br>
                    <input type="submit" value="Login">
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('forgot-password').submit();">
                    <span class="forgot-password">Forgot Password?</span>
                </a>

                <form id="forgot-password" action="{{ route('forgot-password-view') }}" method="GET" style="display: none;">
                    @csrf
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


