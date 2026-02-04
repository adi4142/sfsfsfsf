@extends('layouts.app')

@section('title', 'Detail Payroll')
@section('page_title', 'Detail Penggajian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Periode: {{ date("F", mktime(0, 0, 0, $payroll->period_month, 10)) }} {{ $payroll->period_year }}
                    </h3>
                    <div class="card-tools">
                        @if($payroll->details->isEmpty())
                        <form action="{{ route('payroll.generate', $payroll->payroll_id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-magic"></i> Generate Data Karyawan
                            </button>
                        </form>
                        @endif
                        <a href="{{ route('payroll.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Karyawan</th>
                                    <th>Gaji Pokok</th>
                                    <th>Total Tunjangan</th>
                                    <th>Total Potongan</th>
                                    <th>Total Gaji (Net)</th>
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payroll->details as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->nip }}</td>
                                    <td>{{ $detail->employee->name ?? 'User Deleted' }}</td>
                                    <td class="text-right">Rp {{ number_format($detail->basic_salary, 0, ',', '.') }}</td>
                                    <td class="text-right text-success">Rp {{ number_format($detail->total_allowance, 0, ',', '.') }}</td>
                                    <td class="text-right text-danger">Rp {{ number_format($detail->total_deduction, 0, ',', '.') }}</td>
                                    <td class="text-right font-weight-bold">Rp {{ number_format($detail->total_salary, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('payroll/detail/'.$detail->payroll_detail_id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-list"></i> Lihat Rincian
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Data belum digenerate. Silakan klik tombol <b>Generate Data Karyawan</b> di atas.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
