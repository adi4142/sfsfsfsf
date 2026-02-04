@extends('layouts.app')

@section('title', 'Edit Komponen Gaji')
@section('page_title', 'Edit Komponen Gaji')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        Edit Komponen: {{ $component->name }}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('payroll/detail/'.$detail->payroll_detail_id.'/update-component/'.$component->payroll_component_id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Komponen</label>
                            <input type="text" name="name" class="form-control" value="{{ $component->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="type" class="form-control" required>
                                <option value="allowance" {{ $component->type == 'allowance' ? 'selected' : '' }}>Tunjangan (+)</option>
                                <option value="deduction" {{ $component->type == 'deduction' ? 'selected' : '' }}>Potongan (-)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nominal (Rp)</label>
                            <input type="number" name="amount" class="form-control" value="{{ $component->amount }}" min="0" required>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('payroll.detail', $detail->payroll_detail_id) }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
