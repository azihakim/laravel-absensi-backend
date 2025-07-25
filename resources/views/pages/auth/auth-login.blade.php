@extends('layouts.auth')

@section('title', 'Login')

@push('style')
	<!-- CSS Libraries -->
	<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
	<style>
		.login-container {
			display: flex;
			flex: 1;
			/* Mengisi penuh lebar */
		}

		.login-form {
			flex: 0 0 40%;
			/* Lebar form 30% */
			padding: 40px;
			/* Padding untuk form */
			background-color: #f8f9fa;
			/* Warna latar belakang form */
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			/* Bayangan untuk form */
		}

		.mission-vision {
			flex: 1;
			/* Mengisi sisa layar */
			padding: 40px;
			display: flex;
			justify-content: center;
			/* Rata tengah secara horizontal */
			align-items: center;
			/* Rata tengah secara vertikal */
			background-color: #e9ecef;
			/* Warna latar belakang untuk visi misi */
		}

		h4 {
			margin: 20px 0;
			/* Margin untuk heading */
		}
	</style>
@endpush

@section('main')
	<img src="{{ asset('img/dashboard-banner.png') }}" alt="Dashboard Banner" class="img-fluid w-100"
		style="object-fit: cover;">
	<div class="login-container">
		<div class="login-form">
			<div class="card card-primary">
				<div class="card-header">
					<h4>Login</h4>
				</div>

				<div class="card-body">
					<form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
						@csrf
						<div class="form-group">
							<label for="email">Email</label>
							<input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
								value="{{ old('email') }}" name="email" required tabindex="1">
							@error('email')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>

						<div class="form-group">
							<div class="d-block">
								<label for="password" class="control-label">Password</label>
							</div>
							<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
								required tabindex="2">
							@error('password')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
								Login
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="mission-vision">
			<div>
				<h4>Visi</h4>
				<p>Menjadi perguruan tinggi unggulan dalam membentuk sumber daya manusia di bidang ilmu pengetahuan dan teknologi
					berjiwa entrepreneur di tingkat regional Sumatera Selatan pada tahun 2029.</p>
				<h4>Misi</h4>
				<p>1) Menyediakan lingkungan belajar berkualitas untuk mengembangkan kapasitas pembelajar yang inovatif dan proaktif.
				</p>
				<p>2) Menyelenggarakan penelitian inovatif dan terstruktur pada berbagai bidang ilmu pengetahuan dan teknologi.</p>
				<p>3) Meningkatkan mutu dan kualitas dosen dan tenaga kependidikan.</p>
				<p>4) Menjalin Kerja sama untuk mengembangkan dan melaksanakan tridharma perguruan tinggi.</p>
				<p>5) Mewujudkan tata kelola perguruan tinggi yang akuntabel dan transparan sesuai dengan Good University Governance
					(GUG).</p>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<!-- JS Libraries -->
	<!-- Page Specific JS File -->
@endpush
