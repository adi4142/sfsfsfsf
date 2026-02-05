@extends('layouts.karyawan')

@section('title', 'Dashboard Karyawan')

@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Selamat Datang, {{ $employee->name ?? Auth::user()->name }}!</h5>
            <p>{{ $employee->position->name ?? 'Posisi belum diatur' }} - PT VNEU Teknologi Indonesia</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Stats Cards -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalAttendance ?? 0 }}</h3>
                <p>Total Absensi</p>
            </div>
            <div class="icon">
                <i class="far fa-clock"></i>
            </div>
            <a href="{{ route('attendance.index') }}" class="small-box-footer">Lihat Riwayat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalLate ?? 0 }}</h3>
                <p>Total Terlambat</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
             <a href="{{ route('attendance.index') }}" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalPermission ?? 0 }}</h3>
                <p>Total Izin</p>
            </div>
            <div class="icon">
                <i class="far fa-calendar-alt"></i>
            </div>
             <a href="#" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalAlpha ?? 0 }}</h3>
                <p>Total Alpha</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
             <a href="#" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Today's Status -->
    <div class="col-md-6">
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
                        <h1 class="text-center text-primary" style="font-size: 3rem; font-weight: bold;">{{ $todayAttendance->time_in ? \Carbon\Carbon::parse($todayAttendance->time_in)->format('H:i') : '--:--' }}</h1>
                    @else
                        <div class="icon-circle bg-secondary mb-3" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="far fa-clock fa-3x text-white"></i>
                        </div>
                        <h3 class="profile-username text-center">Belum Absen</h3>
                        <p class="text-muted text-center">{{ \Carbon\Carbon::today()->format('d F Y') }}</p>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('attendance.scan') }}" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-fingerprint mr-2"></i> Klik untuk Absensi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="col-md-6">
        <div class="card card-info h-100">
            <div class="card-header">
                <h3 class="card-title">Statistik Absensi Bulan Ini</h3>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- History Section -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Terakhir</h3>
                <div class="card-tools">
                    <a href="{{ route('attendance.index') }}" class="btn btn-tool btn-sm">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @forelse($attendanceHistory as $history)
                        @php
                            $isLate = $history->status == 'Late';
                            $badgeClass = $isLate ? 'badge-warning' : 'badge-success';
                            $iconClass = $isLate ? 'text-warning' : 'text-success';
                        @endphp
                        <li class="item">
                            <div class="product-img">
                                <i class="fas fa-calendar-alt fa-2x {{ $iconClass }}"></i>
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">
                                    {{ \Carbon\Carbon::parse($history->date)->format('d F Y') }}
                                    <span class="badge {{ $badgeClass }} float-right">{{ $history->status == 'Late' ? 'Terlambat' : 'Hadir' }}</span>
                                </a>
                                <span class="product-description">
                                    Masuk: {{ \Carbon\Carbon::parse($history->time_in)->format('H:i') }}
                                    @if($history->time_out)
                                     - Pulang: {{ \Carbon\Carbon::parse($history->time_out)->format('H:i') }}
                                    @endif
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="item">
                            <div class="p-3 text-center text-muted">Belum ada riwayat absensi.</div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
<script>
    $(function () {
        // Data from Controller
        var totalAttendance = {{ $totalAttendance ?? 0 }};
        var totalPermission = {{ $totalPermission ?? 0 }};
        var totalLate = {{ $totalLate ?? 0 }};
        var totalAlpha = {{ $totalAlpha ?? 0 }};
        
        // Calculate "On Time" (Approximate by subtracting known abnormalities from total)
        // assuming totalAttendance is Count of All Records.
        var presentOnTime = totalAttendance - totalLate - totalPermission - totalAlpha;
        if(presentOnTime < 0) presentOnTime = 0;

        var donutChartCanvas = $('#attendanceChart').get(0).getContext('2d')
        var donutData        = {
            labels: [
                'Hadir',
                'Izin',
                'Terlambat',
                'Alpha',
            ],
            datasets: [
                {
                    data: [presentOnTime, totalPermission, totalLate, totalAlpha],
                    backgroundColor : ['#007bff', '#28a745', '#ffc107', '#dc3545'],
                }
            ]
        }
        var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
        }
        //Create pie chart
        new Chart(donutChartCanvas, {
            type: 'pie',
            data: donutData,
            options: donutOptions
        })
    })
</script>
@endpush
