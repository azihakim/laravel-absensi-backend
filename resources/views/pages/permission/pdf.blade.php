<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title>Surat Izin</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 20px;
		}

		h1 {
			text-align: center;
		}

		.content {
			margin-top: 20px;
		}

		.footer {
			margin-top: 40px;
			text-align: center;
		}
	</style>
</head>

<body>
	<h1>Surat Izin</h1>
	<div class="content">
		<table style="width: 100%; border-collapse: collapse;">
			<tr>
				<td style="width: 30%;"><strong>Nama :</strong></td>
				<td style="width: 70%;">: {{ $permission->user->name }}</td>
			</tr>
			<tr>
				<td><strong>Telpon </strong></td>
				<td>: {{ $permission->user->phone }}</td>
			</tr>
			<tr>
				<td><strong>Tanggal Izin </strong></td>
				<td>: {{ $permission->date_permission }}</td>
			</tr>
			<tr>
				<td><strong>Alasan </strong></td>
				<td>: {{ $permission->reason }}</td>
			</tr>
		</table>

		@if ($permission->image)
			<p><strong>Bukti Dukung:</strong></p>
			<!-- Gunakan URL absolut untuk gambar -->
			<img src="{{ public_path('storage/permissions/' . $permission->image) }}" alt="Bukti Dukung"
				style="max-width: 100%; height: auto;">
		@else
			<p>Tidak ada bukti dukung</p>
		@endif

		<p><strong>Status Persetujuan:</strong> {{ $permission->is_approved ? 'Disetujui' : 'Tidak Disetujui' }}</p>
	</div>
	<div class="footer">
		<p>Terima kasih</p>
	</div>
</body>

</html>
