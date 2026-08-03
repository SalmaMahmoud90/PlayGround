<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - PlayGround</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            padding: 48px;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.8);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .logo-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
            box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.4);
        }
        
        .logo h1 {
            color: white;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -0.5px;
            margin: 0;
        }
        
        .logo p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            margin: 4px 0 0;
            font-weight: 400;
        }
        
        .form-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }
        
        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            color: white;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .form-input:focus {
            border-color: #10b981;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        }
        
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
        
        .form-input.error {
            border-color: #ef4444;
        }
        
        .input-icon-wrapper {
            position: relative;
        }
        
        .input-icon-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            font-size: 16px;
        }
        
        .input-icon-wrapper .form-input {
            padding-left: 48px;
        }
        
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #10b981;
            border-radius: 6px;
            cursor: pointer;
        }
        
        .checkbox-wrapper label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            cursor: pointer;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.4);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -10px rgba(16, 185, 129, 0.5);
        }
        
        .btn-login:active {
            transform: scale(0.98);
        }
        
        .links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .links a {
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .links a:hover {
            color: #10b981;
        }
        
        .register-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }
        
        .register-link p {
            color: rgba(255, 255, 255, 0.4);
            font-size: 14px;
            margin: 0;
        }
        
        .register-link a {
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .register-link a:hover {
            color: #34d399;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .error-message i {
            font-size: 14px;
        }
        
        .bg-circle {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            pointer-events: none;
        }
        
        .bg-circle-1 {
            width: 400px;
            height: 400px;
            background: #10b981;
            top: -100px;
            right: -100px;
        }
        
        .bg-circle-2 {
            width: 300px;
            height: 300px;
            background: #3b82f6;
            bottom: -50px;
            left: -50px;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>

    <div class="login-container">
        <div class="logo">
            <div class="logo-icon">⚽</div>
            <h1>PlayGround</h1>
            <p>Book your playground instantly</p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope mr-2" style="color: rgba(255,255,255,0.3);"></i>
                    Email Address
                </label>
                <div class="input-icon-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input @error('email') error @enderror"
                        placeholder="you@example.com"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="fas fa-lock mr-2" style="color: rgba(255,255,255,0.3);"></i>
                    Password
                </label>
                <div class="input-icon-wrapper">
                    <i class="fas fa-lock"></i>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input @error('password') error @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    />
                </div>
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="checkbox-wrapper">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                    />
                    <label for="remember_me">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        <i class="fas fa-key mr-1" style="font-size: 12px;"></i>
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign In
            </button>
        </form>

        <div class="register-link">
            <p>
                Don't have an account?
                <a href="{{ route('register') }}">Create one</a>
            </p>
        </div>
    </div>
</body>
</html>