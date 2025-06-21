@extends('layouts.app')

@section('title', 'Edit Attendance Session')

@push('style')
	<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>Edit Attendance Session</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
					<div class="breadcrumb-item"><a href="#">Attendance</a></div>
					<div class="breadcrumb-item">Edit Session</div>
				</div>
			</div>

			<div class="section-body">
				<h2 class="section-title">Attendance Session</h2>
				<div class="card">
					<form action="{{ route('session.update', $attendanceSession->id) }}" method="POST">
						@csrf
						@method('PUT')
						<div class="card-header">
							<h4>Session Information</h4>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label>Class</label>
								<select name="class_id" class="form-control select2 @error('class_id') is-invalid @enderror">
									<option value="">-- Select Class --</option>
									@foreach ($classes as $class)
										<option value="{{ $class->id }}"
											{{ old('class_id', $attendanceSession->class_id) == $class->id ? 'selected' : '' }}>
											{{ $class->name }}
										</option>
									@endforeach
								</select>
								@error('class_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group">
								<label>Dosen</label>
								<select name="dosen_id" class="form-control select2 @error('dosen_id') is-invalid @enderror">
									<option value="">-- Select Dosen --</option>
									@foreach ($dosens as $dosen)
										<option value="{{ $dosen->id }}"
											{{ old('dosen_id', $attendanceSession->dosen_id) == $dosen->id ? 'selected' : '' }}>
											{{ $dosen->name }}
										</option>
									@endforeach
								</select>
								@error('dosen_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group">
								<label>Session Date</label>
								<input type="date" name="session_date" class="form-control @error('session_date') is-invalid @enderror"
									value="{{ old('session_date', $attendanceSession->session_date) }}">
								@error('session_date')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group">
								<label>Start Time</label>
								<input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror"
									value="{{ old('start_time', $attendanceSession->start_time) }}">
								@error('start_time')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group">
								<label>End Time</label>
								<input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror"
									value="{{ old('end_time', $attendanceSession->end_time) }}">
								@error('end_time')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="form-group">
								<label>Status</label>
								<select name="status" class="form-control @error('status') is-invalid @enderror">
									<option value="on" {{ old('status', $attendanceSession->status) == 'on' ? 'selected' : '' }}>On</option>
									<option value="off" {{ old('status', $attendanceSession->status) == 'off' ? 'selected' : '' }}>Off</option>
								</select>
								@error('status')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="card-footer text-right">
							<button class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>

			</div>
		</section>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});
	</script>
@endpush
