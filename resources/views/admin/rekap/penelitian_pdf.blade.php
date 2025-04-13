<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Penelitian</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; font-size: 12px; }
        th { background-color: #f2f2f2; text-align: center; } /* Header tabel rata tengah */
    </style>
</head>
<body>
    <h3 style="text-align: center;">Rekap Penelitian</h3>

    {{-- Menampilkan Semester yang Dipilih --}}
    @if(request('semester'))
        <p style="text-align: left; font-weight: bold;">Semester: {{ request('semester') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Penelitian</th>
                <th>Nama Ketua Tim</th>
                <th>Kepakaran Ketua Tim</th>
                <th>Nama dan Identitas Dosen Anggota</th>
                <th>Nama dan Identitas Mahasiswa yang Dilibatkan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penelitian as $item)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->ketuaDosen->nama ?? '-' }}</td>
                    <td>{{ $item->keahlian_ketua }}</td>
                    <td>
                        @if ($item->anggotaPenelitian->where('anggota_type', 'Dosen')->isNotEmpty())
                            @foreach ($item->anggotaPenelitian->where('anggota_type', 'Dosen') as $anggota)
                                <div>{{ $anggota->dosen->nama ?? 'Nama Tidak Ditemukan' }} 
                                    ({{ $anggota->dosen->nip ?? '-' }})
                                </div>
                            @endforeach
                        @else
                            Tidak ada dosen
                        @endif
                    </td>
                    <td>
                        @if ($item->anggotaPenelitian->where('anggota_type', 'Mahasiswa')->isNotEmpty())
                            @foreach ($item->anggotaPenelitian->where('anggota_type', 'Mahasiswa') as $anggota)
                                <div>{{ $anggota->mahasiswa->nama ?? 'Nama Tidak Ditemukan' }} 
                                    ({{ $anggota->mahasiswa->nim ?? '-' }})
                                </div>
                            @endforeach
                        @else
                            Tidak ada mahasiswa
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>