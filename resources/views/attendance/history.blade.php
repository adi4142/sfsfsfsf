@extends('layouts.karyawan')

@section('title', 'Riwayat Absensi')

@section('page_title', 'Riwayat Absensi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Data Riwayat Absensi</h3>
                <div class="card-tools">
                    <a href="{{ route('attendance.dashboard') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px">No</th>
                                <th>Hari / Tanggal</th>
                                <th>Jam Masuk</th>
                                <th class="text-center">Foto Masuk</th>
                                <th>Jam Keluar</th>
                                <th class="text-center">Foto Keluar</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                @php
                                    $isLate = $attendance->status == 'Late';
                                    $statusText = $isLate ? 'Terlambat' : 'Hadir';
                                    $statusClass = $isLate ? 'badge-warning' : 'badge-success';
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="font-weight-bold">{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l, d F Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($attendance->date)->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <span class="text-{{ $isLate ? 'warning' : 'dark' }} font-weight-bold">
                                            {{ \Carbon\Carbon::parse($attendance->time_in)->format('H:i') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($attendance->photo_in)
                                            <a href="{{ asset('storage/attendance/' . $attendance->photo_in) }}" target="_blank">
                                                <img src="{{ asset('storage/attendance/' . $attendance->photo_in) }}" 
                                                     alt="Masuk" 
                                                     class="img-thumbnail" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="fas fa-camera-slash"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i') : '--:--' }}
                                    </td>
                                    <td class="text-center">
                                        @if($attendance->photo_out)
                                            <a href="{{ asset('storage/attendance/' . $attendance->photo_out) }}" target="_blank">
                                                <img src="{{ asset('storage/attendance/' . $attendance->photo_out) }}" 
                                                     alt="Keluar" 
                                                     class="img-thumbnail" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="fas fa-camera-slash"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($isLate)
                                            <small class="text-warning">Masuk melebihi jam jam operasional</small>
                                        @else
                                            <small class="text-success">On Time</small>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="fas fa-info-circle mr-1"></i> Belum ada riwayat absensi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="card-footer clearfix">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .img-thumbnail {
        transition: transform .2s;
    }
    .img-thumbnail:hover {
        transform: scale(1.1);
        z-index: 10;
        cursor: pointer;
    }
</style>
@endpush

