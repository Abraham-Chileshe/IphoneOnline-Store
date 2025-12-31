@extends('layouts.app')

@section('title', 'Login or Register')

@section('content')
 <div class="login-page">
        <div class="login-card">
            <header class="login-header">
                <a href="index.html" class="logo-wb">wb</a>
                <h1 class="login-title">Login or Register</h1>
            </header>

            <form class="login-form" id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="login">Email or Phone</label>
                    <input type="text" name="login" id="login" class="login-input" placeholder="example@mail.com or +260..." required value="{{ old('login') }}">
                    @error('login')
                        <span class="error-message" style="color: #ff3b30; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="login-input" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="login-btn">Login</button>

                <div class="login-divider">Or</div>

                <div class="register-link-container" style="text-align: center;">
                    <a href="{{ route('register') }}" class="social-btn" style="width: 100%; text-decoration: none;">
                        Create Account
                    </a>
                </div>
            </form>

            <footer class="login-footer">
                By continuing, you agree to the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>
            </footer>
        </div>
    </div>

@endsection
