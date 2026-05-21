<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Land Registry System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --topbar-height: 60px;
            --primary: #1a56db;
            --primary-dark: #1e429f;
            --sidebar-bg: #1a1f36;
            --sidebar-text: #cbd5e1;
            --sidebar-active: #3b82f6;
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: all .3s ease;
            overflow-y: auto;
        }
        #sidebar .sidebar-brand {
            padding: 20px 20px 10px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #sidebar .sidebar-brand h6 {
            color: #fff;
            font-weight: 700;
            font-size: .85rem;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin: 0;
        }
        #sidebar .sidebar-brand small {
            color: var(--sidebar-text);
            font-size: .7rem;
        }
        #sidebar .nav-section-label {
            color: #64748b;
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 16px 20px 6px;
        }
        #sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 9px 20px;
            border-radius: 8px;
            margin: 1px 8px;
            font-size: .84rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all .2s;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: rgba(59,130,246,.15);
            color: #93c5fd;
        }
        #sidebar .nav-link.active { color: #60a5fa; }
        #sidebar .nav-link i { font-size: 1rem; width: 20px; text-align: center; }

        /* ── Topbar ── */
        #topbar {
            margin-left: var(--sidebar-width);
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky; top: 0; z-index: 900;
            display: flex; align-items: center;
            padding: 0 24px;
            justify-content: space-between;
        }

        /* ── Main content ── */
        #main-content {
            margin-left: var(--sidebar-width);
            padding: 24px;
            min-height: calc(100vh - var(--topbar-height));
        }

        /* ── Cards ── */
        .card { border: 1px solid #e2e8f0; border-radius: 12px; }
        .card-header { background: #fff; border-bottom: 1px solid #e2e8f0; font-weight: 600; }

        /* ── Stat cards ── */
        .stat-card {
            border-radius: 12px;
            border: none;
            color: #fff;
            padding: 20px;
        }
        .stat-card .stat-icon { font-size: 2.5rem; opacity: .7; }
        .stat-card .stat-value { font-size: 2rem; font-weight: 700; }
        .stat-card .stat-label { font-size: .82rem; opacity: .85; }

        /* ── Table ── */
        .table th { font-weight: 600; font-size: .8rem; color: #64748b; text-transform: uppercase; letter-spacing: .5px; }

        /* ── Responsive ── */
        @media(max-width: 768px) {
            #sidebar { left: -var(--sidebar-width); }
            #topbar, #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- ─── Sidebar ────────────────────────────────────────────────────────────── -->
<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            <div style="width:36px;height:36px;background:#3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-building text-white"></i>
            </div>
            <div>
                <h6>Land Registry</h6>
                <small>Government Portal</small>
            </div>
        </div>
    </div>

    <ul class="nav flex-column mt-2">
        <li><span class="nav-section-label">Main</span></li>
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li><span class="nav-section-label">Records</span></li>
        <li class="nav-item">
            <a href="{{ route('owners.index') }}" class="nav-link {{ request()->routeIs('owners.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Land Owners
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('properties.index') }}" class="nav-link {{ request()->routeIs('properties.*') ? 'active' : '' }}">
                <i class="bi bi-map"></i> Properties
            </a>
        </li>

        <li><span class="nav-section-label">Transactions</span></li>
        <li class="nav-item">
            <a href="{{ route('registrations.index') }}" class="nav-link {{ request()->routeIs('registrations.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Registrations
                @php $pending = \App\Models\Registration::pending()->count(); @endphp
                @if($pending)
                    <span class="badge bg-warning text-dark ms-auto">{{ $pending }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('transfers.index') }}" class="nav-link {{ request()->routeIs('transfers.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i> Transfers
            </a>
        </li>

        @if(auth()->user()->isAdmin())
        <li><span class="nav-section-label">Administration</span></li>
        <li class="nav-item">
            <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Reports
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i> User Management
            </a>
        </li>
        @endif
    </ul>
</nav>

<!-- ─── Topbar ─────────────────────────────────────────────────────────────── -->
<div id="topbar">
    <div class="d-flex align-items-center gap-2">
        <h6 class="mb-0 fw-600 text-dark">@yield('title', 'Dashboard')</h6>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="badge bg-light text-dark border">{{ auth()->user()->role_label }}</span>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <div style="width:34px;height:34px;background:#3b82f6;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:.85rem;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-dark fw-500" style="font-size:.88rem;">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- ─── Main Content ───────────────────────────────────────────────────────── -->
<div id="main-content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
