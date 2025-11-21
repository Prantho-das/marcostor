@extends('layouts.app')

@section('content')
<div class="auth-wrapper d-flex align-items-center justify-content-center pb-5 mb-5">
    <div class="auth-card shadow-lg rounded-4 p-4 p-md-5 bg-white">
        <div class="text-center mb-4">
            <h3 class="fw-bold mb-1" style="color: #cd4b57">Create Account</h3>
            <p class="text-secondary small mb-0">Join Marco and start your journey today!</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-user"></i></span>
                    <input id="name" type="text" 
                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                           name="name" value="{{ old('name') }}" required autofocus 
                           placeholder="John Doe">
                    @error('name')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-envelope"></i></span>
                    <input id="email" type="email" 
                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required 
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

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password-confirm" class="form-label fw-semibold">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fa-solid fa-lock"></i></span>
                    <input id="password-confirm" type="password" 
                           class="form-control form-control-lg" 
                           name="password_confirmation" required placeholder="********">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg rounded-3">
                    <i class="fa-solid fa-user-plus me-2"></i> Create Account
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <p class="text-secondary small mb-0">
                    Already have an account? 
                    <a href="{{ route('login') }}" class=" fw-semibold text-decoration-none" style="color: #cd4b57">Login here</a>
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
        max-width: 480px;
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

    @media (max-width: 576px) {
        .auth-card {
            padding: 2rem 1.3rem;
            border-radius: 1rem;
        }
    }
</style>
@endsection
