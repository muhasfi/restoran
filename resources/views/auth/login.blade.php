<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — {{ config('app.name', 'Application') }}</title>

    {{-- Mazer / Bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* ── Root tokens (light) ────────────────────────────── */
        :root {
            --auth-bg:          #f5f5f5;
            --card-bg:          #ffffff;
            --card-border:      #e4e6ea;
            --input-bg:         #f8f9fa;
            --input-border:     #dee2e6;
            --input-focus-bg:   #ffffff;
            --text-primary:     #1a1d23;
            --text-secondary:   #6c757d;
            --text-muted:       #adb5bd;
            --brand:            #435ebe;
            --brand-hover:      #3451b2;
            --brand-soft:       #eef1fb;
            --shadow-card:      0 4px 24px rgba(67, 94, 190, .08), 0 1px 4px rgba(0,0,0,.04);
            --shadow-btn:       0 4px 12px rgba(67, 94, 190, .35);
            --radius-card:      16px;
            --radius-input:     10px;
            --transition:       .2s ease;
        }

        /* ── Root tokens (dark) ─────────────────────────────── */
        [data-bs-theme="dark"] {
            --auth-bg:          #1a1d23;
            --card-bg:          #25293c;
            --card-border:      #2f3349;
            --input-bg:         #1e2235;
            --input-border:     #3a3f5c;
            --input-focus-bg:   #252942;
            --text-primary:     #e8eaf0;
            --text-secondary:   #9ea5c0;
            --text-muted:       #5c6282;
            --brand:            #5a7af0;
            --brand-hover:      #435ebe;
            --brand-soft:       rgba(90,122,240,.12);
            --shadow-card:      0 4px 32px rgba(0,0,0,.35);
            --shadow-btn:       0 4px 14px rgba(90,122,240,.4);
        }

        /* ── Base ───────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            background-color: var(--auth-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', 'Segoe UI', sans-serif;
            color: var(--text-primary);
            padding: 1rem;
            transition: background-color var(--transition), color var(--transition);
        }

        /* ── Theme toggle ───────────────────────────────────── */
        .theme-toggle {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 999;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1.5px solid var(--card-border);
            background: var(--card-bg);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all var(--transition);
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }
        .theme-toggle:hover {
            background: var(--brand-soft);
            color: var(--brand);
            border-color: var(--brand);
            transform: rotate(20deg);
        }

        /* ── Card ───────────────────────────────────────────── */
        .auth-card {
            background: var(--card-bg);
            border: 1.5px solid var(--card-border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            width: 100%;
            max-width: 440px;
            padding: 2.5rem 2.25rem;
            transition: background var(--transition), border-color var(--transition);
        }

        /* ── Brand logo area ────────────────────────────────── */
        .auth-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-brand .brand-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--brand);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: .85rem;
            box-shadow: var(--shadow-btn);
        }
        .auth-brand h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -.3px;
        }
        .auth-brand p {
            font-size: .875rem;
            color: var(--text-secondary);
            margin-top: .25rem;
        }

        /* ── Session status ─────────────────────────────────── */
        .session-status {
            padding: .65rem 1rem;
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            border-radius: 8px;
            color: #065f46;
            font-size: .85rem;
            margin-bottom: 1.25rem;
        }
        [data-bs-theme="dark"] .session-status {
            background: rgba(110,231,183,.1);
            border-color: rgba(110,231,183,.3);
            color: #6ee7b7;
        }

        /* ── Form group ─────────────────────────────────────── */
        .form-group {
            margin-bottom: 1.15rem;
        }
        .form-label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: .45rem;
        }

        /* ── Input wrapper (icon inside) ────────────────────── */
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            transition: color var(--transition);
        }
        .form-control {
            width: 100%;
            padding: .7rem 2.75rem .7rem 2.6rem;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: var(--radius-input);
            color: var(--text-primary);
            font-size: .92rem;
            outline: none;
            transition: all var(--transition);
        }
        .form-control::placeholder { color: var(--text-muted); }
        .form-control:focus {
            background: var(--input-focus-bg);
            border-color: var(--brand);
            box-shadow: 0 0 0 3px var(--brand-soft);
        }
        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon { color: var(--brand); }

        /* ── Toggle password eye ────────────────────────────── */
        .toggle-password {
            position: absolute;
            right: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
            transition: color var(--transition);
            background: none;
            border: none;
            padding: 0;
        }
        .toggle-password:hover { color: var(--brand); }

        /* ── Error message ──────────────────────────────────── */
        .field-error {
            font-size: .8rem;
            color: #ef4444;
            margin-top: .35rem;
        }
        [data-bs-theme="dark"] .field-error { color: #f87171; }

        /* ── Remember + Forgot row ──────────────────────────── */
        .auth-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: .5rem;
        }
        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            font-size: .875rem;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
        }
        .remember-label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: var(--brand);
            cursor: pointer;
        }
        .forgot-link {
            font-size: .875rem;
            color: var(--brand);
            text-decoration: none;
            font-weight: 500;
            transition: color var(--transition);
        }
        .forgot-link:hover { color: var(--brand-hover); text-decoration: underline; }

        /* ── Submit button ──────────────────────────────────── */
        .btn-login {
            width: 100%;
            padding: .8rem;
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: var(--radius-input);
            font-size: .95rem;
            font-weight: 700;
            letter-spacing: .3px;
            cursor: pointer;
            transition: all var(--transition);
            box-shadow: var(--shadow-btn);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }
        .btn-login:hover {
            background: var(--brand-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(67,94,190,.45);
        }
        .btn-login:active { transform: translateY(0); }

        /* ── Divider ────────────────────────────────────────── */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.5rem 0 1.25rem;
            color: var(--text-muted);
            font-size: .78rem;
        }
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--card-border);
        }

        /* ── Register link ──────────────────────────────────── */
        .auth-footer {
            text-align: center;
            font-size: .875rem;
            color: var(--text-secondary);
        }
        .auth-footer a {
            color: var(--brand);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer a:hover { text-decoration: underline; }

        /* ── Mobile ─────────────────────────────────────────── */
        @media (max-width: 480px) {
            .auth-card {
                padding: 2rem 1.35rem;
                border-radius: 12px;
            }
            .auth-brand h1 { font-size: 1.2rem; }
            .btn-login { font-size: .9rem; }
        }
    </style>
</head>

<body>

    {{-- ── Theme toggle button ── --}}
    <button class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
        <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
    </button>

    {{-- ── Auth card ── --}}
    <div class="auth-card">

        {{-- Brand --}}
        <div class="auth-brand">
            <div class="brand-icon">
                <svg viewBox="0 0 60 60" width="32" height="32" xmlns="http://www.w3.org/2000/svg">
                    <!-- Fork -->
                    <rect x="17" y="8" width="2" height="16" rx="1" fill="white"/>
                    <rect x="21" y="8" width="2" height="16" rx="1" fill="white"/>
                    <rect x="25" y="8" width="2" height="16" rx="1" fill="white"/>
                    <path d="M17 24 Q17 32 21 32" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <path d="M27 24 Q27 32 23 32" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <rect x="20" y="32" width="3" height="20" rx="1.5" fill="white"/>
                    <!-- Spoon -->
                    <ellipse cx="38" cy="20" rx="5" ry="10" fill="none" stroke="white" stroke-width="1.8"/>
                    <path d="M33 30 Q33 38 36.5 38" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <path d="M43 30 Q43 38 39.5 38" fill="none" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <rect x="37" y="38" width="3" height="14" rx="1.5" fill="white"/>
                </svg>
            </div>
            <h1>Restoran</h1>
            <p>Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        {{-- Session status --}}
        @if (session('status'))
            <div class="session-status">
                <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <div class="input-wrapper">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    <i class="bi bi-envelope input-icon"></i>
                </div>
                @error('email')
                    <div class="field-error">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrapper">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <i class="bi bi-lock input-icon"></i>
                    <button type="button" class="toggle-password" id="togglePwd" tabindex="-1">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="field-error">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Remember me + Forgot --}}
            <div class="auth-extras">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember_me">
                    Ingat saya
                </label>

                {{-- @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Lupa password?
                    </a>
                @endif --}}
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk
            </button>
        </form>

        {{-- Register link --}}
        {{-- @if (Route::has('register'))
            <div class="auth-divider">atau</div>
            <div class="auth-footer">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        @endif --}}

    </div>

    {{-- ── Scripts ── --}}
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    <script>
        // ── Dark / Light mode ──────────────────────────────────
        const html       = document.documentElement;
        const btn        = document.getElementById('themeToggle');
        const icon       = document.getElementById('themeIcon');
        const STORAGE_KEY = 'mazer_theme';

        function applyTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
            localStorage.setItem(STORAGE_KEY, theme);
        }

        // Load saved preference (default: light)
        const saved = localStorage.getItem(STORAGE_KEY) || 'light';
        applyTheme(saved);

        btn.addEventListener('click', () => {
            const current = html.getAttribute('data-bs-theme');
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });

        // ── Toggle show/hide password ──────────────────────────
        const togglePwd = document.getElementById('togglePwd');
        const pwdInput  = document.getElementById('password');
        const eyeIcon   = document.getElementById('eyeIcon');

        togglePwd.addEventListener('click', () => {
            const isText = pwdInput.type === 'text';
            pwdInput.type      = isText ? 'password' : 'text';
            eyeIcon.className  = isText ? 'bi bi-eye' : 'bi bi-eye-slash';
        });
    </script>

</body>
</html>