<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan</title>
    <!-- Use local FontAwesome or CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563EB; /* Blue similar to screenshot */
            --bg-color: #F3F4F6;
            --card-bg: #FFFFFF;
            --text-color: #1F2937;
            --text-light: #6B7280;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        .mobile-container {
            width: 100%;
            max-width: 480px; /* Mobile width constraint */
            background-color: var(--card-bg);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            padding: 20px 24px;
            background-color: #49acf3ff;
            
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: #fbfbfdff;
        }

        .user-greeting {
            color: #fbfbfdff;
            font-size: 14px;
        }

        .user-position {
            color: #fbfbfdff;
            font-size: 14px;
        }

        .user-name {
            font-weight: 600;
            color: #fbfbfdff;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            background-color: #2470daff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            padding: 0 24px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            display: block;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 4px;
            display: block;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background-color: #EFF6FF; /* Light blue */
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        
        .stat-icon.green { background-color: #ECFDF5; color: var(--success-color); }
        .stat-icon.orange { background-color: #FFFBEB; color: var(--warning-color); }
        .stat-icon.purple { background-color: #F3E8FF; color: #8B5CF6; }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            padding: 0 24px;
            margin-bottom: 32px;
        }

        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: var(--text-color);
        }

        .menu-icon-box {
            width: 48px;
            height: 48px;
            background-color: var(--primary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-bottom: 8px;
            transition: transform 0.2s;
        }

        .menu-item:active .menu-icon-box {
            transform: scale(0.95);
        }

        .menu-label {
            font-size: 12px;
            font-weight: 500;
        }

        /* Attendance Status Card */
        .status-section {
            padding: 0 24px;
            margin-bottom: 24px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
        }

        .company-tag {
            background-color: #ECFDF5;
            color: var(--success-color);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
        }

        .status-card {
            background-color: #FEF3C7; /* Light yellow */
            border-radius: 16px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-info {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .status-icon-circle {
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.5);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #D97706;
        }

        .status-text h4 {
            font-size: 14px;
            font-weight: 600;
            color: #92400E;
            margin-bottom: 2px;
        }

        .status-text p {
            font-size: 12px;
            color: #B45309;
        }

        .status-badge {
            background-color: #FDE68A;
            color: #92400E;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        /* Present State */
        .status-card.present {
            background-color: #D1FAE5;
        }
        .status-card.present .status-icon-circle {
            color: var(--success-color);
        }
        .status-card.present .status-text h4 { color: #065F46; }
        .status-card.present .status-text p { color: #047857; }
        .status-card.present .status-badge { background-color: #A7F3D0; color: #065F46; }

        /* Bottom Nav */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            background-color: #fff;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
            border-top: 1px solid #F3F4F6;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--text-light);
            text-decoration: none;
            font-size: 10px;
            margin-top: 6px;
        }

        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .nav-item.active {
            color: var(--primary-color);
        }

        .fab-container {
            position: relative;
            top: -24px; 
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .fab {
            width: 56px;
            height: 56px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);
            margin-bottom: 4px;
            text-decoration: none;
        }

        .fab-label {
            color: var(--text-light);
            font-size: 10px;
        }

        .alert-disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* History Section */
        .history-section {
            padding: 0 24px;
            margin-bottom: 100px; /* Space for bottom nav */
        }

        .history-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .history-item {
            background: #fff;
            border-radius: 12px; 
            padding: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #F3F4F6;
        }

        .history-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .history-icon {
            width: 36px; 
            height: 36px; 
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-size: 14px;
        }

        .history-details h5 {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 2px;
        }

        .history-details p {
            font-size: 11px;
            color: var(--text-light);
        }

        .history-status {
            font-size: 10px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .status-late { 
            background-color: #FFFBEB; 
            color: #D97706; 
        }
        .status-present { 
            background-color: #ECFDF5; 
            color: #059669; 
        }
    </style>
</head>
<body>

<div class="mobile-container">
    
    <!-- Header -->
    <div class="header">
        <div class="header-top">
            <div class="header-title">Dashboard</div>
            <div class="profile-icon">
                <i class="fas fa-user"></i>
            </div>
        </div>
        <div class="user-greeting">Selamat datang,</div>
        <div class="user-name">{{ $employee->name ?? 'User' }}</div>
        <div class="user-position">{{ $employee->position->name ?? 'Position' }}</div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div>
                <span class="stat-value">{{ $totalAttendance ?? 0 }}</span>
                <span class="stat-label">Total Absensi</span>
            </div>
            <div class="stat-icon">
                <i class="far fa-clock"></i>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <span class="stat-value">{{ $totalLate ?? 0 }}</span>
                <span class="stat-label">Total Terlambat</span>
            </div>
            <div class="stat-icon orange">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <span class="stat-value">{{ $totalPermission ?? 0 }}</span>
                <span class="stat-label">Total Izin</span>
            </div>
            <div class="stat-icon purple">
                <i class="far fa-calendar-alt"></i>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <span class="stat-value">{{ $totalAlpha ?? 0 }}</span>
                <span class="stat-label">Total Alpha</span>
            </div>
            <div class="stat-icon purple">
                <i class="far fa-calendar-alt"></i>
            </div>
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="menu-grid">
        <a href="{{ route('attendance.history') }}" class="menu-item">
            <div class="menu-icon-box">
                <i class="far fa-clock"></i>
            </div>
            <span class="menu-label"> Absensi</span>
        </a>
        <a href="#" class="menu-item alert-disabled" onclick="alert('Fitur ini belum tersedia')">
            <div class="menu-icon-box">
                <i class="fas fa-book-open"></i>
            </div>
            <span class="menu-label">Gaji</span>
        </a>
    </div>

    <!-- Attendance Status 'Today' -->
    <div class="status-section">
        <div class="section-header">
            <span class="section-title">Absensi Hari Ini</span>
            <span class="company-tag">PT VNEU Teknologi Indonesia</span>
        </div>

        @if($todayAttendance)
            <div class="status-card present">
                <div class="status-info">
                    <div class="status-icon-circle">
                        <i class="far fa-check-circle"></i>
                    </div>
                    <div class="status-text">
                        <h4>Status: {{ $todayAttendance->status == 'Late' ? 'Terlambat' : 'Hadir' }}</h4>
                        <p>{{ \Carbon\Carbon::parse($todayAttendance->date)->format('d M Y') }}</p>
                    </div>
                </div>
                <span class="status-badge">{{ $todayAttendance->time_in ? \Carbon\Carbon::parse($todayAttendance->time_in)->format('H:i') : '--:--' }}</span>
            </div>
        @else
            <div class="status-card">
                <div class="status-info">
                    <div class="status-icon-circle">
                        <i class="far fa-clock"></i>
                    </div>
                    <div class="status-text">
                        <h4>Status: Belum Absen</h4>
                        <p>{{ \Carbon\Carbon::today()->format('d M Y') }}</p>
                    </div>
                </div>
                <span class="status-badge">--:--</span>
            </div>
        @endif
    </div>

    <!-- Attendance History Section -->
    <div class="history-section">
        <div class="section-header">
            <span class="section-title">Riwayat Terakhir</span>
            <a href="{{ route('attendance.history') }}" style="font-size: 12px; color: var(--primary-color); text-decoration: none;">Lihat Semua</a>
        </div>

        <div class="history-list">
            @forelse($attendanceHistory as $history)
                @php
                    $isLate = $history->status == 'Late';
                    $statusColor = $isLate ? 'orange' : 'green';
                    $statusClass = $isLate ? 'status-late' : 'status-present';
                    $icon = $isLate ? 'fa-exclamation-triangle' : 'fa-check';
                @endphp
                <div class="history-item">
                    <div class="history-info">
                        <div class="history-icon {{ $statusColor }}">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <div class="history-details">
                            <h5>{{ \Carbon\Carbon::parse($history->date)->format('d F Y') }}</h5>
                            <p>{{ \Carbon\Carbon::parse($history->time_in)->format('H:i') }} - {{ $history->time_out ? \Carbon\Carbon::parse($history->time_out)->format('H:i') : '--:--' }}</p>
                        </div>
                    </div>
                    <span class="history-status {{ $statusClass }}">
                        {{ $history->status == 'Late' ? 'Terlambat' : 'Hadir' }}
                    </span>
                </div>
            @empty
                <div class="history-item" style="justify-content: center; color: var(--text-light); font-size: 12px;">
                    Belum ada riwayat absensi.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="#" class="nav-item active">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        
        <div class="fab-container">
            <a href="{{ route('attendance.scan') }}" class="fab">
                <i class="fas fa-fingerprint"></i>
            </a>
            <span class="fab-label">Absensi</span>
        </div>

        <form action="#" method="GET" id="profile-form">
            @csrf
            <a href="#" onclick="document.getElementById('profile-form').submit()" class="nav-item">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
        </form>
    </div>

</div>

</body>
</html>
