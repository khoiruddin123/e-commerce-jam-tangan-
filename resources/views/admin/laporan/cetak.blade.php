<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Omzet - {{ $namaBulan }} {{ $tahun }}</title>
    <!-- Favicon Logo A1ORA -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
        }
        .header p {
            margin: 4px 0 0;
            font-size: 11px;
            color: #64748b;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 12px;
        }
        .summary-box {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .summary-card {
            border: 1px solid #cbd5e1;
            padding: 10px;
            border-radius: 6px;
            background: #f8fafc;
        }
        .summary-card .label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
        }
        .summary-card .val {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            color: #334155;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #334155;
            font-weight: bold;
            padding-top: 4px;
        }
        .no-print {
            margin-bottom: 20px;
            padding: 12px;
            background: #e2e8f0;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background: #4f46e5;
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Cetak (Hanya tampil di layar, tersembunyi saat diprint) -->
    <div class="no-print">
        <div>
            <strong>Pratinjau Cetak Laporan Omzet Bulanan</strong> - Silakan klik cetak atau simpan sebagai PDF.
        </div>
        <div>
            <button onclick="window.print()" class="btn-print">🖨️ Cetak / Simpan PDF</button>
            <button onclick="window.close()" style="margin-left: 6px; padding: 8px 12px; cursor: pointer;">Tutup</button>
        </div>
    </div>

    <!-- Kop Laporan -->
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="A1ORA" style="height: 38px; width: auto; object-fit: contain; margin-bottom: 6px;"><br>
        <p>Sistem Informasi & E-Commerce Jam Tangan Original</p>
        <p><strong>LAPORAN REKAPITULASI OMZET PENJUALAN BULANAN</strong></p>
    </div>

    <!-- Info Meta -->
    <div class="meta-info">
        <div>
            <strong>Periode:</strong> {{ $namaBulan }} {{ $tahun }}<br>
            <strong>Kategori:</strong> {{ $statusFilter === 'sukses' ? 'Pesanan Sah (Masuk Omzet)' : ucfirst($statusFilter) }}
        </div>
        <div style="text-align: right;">
            <strong>Tanggal Cetak:</strong> {{ date('d F Y, H:i') }} WIB<br>
            <strong>Petugas Admin:</strong> {{ Auth::user()->nama ?? 'Admin' }}
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="summary-box">
        <div class="summary-card">
            <div class="label">Total Omzet Bersih</div>
            <div class="val" style="color: #047857;">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Nilai Produk (Subtotal)</div>
            <div class="val">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Jumlah Transaksi</div>
            <div class="val">{{ $totalTransaksi }} Pesanan</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Unit Terjual</div>
            <div class="val">{{ $totalProdukTerjual }} Unit Jam</div>
        </div>
    </div>

    <!-- Tabel Rincian -->
    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 30px;">No</th>
                <th>No. Pesanan</th>
                <th>Tanggal</th>
                <th>Penerima</th>
                <th>Item Produk</th>
                <th>Status</th>
                <th class="text-right">Subtotal</th>
                <th class="text-right">Ongkir</th>
                <th class="text-right">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($semuaPesanan as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold;">{{ $item->nomor_pesanan }}</td>
                    <td>{{ $item->tanggal_pesanan ? $item->tanggal_pesanan->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $item->nama_penerima }} ({{ $item->kota }})</td>
                    <td>
                        @foreach($item->detail as $d)
                            - {{ $d->nama_produk }} ({{ $d->jumlah }}x)<br>
                        @endforeach
                    </td>
                    <td>{{ ucfirst(str_replace('_', ' ', $item->status_pesanan)) }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->ongkir, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: bold;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Tidak ada transaksi pada periode {{ $namaBulan }} {{ $tahun }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($semuaPesanan->isNotEmpty())
            <tfoot>
                <tr style="background: #f8fafc; font-weight: bold;">
                    <td colspan="6" class="text-right">TOTAL KESELURUHAN OMZET:</td>
                    <td class="text-right">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($totalOngkir, 0, ',', '.') }}</td>
                    <td class="text-right" style="color: #047857;">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <p>Surakarta, {{ date('d F Y') }}<br>Penanggung Jawab Toko,</p>
            <div class="signature-line">
                {{ Auth::user()->nama ?? 'Admin Toko' }}<br>
                <span style="font-size: 10px; font-weight: normal; color: #64748b;">Administrator A1ORA Watch</span>
            </div>
        </div>
    </div>

</body>
</html>
