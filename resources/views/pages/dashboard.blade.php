@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
	<!-- CSS Libraries -->
	<link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
	<div class="main-content">
		<section class="section">
			<div class="section-header" style="margin-bottom: -1px">
				<h1>Dashboard</h1>
			</div>
			<div class="mb-2">
				<img src="{{ asset('img/dashboard-banner.png') }}" alt="Dashboard Banner" class="img-fluid w-100"
					style="object-fit: cover;">
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
					<div class="card card-statistic-1">
						<div class="card-icon bg-primary">
							<i class="far fa-user"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>Total User</h4>
							</div>
							<div class="card-body">
								{{ $total_user }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
					<div class="card card-statistic-1">
						<div class="card-icon bg-primary">
							<i class="far fa-user"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>Total Dosen</h4>
							</div>
							<div class="card-body">
								{{ $total_dosen }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
					<div class="card card-statistic-1">
						<div class="card-icon bg-primary">
							<i class="far fa-user"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4>Total Mahasiswa</h4>
							</div>
							<div class="card-body">
								{{ $total_mahasiswa }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

@push('scripts')
	<!-- JS Libraies -->
	<script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
	<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
	<script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
	<script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
	<script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
	<script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

	<!-- Page Specific JS File -->
	<script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
