<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absensi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563EB;
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
            max-width: 480px;
            background-color: var(--bg-color);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            padding: 20px 24px;
            background-color: #49acf3;
            color: white;
            display: flex;
            align-items: center;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .back-btn {
            color: white;
            font-size: 20px;
            text-decoration: none;
        }

        .header-title {
            font-size: 18px;
            font-weight: 600;
        }

        /* List Container */
        .history-list {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 80px; /* Space for bottom nav */
        }

        .history-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #E5E7EB;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #F3F4F6;
        }

        .date-text h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color);
        }

        .date-text p {
            font-size: 12px;
            color: var(--text-light);
        }

        .status-badge {
            font-size: 10px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .status-late {
            background-color: #FFFBEB;
            color: #D97706;
        }

        .status-present {
            background-color: #ECFDF5;
            color: #059669;
        }

        .time-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .time-box {
            background-color: #F9FAFB;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }

        .time-label {
            font-size: 11px;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .time-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color);
        }

        .photos-section {
            display: flex;
            gap: 12px;
        }

        .photo-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .photo-label {
            font-size: 10px;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .photo-frame {
            width: 100%;
            height: 100px;
            background-color: #E5E7EB;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9CA3AF;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Bottom Nav (Reused) */
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

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #D1D5DB;
        }

    </style>
</head>
<body>

<div class="mobile-container">
    
    <!-- Header -->
    <div class="header">
        <a href="{{ route('attendance.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="header-title">Riwayat Absensi</div>
    </div>

    <!-- Content -->
    <div class="history-list">
        @forelse($attendances as $attendance)
            @php
                $isLate = $attendance->status == 'Late';
                $statusText = $isLate ? 'Terlambat' : 'Hadir';
                $statusClass = $isLate ? 'status-late' : 'status-present';
            @endphp
            <div class="history-card">
                <!-- Header Card -->
                <div class="card-header">
                    <div class="date-text">
                        <h4>{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l, d F Y') }}</h4>
                        <p>{{ \Carbon\Carbon::parse($attendance->date)->diffForHumans() }}</p>
                    </div>
                    <span class="status-badge {{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </div>

                <!-- Time Grid -->
                <div class="time-grid">
                    <div class="time-box">
                        <div class="time-label">Jam Masuk</div>
                        <div class="time-value" style="color: {{ $isLate ? '#D97706' : 'inherit' }}">
                            {{ \Carbon\Carbon::parse($attendance->time_in)->format('H:i') }}
                        </div>
                    </div>
                    <div class="time-box">
                        <div class="time-label">Jam Keluar</div>
                        <div class="time-value">
                            {{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i') : '--:--' }}
                        </div>
                    </div>
                </div>

                <!-- Photos -->
                <div class="photos-section">
                    <div class="photo-box">
                        <span class="photo-label">Foto Masuk</span>
                        <div class="photo-frame">
                            @if($attendance->photo_in)
                                <img src="{{ asset('storage/attendance/' . $attendance->photo_in) }}" alt="Masuk">
                            @else
                                <i class="fas fa-camera-slash"></i>
                            @endif
                        </div>
                    </div>
                    <div class="photo-box">
                        <span class="photo-label">Foto Keluar</span>
                        <div class="photo-frame">
                            @if($attendance->photo_out)
                                <img src="{{ asset('storage/attendance/' . $attendance->photo_out) }}" alt="Keluar">
                            @else
                                <i class="fas fa-camera-slash"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="far fa-folder-open"></i>
                <p>Belum ada riwayat absensi.</p>
            </div>
        @endforelse
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <a href="{{ route('attendance.index') }}" class="nav-item">
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
