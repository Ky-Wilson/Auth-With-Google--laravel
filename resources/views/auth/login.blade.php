<style>
    /* Fond miroir animé */
    body {
        background: #000;
        position: relative;
        overflow-x: hidden;
    }

    .mirror-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #1a1a2e, #16213e, #0f3460, #16213e, #1a1a2e);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        z-index: -3;
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Particules flottantes */
    .particles {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: -2;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        background: radial-gradient(circle, rgba(255,255,255,0.8), transparent);
        border-radius: 50%;
        animation: floatParticle 20s infinite;
    }

    .particle:nth-child(1) { width: 4px; height: 4px; left: 10%; top: 20%; animation-delay: 0s; animation-duration: 15s; }
    .particle:nth-child(2) { width: 6px; height: 6px; left: 20%; top: 80%; animation-delay: 2s; animation-duration: 18s; }
    .particle:nth-child(3) { width: 3px; height: 3px; left: 60%; top: 30%; animation-delay: 4s; animation-duration: 20s; }
    .particle:nth-child(4) { width: 5px; height: 5px; left: 80%; top: 60%; animation-delay: 1s; animation-duration: 16s; }
    .particle:nth-child(5) { width: 4px; height: 4px; left: 30%; top: 50%; animation-delay: 3s; animation-duration: 19s; }
    .particle:nth-child(6) { width: 6px; height: 6px; left: 70%; top: 10%; animation-delay: 5s; animation-duration: 17s; }

    @keyframes floatParticle {
        0%, 100% { 
            transform: translate(0, 0) scale(1);
            opacity: 0;
        }
        10% { opacity: 1; }
        90% { opacity: 1; }
        50% { 
            transform: translate(100px, -100px) scale(1.5);
        }
    }

    /* Effets de lumière */
    .light-effect {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: -2;
        pointer-events: none;
    }

    .light {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        animation: pulse 4s ease-in-out infinite;
    }

    .light1 {
        width: 400px;
        height: 400px;
        background: rgba(66, 153, 225, 0.3);
        top: -100px;
        left: -100px;
        animation-delay: 0s;
    }

    .light2 {
        width: 500px;
        height: 500px;
        background: rgba(159, 122, 234, 0.25);
        bottom: -150px;
        right: -150px;
        animation-delay: 2s;
    }

    .light3 {
        width: 350px;
        height: 350px;
        background: rgba(236, 72, 153, 0.2);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation-delay: 1s;
    }

    @keyframes pulse {
        0%, 100% { 
            transform: scale(1);
            opacity: 0.3;
        }
        50% { 
            transform: scale(1.2);
            opacity: 0.6;
        }
    }

    /* Container principal avec effet miroir */
    .auth-container {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        box-shadow: 
            0 8px 32px 0 rgba(0, 0, 0, 0.4),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.1);
        animation: containerFloat 6s ease-in-out infinite;
        position: relative;
    }

    @keyframes containerFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .auth-container::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, 
            transparent, 
            rgba(66, 153, 225, 0.5), 
            rgba(159, 122, 234, 0.5), 
            rgba(236, 72, 153, 0.5),
            transparent);
        border-radius: 30px;
        z-index: -1;
        animation: borderRotate 3s linear infinite;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .auth-container:hover::before {
        opacity: 1;
    }

    @keyframes borderRotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Logo avec animation */
    .auth-logo {
        text-align: center;
        margin-bottom: 2rem;
        animation: logoGlow 3s ease-in-out infinite;
    }

    @keyframes logoGlow {
        0%, 100% { filter: drop-shadow(0 0 10px rgba(66, 153, 225, 0.5)); }
        50% { filter: drop-shadow(0 0 20px rgba(159, 122, 234, 0.8)); }
    }

    .auth-logo h1 {
        background: linear-gradient(135deg, #4299e1, #9f7aea, #ec4899);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        animation: textShine 3s ease-in-out infinite;
        letter-spacing: 2px;
    }

    @keyframes textShine {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .auth-logo p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
        letter-spacing: 1px;
    }

    /* Inputs stylisés */
    .auth-input {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        border-radius: 12px !important;
        padding: 16px 18px !important;
        transition: all 0.3s ease !important;
    }

    .auth-input::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }

    .auth-input:focus {
        border-color: rgba(66, 153, 225, 0.5) !important;
        background: rgba(255, 255, 255, 0.08) !important;
        box-shadow: 
            0 0 20px rgba(66, 153, 225, 0.3),
            inset 0 1px 3px rgba(0, 0, 0, 0.2) !important;
        transform: translateY(-2px);
        outline: none !important;
        ring: 0 !important;
    }

    /* Labels */
    .auth-label {
        color: rgba(255, 255, 255, 0.8) !important;
        font-weight: 500;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    /* Checkbox Remember Me */
    .auth-checkbox {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
    }

    .auth-checkbox:checked {
        background: linear-gradient(135deg, #4299e1, #9f7aea) !important;
        border-color: #4299e1 !important;
    }

    .auth-remember-text {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    /* Bouton principal avec effet brillant */
    .auth-btn-primary {
        background: linear-gradient(135deg, #4299e1, #9f7aea, #ec4899) !important;
        background-size: 200% 200%;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 14px 28px !important;
        font-size: 1rem !important;
        font-weight: 700 !important;
        cursor: pointer;
        transition: all 0.3s ease !important;
        box-shadow: 0 5px 25px rgba(66, 153, 225, 0.4) !important;
        position: relative;
        overflow: hidden;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .auth-btn-primary::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
        transform: rotate(45deg);
        animation: buttonShine 3s infinite;
    }

    @keyframes buttonShine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }

    .auth-btn-primary:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 35px rgba(66, 153, 225, 0.6) !important;
        animation: buttonPulse 1.5s infinite;
    }

    @keyframes buttonPulse {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    /* Lien mot de passe oublié */
    .auth-link {
        color: #4299e1 !important;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .auth-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #4299e1, #9f7aea);
        transition: width 0.3s ease;
    }

    .auth-link:hover::after {
        width: 100%;
    }

    .auth-link:hover {
        text-shadow: 0 0 10px rgba(66, 153, 225, 0.8) !important;
    }

    /* Divider animé */
    .auth-divider {
        display: flex;
        align-items: center;
        margin: 2rem 0;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.875rem;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: dividerGlow 2s ease-in-out infinite;
    }

    @keyframes dividerGlow {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 1; }
    }

    .auth-divider span {
        padding: 0 1.25rem;
        letter-spacing: 2px;
    }

    /* Boutons sociaux avec effet miroir */
    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-right: 15px;
    }

    .social-link::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .social-link:hover::before {
        width: 300px;
        height: 300px;
    }

    .social-link:hover {
        border-color: rgba(66, 153, 225, 0.5);
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 10px 30px rgba(66, 153, 225, 0.3);
    }

    .social-link img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        position: relative;
        z-index: 1;
        filter: brightness(1.2);
        transition: transform 0.3s ease;
    }

    .social-link:hover img {
        transform: scale(1.1) rotate(5deg);
    }

    /* GitHub button */
    .github-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .github-link::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        transform: translate(-50%, -50%);
        transition: width 0.5s, height 0.5s;
    }

    .github-link:hover::before {
        width: 300px;
        height: 300px;
    }

    .github-link:hover {
        border-color: rgba(66, 153, 225, 0.5);
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 10px 30px rgba(66, 153, 225, 0.3);
    }

    .github-link svg {
        width: 32px;
        height: 32px;
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease;
    }

    .github-link:hover svg {
        transform: scale(1.1) rotate(-5deg);
    }

    /* Messages d'erreur */
    .auth-error {
        color: #fc8181 !important;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animation d'entrée des éléments */
    .animate-slide-up {
        animation: slideUp 0.5s ease-out backwards;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }
    .animate-delay-5 { animation-delay: 0.5s; }

    /* Responsive */
    @media (max-width: 640px) {
        .auth-logo h1 {
            font-size: 2rem;
        }
        
        .social-link,
        .github-link {
            margin-right: 10px;
            padding: 10px;
        }

        .social-link img,
        .github-link svg {
            width: 28px;
            height: 28px;
        }
    }
</style>

<!-- Effets de fond -->
<div class="mirror-background"></div>
<div class="particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
</div>
<div class="light-effect">
    <div class="light light1"></div>
    <div class="light light2"></div>
    <div class="light light3"></div>
</div>

<x-guest-layout>
    <div class="auth-container p-8">
        <!-- Logo animé -->
        <div class="auth-logo">
            <h1>✨ AuthFlow</h1>
            <p>Connectez-vous à votre espace</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="animate-slide-up animate-delay-1">
                <x-input-label for="email" :value="__('Email')" class="auth-label" />
                <x-text-input id="email" class="block mt-1 w-full auth-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 auth-error" />
            </div>

            <!-- Password -->
            <div class="mt-4 animate-slide-up animate-delay-2">
                <x-input-label for="password" :value="__('Password')" class="auth-label" />
                <x-text-input id="password" class="block mt-1 w-full auth-input"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 auth-error" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 animate-slide-up animate-delay-3">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded auth-checkbox" name="remember">
                    <span class="ms-2 text-sm auth-remember-text">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6 animate-slide-up animate-delay-4">
                @if (Route::has('password.request'))
                    <a class="auth-link text-sm" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="auth-btn-primary">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <!-- Divider -->
            <div class="auth-divider animate-slide-up animate-delay-5">
                <span>OU</span>
            </div>

            <!-- Auth with social -->
            <div class="flex items-center justify-center animate-slide-up animate-delay-5">
                <a title="Login with google" href="{{ route('social.redirect', 'google') }}" class="social-link">
                    <img src="{{ asset('assets/google.jpeg') }}" alt="Google">
                </a>
                <a title="Login with facebook" href="{{ route('social.redirect', 'facebook') }}" class="social-link">
                    <img src="{{ asset('assets/facebook.png') }}" alt="Facebook">
                </a>
                <button type="button" class="github-link" onclick="window.location.href='{{ route('social.redirect', 'github') }}'">
                    <svg viewBox="0 0 24 24" fill="white">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>