@extends('layouts.app')

@section('title', 'Add Selection Applicant')
@section('page_title', 'Selection Applicant')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Selection Applicant</h3>
    </div>
    <form action="{{ route('selectionapplicant.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="job_applicant_id">Job Applicant</label>
                <select name="job_applicant_id" id="job_applicant_id" class="form-control @error('job_applicant_id') is-invalid @enderror">
                    <option value="">-- Select Applicant --</option>
                    @foreach($jobApplicants as $applicant)
                        <option value="{{ $applicant->job_applicant_id }}" {{ old('job_applicant_id') == $applicant->job_applicant_id ? 'selected' : '' }}>
                            {{ $applicant->name }}
                        </option>
                    @endforeach
                </select>
                @error('job_applicant_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="selection_id">Selection Stage</label>
                <select name="selection_id" id="selection_id" class="form-control @error('selection_id') is-invalid @enderror">
                    <option value="">-- Select Stage --</option>
                    @foreach($selections as $selection)
                        <option value="{{ $selection->selection_id }}" {{ old('selection_id') == $selection->selection_id ? 'selected' : '' }}>
                            {{ $selection->name }}
                        </option>
                    @endforeach
                </select>
                @error('selection_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="score">Score</label>
                <input type="number" name="score" id="score" class="form-control @error('score') is-invalid @enderror" value="{{ old('score') }}" placeholder="Enter score">
                @error('score')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3" placeholder="Enter notes">{{ old('notes') }}</textarea>
                @error('notes')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('selectionapplicant.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
