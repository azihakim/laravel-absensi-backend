@extends('layouts.app')

@section('main')
	<div class="main-content mt-5">
		<h1>Rekap Absensi</h1>
		<form action="{{ route('attendance.recap') }}" method="POST">
			@csrf
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="start_date">Tanggal Mulai:</label>
					<input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
				</div>
				<div class="form-group col-md-3">
					<label for="end_date">Tanggal Selesai:</label>
					<input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
				</div>
				<div class="form-group col-md-3 align-self-end">
					<button type="submit" class="btn btn-primary mt-4">Rekap</button>
				</div>
			</div>
		</form>
		@if ($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
	</div>
@endsection
