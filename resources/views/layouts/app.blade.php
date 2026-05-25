<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Expired Food Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { display: flex; min-height: 100vh; background: #f4f6f9; }

        /* SIDEBAR */
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: #1a1f36;
            color: #fff;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }
        #sidebar .sidebar-brand {
            padding: 20px 16px;
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 1px solid #2e3557;
            color: #fff;
            text-decoration: none;
            display: block;
        }
        #sidebar .sidebar-brand small {
            display: block;
            font-size: 0.7rem;
            font-weight: 400;
            color: #8892b0;
            margin-top: 2px;
        }
        #sidebar .nav-label {
            padding: 16px 16px 4px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8892b0;
        }
        #sidebar .nav-link {
            color: #ccd6f6;
            padding: 10px 16px;
            border-radius: 6px;
            margin: 2px 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: #2e3557;
            color: #64ffda;
        }
        #sidebar .nav-link i { font-size: 1rem; width: 20px; }

        /* MAIN CONTENT */
        #main-content {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* TOPBAR */
        #topbar {
            background: #fff;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        #topbar .page-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1f36;
            margin: 0;
        }
        #topbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: #444;
        }

        /* PAGE CONTENT */
        #page-content { padding: 24px; flex: 1; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div id="sidebar">
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        🥫 SEFT
        <small>Smart Expired Food Tracker</small>
    </a>

    <div class="nav-label">Umum</div>
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-label">Data Master</div>
    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Produk
    </a>
    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <i class="bi bi-tag"></i> Kategori
    </a>
    <a href="{{ route('locations.index') }}" class="nav-link {{ request()->routeIs('locations.*') ? 'active' : '' }}">
        <i class="bi bi-geo-alt"></i> Lokasi Rak
    </a>

    <div class="nav-label">Stok</div>
    <a href="{{ route('stock-ins.index') }}" class="nav-link {{ request()->routeIs('stock-ins.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-down-circle"></i> Stok Masuk
    </a>
    <a href="{{ route('stock-outs.index') }}" class="nav-link {{ request()->routeIs('stock-outs.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-up-circle"></i> Stok Keluar
    </a>

    <div class="nav-label">Monitoring</div>
    <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
        <i class="bi bi-bell"></i> Notifikasi
    </a>

    <div class="nav-label">Laporan</div>
    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-bar-graph"></i> Rekap Stok
    </a>
    <a href="{{ route('activity-logs.index') }}" class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Audit Trail
    </a>
</div>

<!-- MAIN CONTENT -->
<div id="main-content">

    <!-- TOPBAR -->
    <div id="topbar">
        <h6 class="page-title">@yield('page-title', 'Dashboard')</h6>
        <div class="user-info">
            @php
                $unreadCount = \App\Models\Notification::where('is_read', false)->count();
                $roleColors  = [
                    'admin'          => 'danger',
                    'manajer'        => 'primary',
                    'petugas_gudang' => 'success',
                    'supplier'       => 'warning',
                    'petugas_qc'     => 'info',
                ];
                $roleColor = $roleColors[auth()->user()->role] ?? 'secondary';
            @endphp
            <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-secondary position-relative">
                <i class="bi bi-bell"></i>
                @if($unreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            <span><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
            <span class="badge bg-{{ $roleColor }}">{{ auth()->user()->role }}</span>
            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- PAGE CONTENT -->
    <div id="page-content">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });
});
</script>
@stack('scripts')
</body>
</html>