@extends('layouts.app')

@section('title', 'Register')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<style>
    .register-card {
        max-width: 600px;
    }
    .grid-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .full-width {
        grid-column: span 2;
    }
    @media (max-width: 600px) {
        .grid-form {
            grid-template-columns: 1fr;
        }
        .full-width {
            grid-column: span 1;
        }
    }
</style>
@endpush

@section('content')
<div class="login-page">
    <div class="login-card register-card">
        <header class="login-header">
            <a href="{{ route('home') }}" class="logo-wb">ab</a>
            <h1 class="login-title">{{ __('Registration') }}</h1>
        </header>

        <form class="login-form" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="grid-form">
                <div class="input-group full-width">
                    <label for="name">{{ __('Full Name') }}</label>
                    <input type="text" name="name" id="name" class="login-input" placeholder="John Doe" required value="{{ old('name') }}">
                    @error('name') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input type="email" name="email" id="email" class="login-input" placeholder="example@mail.com" required value="{{ old('email') }}">
                    @error('email') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="phone">{{ __('Phone Number') }}</label>
                    <input type="text" name="phone" id="phone" class="login-input" placeholder="+260..." required value="{{ old('phone') }}">
                    @error('phone') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password" class="login-input" placeholder="••••••••" required>
                    @error('password') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="login-input" placeholder="••••••••" required>
                </div>

                <div class="input-group full-width">
                    <label for="address">{{ __('Shipping Address') }}</label>
                    <input type="text" name="address" id="address" class="login-input" placeholder="{{ __('Street, House, Apartment') }}" required value="{{ old('address') }}">
                    @error('address') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="city">{{ __('City') }}</label>
                    <input type="text" name="city" id="city" class="login-input" placeholder="Lusaka" required value="{{ old('city') }}">
                    @error('city') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="postal_code">{{ __('Postal Code') }}</label>
                    <input type="text" name="postal_code" id="postal_code" class="login-input" placeholder="10101" required value="{{ old('postal_code') }}">
                    @error('postal_code') <span style="color: #ff3b30; font-size: 12px;">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <button type="submit" class="login-btn">{{ __('Register') }}</button>

            <div class="login-divider">{{ __('Or') }}</div>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="social-btn" style="width: 100%; text-decoration: none;">
                    {{ __('Already have an account? Login') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
