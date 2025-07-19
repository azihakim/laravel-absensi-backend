@extends('layouts.app')

@section('title', 'Edit Profil Perusahaan')

@push('style')
	<!-- CSS Libraries -->
	<link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
	<link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
	<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
	<style>
		#map {
			height: 400px;
		}

		#locationInfo {
			margin-top: 10px;
			font-family: Arial, sans-serif;
		}
	</style>
@endpush

@section('main')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>Edit Kelas</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
					<div class="breadcrumb-item">Edit Kelas</div>
				</div>
			</div>
			<div class="section-body">
				<h2 class="section-title">Edit Kelas</h2>
				<p class="section-lead">
					Perbarui informasi tentang kelas Anda di halaman ini.
				</p>

				<div class="row mt-sm-4">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card">
							<form method="POST" action="{{ route('companies.update', $company->id) }}">
								@csrf
								@method('PUT')
								<div class="card-body">
									<div class="row">
										<div class="form-group col-md-6 col-12">
											<label>Nama Kelas</label>
											<input type="text" name="name" class="form-control" value="{{ $company->name }}">
										</div>
										<div class="form-group col-md-6 col-12">
											<label>Alamat Kelas</label>
											<input type="text" name="address" class="form-control" value="{{ $company->address }}">
										</div>
									</div>
									<div class="col-12">
										<div id="map" style="height: 400px;"></div>
										<a class='btn btn-warning mt-4 mb-4' id="getLocationButton">Dapatkan Lokasi Saya</a>
									</div>
									<div class="row">
										<div class="form-group col-md-6 col-12">
											<label>Latitude</label>
											<input type="text" name="latitude" id="latitude" class="form-control" value="{{ $company->latitude }}">
											<!-- Tambahkan id -->
										</div>
										<div class="form-group col-md-6 col-12">
											<label>Longitude</label>
											<input type="text" name="longitude" id="longitude" class="form-control" value="{{ $company->longitude }}">
											<!-- Tambahkan id -->
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-6 col-12">
											<label>Radius KM</label>
											<input type="number" step="0.01" name="radius_km" class="form-control" value="{{ $company->radius_km }}">
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-6 col-12">
											<label>Is Attendance Type</label>
											<select name="attendance_type" class="form-control" style="height: 40px;">
												<option value="Face" {{ $company->attendance_type == 'Face' ? 'selected' : '' }}>
													Face</option>
												<option value="None" {{ $company->attendance_type == 'None' ? 'selected' : '' }}>
													None</option>
											</select>
										</div>
									</div>
								</div>
								<div class="card-footer text-right">
									<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

@push('scripts')
	<!-- JS Libraries -->
	<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
	<script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
	<script>
		// Inisialisasi peta
		var map = L.map('map').setView([{{ $company->latitude }}, {{ $company->longitude }}],
			13); // Koordinat dari perusahaan yang sedang diedit

		// Tambahkan layer peta
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
		}).addTo(map);

		// Tambahkan marker berdasarkan lokasi yang sudah ada
		var initialMarker = L.marker([{{ $company->latitude }}, {{ $company->longitude }}]).addTo(map)
			.bindPopup("Lokasi Kelas: " + "{{ $company->name }}")
			.openPopup();

		// Event saat klik pada peta
		map.on('click', function(e) {
			var latitude = e.latlng.lat; // Ambil nilai latitude
			var longitude = e.latlng.lng; // Ambil nilai longitude

			// Hapus marker sebelumnya jika ada
			if (window.marker) {
				map.removeLayer(window.marker);
			}

			// Tambahkan marker di lokasi yang diklik
			window.marker = L.marker([latitude, longitude]).addTo(map)
				.bindPopup("Latitude: " + latitude + "<br>Longitude: " + longitude)
				.openPopup();

			// Set value pada inputan latitude dan longitude
			document.getElementById('latitude').value = latitude; // Set latitude ke input
			document.getElementById('longitude').value = longitude; // Set longitude ke input
		});

		// Mendapatkan lokasi pengguna saat tombol diklik
		document.getElementById('getLocationButton').onclick = function() {
			if (navigator.geolocation) {
				// Meminta akses lokasi
				navigator.geolocation.getCurrentPosition(function(position) {
					var latitude = position.coords.latitude; // Ambil latitude pengguna
					var longitude = position.coords.longitude; // Ambil longitude pengguna

					// Arahkan peta ke lokasi pengguna
					map.setView(new L.LatLng(latitude, longitude), 13);
					if (window.marker) {
						map.removeLayer(window.marker); // Hapus marker sebelumnya jika ada
					}
					// Tambahkan marker untuk lokasi pengguna
					window.marker = L.marker([latitude, longitude]).addTo(map)
						.bindPopup("Anda berada di sini").openPopup();

					// Set value pada inputan latitude dan longitude
					document.getElementById('latitude').value = latitude; // Set latitude ke input
					document.getElementById('longitude').value = longitude; // Set longitude ke input
				}, function(error) {
					// Menangani error jika akses lokasi ditolak
					switch (error.code) {
						case error.PERMISSION_DENIED:
							alert("Anda menolak akses lokasi.");
							break;
						case error.POSITION_UNAVAILABLE:
							alert("Posisi tidak tersedia.");
							break;
						case error.TIMEOUT:
							alert("Permintaan lokasi telah timeout.");
							break;
						case error.UNKNOWN_ERROR:
							alert("Kesalahan tidak diketahui.");
							break;
					}
				});
			} else {
				alert("Browser tidak mendukung Geolocation.");
			}
		};
	</script>
	<!-- Page Specific JS File -->
@endpush
