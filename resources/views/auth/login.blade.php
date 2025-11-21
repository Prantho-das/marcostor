@extends('layouts.app')

@section('content')
<div class="auth-wrapper d-flex align-items-center justify-content-center pb-5 mb-5">
    <div class="auth-card shadow-lg rounded-4 p-4 p-md-5 bg-white">
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1 " style="color: #cd4b57">Welcome Back</h3>
            <p class="text-secondary small mb-0">Login to continue to your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-envelope"></i></span>
                    <input id="email" type="email" 
                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autofocus 
                           placeholder="example@email.com">
                    @error('email')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-lock"></i></span>
                    <input id="password" type="password" 
                           class="form-control form-control-lg @error('password') is-invalid @enderror" 
                           name="password" required placeholder="********">
                    @error('password')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small" for="remember">Remember Me</label>
                </div>

                @if (Route::has('password.request'))
                    <a class=" small text-decoration-none" style="color: #cd4b57" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-danger btn-lg rounded-3">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Login
                </button>
            </div>

            <!-- Divider -->
            <div class="position-relative my-4 text-center">
                <hr class="m-0">
                <span class="position-absolute bg-white px-3 text-muted small" style="top:-10px; left:50%; transform:translateX(-50%)">
                    or
                </span>
            </div>

            <!-- Google Login -->
            <div class="d-grid mb-3">
                <a href="{{ route('google.login') }}" class="btn btn-google btn-lg rounded-3 d-flex align-items-center justify-content-center gap-2">
                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" width="20" height="20">
                    <span>Continue with Google</span>
                </a>
            </div>


            <!-- Register Link -->
            <div class="text-center mt-4">
                <p class="text-secondary small mb-0">
                    Don’t have an account? 
                    <a href="{{ route('register') }}" class=" fw-semibold text-decoration-none" style="color: #cd4b57">Register now</a>
                </p>
            </div>
        </form>
    </div>
</div>

<!-- ===== Custom Styles ===== -->
<style>
    body {
        background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
    }

    .auth-wrapper {
        min-height: calc(100vh - 100px);
    }

    .auth-card {
        max-width: 460px;
        width: 100%;
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }

    .auth-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.15);
    }

    .input-group-text {
        border-right: 0;
        color: #cd4b57;
    }

    .form-control {
        border-left: 0;
        font-size: 0.95rem;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #cd4b57;
    }

    .btn-primary {
        background-color: #cd4b57;
        border-color: #cd4b57;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    .btn-outline-danger {
        border: 1px solid #dc3545;
        color: #dc3545;
        transition: all 0.2s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    hr {
        border-top: 1px solid #ddd;
    }

    /* Google-style login button */
    .btn-google {
        background-color: #fff;
        color: #3c4043;
        border: 1px solid #dadce0;
        font-weight: 500;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .btn-google:hover {
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        color: #202124;
    }

    .btn-google:active {
        background-color: #f1f3f4;
        box-shadow: inset 0 2px 2px rgba(0,0,0,0.1);
    }


    @media (max-width: 576px) {
        .auth-card {
            padding: 2rem 1.3rem;
            border-radius: 1rem;
        }

        .btn-lg {
            font-size: 1rem;
            padding: 0.6rem;
        }
    }
</style>
@endsection
