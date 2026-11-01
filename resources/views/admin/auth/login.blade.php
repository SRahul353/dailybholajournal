<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পাঠক ও অ্যাডমিন লগইন | দৈনিক ভোলা জার্নাল</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-bg: #f8fafc;     /* Soft slate light background */
            --card-bg: #ffffff;        /* Clean white card */
            --accent: #dc2626;         /* Crimson Accent */
            --accent-hover: #b91c1c;
            --text-main: #334155;      /* Dark slate gray */
            --text-sub: #64748b;       /* Muted slate */
            --border-color: #e2e8f0;   /* Light gray borders */
            --radius: 16px;
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Noto Sans Bengali', 'Outfit', sans-serif;
            background-color: var(--primary-bg);
            background-image: 
                radial-gradient(at 10% 20%, rgba(220, 38, 38, 0.05) 0px, transparent 50%),
                radial-gradient(at 90% 80%, rgba(203, 213, 225, 0.3) 0px, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            padding: 24px;
        }

        /* Glassmorphic Login Container */
        .login-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            width: 100%;
            max-width: 440px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
            animation: fadeIn 0.8s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-logo {
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .brand-logo span {
            color: var(--accent);
        }

        .brand-subtitle {
            font-size: 0.95rem;
            color: var(--text-sub);
            letter-spacing: 1px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--text-sub);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input {
            width: 100%;
            padding: 12px 16px 12px 42px;
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-main);
            font-size: 0.95rem;
            outline: none;
            transition: var(--transition);
            font-family: inherit;
        }
 
        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15);
            background-color: #ffffff;
        }

        .form-input:focus + .input-icon {
            color: var(--accent);
        }

        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            font-size: 0.85rem;
            color: var(--text-sub);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-me input {
            cursor: pointer;
            accent-color: var(--accent);
        }

        .forgot-link:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* Button */
        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: var(--accent);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .submit-btn:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.45);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Errors Alert */
        .error-alert {
            background-color: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Social Login Buttons */
        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 24px;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
        }

        .social-btn-google {
            background-color: #ffffff;
            color: #374151;
            border-color: #e5e7eb;
        }

        .social-btn-google:hover {
            background-color: #f9fafb;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
            color: #111827;
        }

        .social-btn-facebook {
            background-color: #1877f2;
            color: #ffffff;
            border-color: #1877f2;
        }

        .social-btn-facebook:hover {
            background-color: #166fe5;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.35);
            transform: translateY(-1px);
        }

        /* Divider */
        .divider-row {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: var(--text-sub);
            font-size: 0.84rem;
        }

        .divider-row::before,
        .divider-row::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }

        .divider-row span {
            padding: 0 12px;
            font-weight: 500;
        }

        .alert-info-box {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.88rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.88rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-home-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            font-size: 0.85rem;
            color: var(--text-sub);
        }

        .back-home-link:hover {
            color: var(--accent);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-header">
            <h1 class="brand-logo">দৈনিক ভোলা<span>জার্নাল</span></h1>
            <p class="brand-subtitle">পাঠক ও কন্ট্রোল প্যানেল লগইন</p>
        </div>

        @if(session('info'))
            <div class="alert-info-box">
                <i class="fa-solid fa-circle-info"></i>
                <span>{{ session('info') }}</span>
            </div>
        @elseif(session('url.intended') && (str_contains(session('url.intended'), 'contact') || str_contains(session('url.intended'), 'opinion')))
            <div class="alert-info-box">
                <i class="fa-solid fa-lock text-primary"></i>
                <span>যোগাযোগ করতে বা মতামত/কলাম জমা দিতে অনুগ্রহ করে আগে লগইন করুন।</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert-success-box">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Social Login: Google & Facebook -->
        <div class="social-buttons">
            <a href="{{ route('social.redirect', 'google') }}" class="social-btn social-btn-google">
                <svg width="20" height="20" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                </svg>
                <span>গুগল (Google) দিয়ে লগইন</span>
            </a>

            <a href="{{ route('social.redirect', 'facebook') }}" class="social-btn social-btn-facebook">
                <i class="fa-brands fa-facebook-f" style="font-size: 1.15rem;"></i>
                <span>ফেসবুক (Facebook) দিয়ে লগইন</span>
            </a>
        </div>

        <!-- Quick Reader Login Box -->
        <details class="quick-reader-details" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 12px 14px; margin-bottom: 20px;">
            <summary style="cursor: pointer; font-size: 0.88rem; font-weight: 600; color: #475569; display: flex; align-items: center; justify-content: space-between;">
                <span><i class="fa-solid fa-user-check text-danger me-1"></i> পাঠক হিসেবে দ্রুত প্রবেশ (পাসওয়ার্ড ছাড়া)</span>
                <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem;"></i>
            </summary>
            <form action="{{ route('auth.quick-reader-login') }}" method="POST" style="margin-top: 14px;">
                @csrf
                <div class="form-group" style="margin-bottom: 12px;">
                    <label class="form-label" style="font-size: 0.82rem;">আপনার নাম</label>
                    <input type="text" name="name" required placeholder="আপনার পূর্ণ নাম" class="form-input" style="padding: 9px 12px; font-size: 0.88rem;">
                </div>
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label" style="font-size: 0.82rem;">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" required placeholder="example@gmail.com" class="form-input" style="padding: 9px 12px; font-size: 0.88rem;">
                </div>
                <button type="submit" class="submit-btn" style="padding: 10px; font-size: 0.9rem;">
                    <span>পাঠক হিসেবে প্রবেশ করুন</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </details>

        <div class="divider-row">
            <span>অথবা ইমেইল দিয়ে প্রবেশ করুন</span>
        </div>

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">ইমেইল ঠিকানা</label>
                <div class="input-wrapper">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="আপনার ইমেইল দিন" class="form-input">
                    <i class="fa-solid fa-envelope input-icon"></i>
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">পাসওয়ার্ড</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="••••••••" class="form-input">
                    <i class="fa-solid fa-lock input-icon"></i>
                </div>
            </div>

            <!-- Remember Me options -->
            <div class="options-row">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember" checked>
                    <span>আমাকে মনে রাখুন</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                <span>লগইন করুন</span>
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-home-link">
            <i class="fa-solid fa-angle-left"></i> মূল ওয়েবসাইটে ফিরে যান
        </a>
    </div>

</body>
</html>
