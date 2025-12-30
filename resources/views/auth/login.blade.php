@extends('layouts.app')

@section('title', 'Login or Register')

@section('content')
 <div class="login-page">
        <div class="login-card">
            <header class="login-header">
                <a href="index.html" class="logo-wb">wb</a>
                <h1 class="login-title">Вход или регистрация</h1>
            </header>

            <form class="login-form" id="loginForm">
                <div class="input-group">
                    <label for="phone">Номер телефона или почта</label>
                    <input type="text" id="phone" class="login-input" placeholder="+7 999 000-00-00" required>
                </div>
                
                <button type="submit" class="login-btn">Получить код</button>

                <div class="login-divider">Или войти через</div>

                <div class="social-btns">
                    <button type="button" class="social-btn">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/mac-os.png" alt="apple">
                        Apple
                    </button>
                    <button type="button" class="social-btn">
                        <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="google" style="filter: none;">
                        Google
                    </button>
                </div>
            </form>

            <footer class="login-footer">
                Продолжая, вы соглашаетесь с <a href="#">правилами пользования</a> и <a href="#">политикой конфиденциальности</a>
            </footer>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        document.getElementById('loginForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Код подтверждения отправлен!');
        });
    </script>
@endsection
