@extends('layouts.app')

@section('title', __('Server Error') . ' — iPhone Store')

@section('content')
<div class="error-container">
    <div class="error-glass">
        <div class="error-code">500</div>
        <div class="error-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h1 class="error-title">{{ __('Server Error') }}</h1>
        <p class="error-message">
            {{ __('Something went wrong on our end. Our team has been notified and is working to fix the issue.') }}
        </p>
        
        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn-home">
                <i class="fa-solid fa-house"></i>
                {{ __('Go to Home Page') }}
            </a>
            <button onclick="window.location.reload()" class="btn-back">
                <i class="fa-solid fa-rotate-right"></i>
                {{ __('Try Again') }}
            </button>
        </div>

        <div class="error-decorations">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .error-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }

    .error-glass {
        position: relative;
        background: var(--bg-card);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 40px;
        padding: 60px 40px;
        max-width: 600px;
        width: 100%;
        text-align: center;
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.2);
        z-index: 10;
        animation: slideUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .error-code {
        font-size: 150px;
        font-weight: 900;
        line-height: 1;
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        opacity: 0.15;
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        pointer-events: none;
        letter-spacing: -10px;
    }

    .error-icon {
        font-size: 80px;
        color: #ff6b6b;
        margin-bottom: 20px;
        animation: shake 2s ease-in-out infinite;
    }

    @keyframes shake {
        0%, 100% { transform: rotate(0); }
        25% { transform: rotate(-5deg); }
        75% { transform: rotate(5deg); }
    }

    .error-title {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 15px;
    }

    .error-message {
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 40px;
        font-size: 18px;
    }

    .error-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-home {
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        color: white;
        padding: 16px 32px;
        border-radius: 16px;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
        box-shadow: 0 10px 25px rgba(255, 107, 107, 0.3);
    }

    .btn-home:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(255, 107, 107, 0.5);
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: var(--text-main);
        padding: 16px 32px;
        border-radius: 16px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: var(--border-color);
    }

    .error-decorations {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
        border-radius: 40px;
    }

    .blob {
        position: absolute;
        width: 300px;
        height: 300px;
        background: #ff6b6b;
        filter: blur(80px);
        opacity: 0.1;
        border-radius: 50%;
    }

    .blob-1 { top: -100px; left: -100px; }
    .blob-2 { bottom: -100px; right: -100px; animation: pulse 6s infinite alternate; }

    @keyframes pulse {
        from { transform: scale(1); opacity: 0.1; }
        to { transform: scale(1.5); opacity: 0.05; }
    }

    @media (max-width: 600px) {
        .error-glass {
            padding: 40px 20px;
        }
        .error-code { font-size: 100px; top: 10px; }
        .error-title { font-size: 24px; }
        .btn-home, .btn-back { width: 100%; justify-content: center; }
    }
</style>
@endpush
