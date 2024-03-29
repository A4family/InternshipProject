@extends('userend.layouts.login-form-template')

@section('page-title')
    Login
@endsection

@section('content')
<div class="container">
  <input type="checkbox" id="flip">
  <div class="cover">
    <div class="front">
      <img src="{{ URL('images/holding-phone.jpg') }}" alt="">
      <div class="text">
        <span class="text-1">Every new friend is a <br> new adventure</span>
        <span class="text-2">Let's get connected</span>
      </div>
    </div>
    <div class="back">
      <img class="backImg" src="{{ URL('images/holding-phone.jpg') }}" alt="">
      <div class="text">
        <span class="text-1">Complete miles of journey <br> with one step</span>
        <span class="text-2">Let's get started</span>
      </div>
    </div>
  </div>
  <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Login</div>
        <form action="{{ route('user.validate') }}" method="POST" autocomplete="off">
          @csrf
          <div class="input-boxes">
            <div class="input-box">
              <i class="fas fa-envelope"></i>
              <input type="text" name="username" placeholder="Enter your username">
            </div>
            <div class="input-box">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Enter your password">
            </div>
            <div class="text"><a href="{{ route('user-forgot-password-view') }}">Forgot password?</a></div>
            <div class="button input-box">
              <input type="submit" value="Sumbit">
            </div>
            <div class="text sign-up-text">Don't have an account? <label for="flip">Sigup now</label></div>
            <div>
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
          </div>
      </form>
    </div>
      <div class="signup-form">
        <div class="title">Signup</div>
      <form action="{{ route('user.register') }}" method="POST" autocomplete="off">
          @csrf
          <div class="input-boxes">
            <div class="input-box">
              <i class="fas fa-user"></i>
              <input type="text" name="name" placeholder="Enter your name">
            </div>
            <div class="input-box">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Enter your username">
            </div>
            <div class="input-box">
              <i class="fas fa-envelope"></i>
              <input type="text" name="email" placeholder="Enter your email">
            </div>
            <div class="input-box">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Enter your password">
            </div>
            <div class="input-box">
              <i class="fas fa-lock"></i>
              <input type="password" name="confirm_password" placeholder="Confirm your password">
            </div>
            <div class="button input-box">
              <input type="submit" value="Sumbit">
            </div>
            <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
            <div>
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
          </div>
    </form>
  </div>
  </div>
  </div>
</div>
@endsection