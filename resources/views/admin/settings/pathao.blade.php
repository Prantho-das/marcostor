@extends('layouts.admin.master')

@section('title', 'Update Pathao Credentials')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4">🛠️ Update Pathao Credentials</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.pathao.update') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="client_id" class="form-label">Client ID</label>
            <input type="text" name="client_id" id="client_id" value="{{ old('client_id', $credentials['client_id']) }}"
                class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="client_secret" class="form-label">Client Secret</label>
            <input type="text" name="client_secret" id="client_secret"
                value="{{ old('client_secret', $credentials['client_secret']) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', $credentials['username']) }}"
                class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="text" name="password" id="password" value="{{ old('password', $credentials['password']) }}"
                class="form-control" required>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="sandbox" value="0">
            <input type="checkbox" name="sandbox" id="sandbox" value="1" class="form-check-input" {{ (old('sandbox',
                $credentials['sandbox'])=='1' ) ? 'checked' : '' }}>
            <label for="sandbox" class="form-check-label">Sandbox Mode</label>
        </div>

        <button type="submit" class="btn btn-primary">💾 Save Credentials</button>
    </form>
</div>
@endsection
