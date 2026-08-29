<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1f2937; }
        h1 { margin: 0; font-size: 18px; }
        p { margin: 5px 0 16px; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #e2e8f0; text-align: left; font-size: 9px; text-transform: uppercase; }
        th, td { border: 1px solid #cbd5e1; padding: 7px; vertical-align: top; }
        .muted { color: #6b7280; font-size: 9px; }
    </style>
</head>
<body>
    <h1>Laporan Karyawan</h1>
    <p>Dicetak pada {{ now()->translatedFormat('d F Y H:i') }} WIB. Total: {{ $employees->count() }} karyawan.</p>
    <table>
        <thead><tr><th>No.</th><th>Kode</th><th>Nama</th><th>Email</th><th>Departemen</th><th>Posisi</th><th>Status</th></tr></thead>
        <tbody>
            @forelse($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td><td>{{ $employee->employee_code }}</td>
                    <td>{{ $employee->name }}</td><td>{{ $employee->email }}</td>
                    <td>{{ $employee->department?->name }}</td><td>{{ $employee->position?->name }}</td>
                    <td>{{ $employee->status === 'active' ? 'Aktif' : 'Non Aktif' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="muted">Tidak ada data karyawan.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
