<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | The Entry Pass</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--color-muted) 0%, var(--color-background) 100%);
            padding: var(--spacing-4);
        }
        .login-card {
            background: var(--color-card);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-lg);
            padding: var(--spacing-8);
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            text-align: center;
            margin-bottom: var(--spacing-6);
        }
        .login-logo {
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-2);
            margin-bottom: var(--spacing-4);
        }
        .login-logo-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: var(--radius-xl);
            background: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .login-title {
            font-size: var(--font-size-2xl);
            font-weight: var(--font-weight-bold);
            color: var(--color-foreground);
        }
        .login-subtitle {
            font-size: var(--font-size-sm);
            color: var(--color-muted-foreground);
            margin-top: var(--spacing-1);
        }
        .form-field {
            margin-bottom: var(--spacing-4);
        }
        .form-field label {
            display: block;
            font-size: var(--font-size-xs);
            font-weight: var(--font-weight-semibold);
            color: var(--color-muted-foreground);
            margin-bottom: var(--spacing-2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .form-field input {
            width: 100%;
            padding: var(--spacing-3);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            font-size: var(--font-size-sm);
            background: var(--color-background);
            transition: all var(--transition-fast);
        }
        .form-field input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px var(--color-primary-light);
        }
        .btn-login {
            width: 100%;
            padding: var(--spacing-3);
            background: var(--color-primary);
            color: var(--color-primary-foreground);
            border: none;
            border-radius: var(--radius-xl);
            font-size: var(--font-size-sm);
            font-weight: var(--font-weight-semibold);
            cursor: pointer;
            transition: all var(--transition-normal);
            margin-top: var(--spacing-2);
        }
        .btn-login:hover {
            background: #0284c7;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }
        .alert {
            padding: var(--spacing-3);
            border-radius: var(--radius-lg);
            margin-bottom: var(--spacing-4);
            font-size: var(--font-size-sm);
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
        }
        .alert-error {
            background: var(--color-error-bg);
            color: var(--color-error);
            border: 1px solid var(--color-error-border);
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: var(--spacing-6);
            font-size: var(--font-size-sm);
            color: var(--color-muted-foreground);
            transition: color var(--transition-fast);
        }
        .back-link:hover {
            color: var(--color-primary);
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <div class="login-logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>
                    </div>
                    <span class="login-title">The Entry Pass</span>
                </div>
                <p class="login-subtitle">Admin Access</p>
            </div>

            @if(session('error'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="form-field">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="admin@theentrypass.com">
                </div>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn-login">Sign In to Admin</button>
            </form>

            <a href="{{ route('homepage') }}" class="back-link">← Return to Website</a>
        </div>
    </div>
</body>
</html>