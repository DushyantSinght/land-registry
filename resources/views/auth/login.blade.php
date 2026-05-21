<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Land Registry System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #1a1f36 0%, #1a56db 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 100%; max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,.3);
        }
        .login-logo {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #1a56db, #3b82f6);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }
        .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 .2rem rgba(59,130,246,.25); }
        .btn-login { background: linear-gradient(135deg, #1a56db, #3b82f6); border: none; font-weight: 600; }
        .btn-login:hover { background: linear-gradient(135deg, #1e429f, #2563eb); }
        .divider { font-size: .78rem; color: #94a3b8; }
        .demo-accounts { font-size: .78rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="login-logo">
                <i class="bi bi-building text-white fs-4"></i>
            </div>
            <h5 class="fw-700 mb-1">Land Registry System</h5>
            <p class="text-muted mb-0" style="font-size:.84rem;">Government Land Registration Portal</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2">
                <small>{{ $errors->first() }}</small>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-500">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="your@email.gov" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-500">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted" for="remember" style="font-size:.84rem;">Remember me</label>
                </div>
            </div>
            <button type="submit" class="btn btn-login btn-primary w-100 py-2">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

        <hr class="divider my-4">

        <div class="demo-accounts text-center">
            <p class="text-muted mb-2"><strong>Demo Credentials</strong></p>
            <table class="table table-sm table-borderless mb-0">
                <tr><td class="text-muted">Admin</td><td><code>admin@landregistry.gov</code></td></tr>
                <tr><td class="text-muted">Registrar</td><td><code>registrar@landregistry.gov</code></td></tr>
                <tr><td class="text-muted">Viewer</td><td><code>viewer@landregistry.gov</code></td></tr>
                <tr><td colspan="2" class="text-muted">Password: <code>password</code></td></tr>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
