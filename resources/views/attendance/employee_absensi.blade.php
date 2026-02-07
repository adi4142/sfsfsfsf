@extends('layouts.karyawan')

@section('title', 'Absensi Karyawan')

@section('page_title', 'Absensi')

@section('content')

<style>
    .status-info-box {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 20px;
    border-left: 4px solid var(--primary-color);
}

.status-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.status-text {
    flex: 1;
}

.status-label {
    font-size: 12px;
    color: #6c757d;
    text-transform: uppercase;
    font-weight: 600;
}

.status-value {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-color);
}

.btn-scan {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 12px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: white;
    margin-bottom: 20px;
}

.btn-scan:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.btn-scan.check-in {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.btn-scan.check-out {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.btn-scan i {
    font-size: 24px;
}

</style>
<div class="row">
    <div class="col-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> {{ $employee->name ?? Auth::user()->name }}, ini adalah rekap absensi anda</h5>
            <p>{{ $employee->position->name ?? 'Posisi belum diatur' }} - PT VNEU Teknologi Indonesia</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Today's Status -->
    <div class="col-md-12">
        <div class="card card-primary card-outline h-100">
            <div class="card-header">
                <h3 class="card-title">Absensi Hari Ini</h3>
            </div>
            <div class="card-body box-profile d-flex flex-column justify-content-center">
                <div class="text-center">
                    @if($todayAttendance)
                        @if($todayAttendance->status == 'Late')
                             <div class="icon-circle bg-warning mb-3" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-exclamation-triangle fa-3x text-white"></i>
                            </div>
                        @else
                             <div class="icon-circle bg-success mb-3" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="far fa-check-circle fa-3x text-white"></i>
                            </div>
                        @endif
                        
                        <h3 class="profile-username text-center">{{ $todayAttendance->status == 'Late' ? 'Terlambat' : 'Hadir' }}</h3>
                        <p class="text-muted text-center">{{ \Carbon\Carbon::parse($todayAttendance->date)->format('d F Y') }}</p>
                        <h1 class="text-center text-primary" style="font-size: 3rem; font-weight: bold;">{{ \Carbon\Carbon::now()->translatedFormat('H:i') }}
</h1>
                    @else
                        <div class="icon-circle bg-secondary mb-3" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="far fa-clock fa-3x text-white"></i>
                        </div>
                        <h3 class="profile-username text-center">Belum Absen</h3>
                        <p class="text-muted text-center">{{ \Carbon\Carbon::today()->format('d F Y') }}</p>
                    @endif
                </div>
                <div class="status-text">
                    <div class="status-label">Jam Kerja: 07.00 - 16.00 WIB</div>
                </div>
            </div>
                @if(!$attendance)
        <div class="status-info-box">
            <div class="status-icon">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <div class="status-text">
                <div class="status-label">Status Absensi</div>
                <div class="status-value">Belum Absen Masuk</div>
            </div>
        </div>

        <button id="btn-absen" class="btn-scan check-in" onclick="window.location.href='{{ route('attendance.scan') }}'" >
            <i class="fas fa-fingerprint"></i>
            <span>Absen Masuk</span>
        </button>
        @elseif(!$attendance->time_out)
        <div class="status-info-box">
            <div class="status-icon" style="background: var(--success-color);">
                <i class="fas fa-check"></i>
            </div>
            <div class="status-text">
                <div class="status-label">Absen Masuk : {{ $todayAttendance->time_in ? \Carbon\Carbon::parse($todayAttendance->time_in)->format('H:i') : '--:--' }}</div>
                <div class="status-value">Belum Absen Keluar</div>
            </div>
        </div>

        <button id="btn-absen" class="btn-scan check-out" onclick="window.location.href='{{ route('attendance.scan') }}'">
            <i class="fas fa-sign-out-alt"></i>
            <span>Absen Keluar</span>
        </button>
        @endif

            </div>
        </div>
    </div>
@endsection