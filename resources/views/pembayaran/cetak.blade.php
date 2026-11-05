<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran #{{ $pesanan->nomor_pesanan }} - A1ORA Watch</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            padding-bottom: 40px;
        }

        /* Top Action Bar (Hanya tampil di layar, otomatis disembunyikan saat cetak) */
        .top-action-bar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.05);
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 9999px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
        }
        .btn-print {
            background: #0f172a;
            color: #ffffff;
        }
        .btn-print:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }
        .btn-close-doc {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #cbd5e1;
        }
        .btn-close-doc:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        /* Lembar Kuitansi Fisik A4 */
        .sheet-wrapper {
            max-width: 820px;
            margin: 28px auto;
            background: #ffffff;
            padding: 45px 50px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        /* CSS khusus saat dicetak / disimpan sebagai PDF */
        @page {
            size: A4 portrait;
            margin: 10mm 12mm;
        }
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .sheet-wrapper {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                border-radius: 0 !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Bar Navigasi Aksi Cetak (Disembunyikan saat dicetak) -->
    <div class="top-action-bar no-print">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('pembayaran.sukses', $pesanan->pesanan_id) }}" class="action-btn btn-close-doc">
                <i class="bi bi-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <span style="font-size: 13px; color: #64748b;">
                Bukti Pembayaran Resmi: <strong style="color: #0f172a;">#{{ $pesanan->nomor_pesanan }}</strong>
            </span>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 12px; color: #10b981; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                <i class="bi bi-info-circle"></i> Pilih "Save as PDF" di dialog cetak untuk mengunduh berkas
            </span>
            <button onclick="window.print()" class="action-btn btn-print">
                <i class="bi bi-printer-fill" style="color: #38bdf8;"></i>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    @php
        $nomorCoa = 'KW-COA-' . strtoupper(substr(md5($pesanan->nomor_pesanan), 0, 4)) . '-' . strtoupper(substr($pesanan->nomor_pesanan, -3));
    @endphp

    <!-- Lembar Dokumen Kuitansi Resmi -->
    <div class="sheet-wrapper">
        
        <!-- Header Dokumen Butik -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 22px; border-bottom: 2px solid #0f172a;">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="A1ORA Watch" style="height: 44px; width: auto; object-fit: contain; margin-bottom: 8px;">
                <div style="font-size: 11px; font-weight: 800; letter-spacing: 1.5px; color: #0f172a; text-transform: uppercase;">A1ORA WATCH BOUTIQUE & HOROLOGY</div>
                <div style="font-size: 11px; color: #64748b; line-height: 1.45; margin-top: 3px;">
                    Plaza Senayan Level 3, Jakarta Pusat, Indonesia<br>
                    Layanan Pelanggan: concierge@a1orawatch.id | +62 21 5790 0123
                </div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 20px; font-weight: 800; letter-spacing: -0.5px; color: #0f172a;">BUKTI PEMBAYARAN RESMI</div>
                <div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px;">OFFICIAL PAYMENT RECEIPT</div>
                <div style="margin-top: 10px; display: inline-block; background: #ecfdf5; border: 1.5px solid #10b981; color: #065f46; font-size: 11px; font-weight: 800; padding: 4px 14px; border-radius: 999px; letter-spacing: 0.5px;">
                    ✓ LUNAS & TERVERIFIKASI
                </div>
            </div>
        </div>

        <!-- Informasi Pemesan & Transaksi (Grid 2 Kolom) -->
        <div style="display: flex; justify-content: space-between; margin-top: 24px; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
            <!-- Kolom Pemesan / Penerima -->
            <div style="width: 48%;">
                <div style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 6px;">DITERBITKAN KEPADA</div>
                <div style="font-size: 14px; font-weight: 700; color: #0f172a;">{{ $pesanan->nama_penerima }}</div>
                <div style="font-size: 12px; color: #475569; margin-top: 3px;">Telepon: <strong>{{ $pesanan->telepon_penerima }}</strong></div>
                <div style="font-size: 12px; color: #64748b; margin-top: 5px; line-height: 1.45;">
                    {{ $pesanan->alamat_pengiriman }}<br>
                    {{ $pesanan->kota }} - {{ $pesanan->kode_pos ?? '' }}
                </div>
            </div>

            <!-- Kolom Transaksi Finansial -->
            <div style="width: 48%; border-left: 1px dashed #cbd5e1; padding-left: 20px;">
                <div style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 6px;">INFORMASI TRANSAKSI</div>
                <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                    <tr>
                        <td style="color: #64748b; padding: 3px 0;">Nomor Pesanan</td>
                        <td style="text-align: right; font-weight: 800; font-family: monospace; color: #0f172a;">#{{ $pesanan->nomor_pesanan }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 3px 0;">Waktu Pembayaran</td>
                        <td style="text-align: right; font-weight: 600; color: #0f172a;">
                            {{ $pesanan->pembayaran?->waktu_pembayaran ? $pesanan->pembayaran->waktu_pembayaran->translatedFormat('d F Y, H:i') : now()->translatedFormat('d F Y, H:i') }} WIB
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 3px 0;">Metode Pembayaran</td>
                        <td style="text-align: right; font-weight: 700; color: #0f172a;">{{ $pesanan->pembayaran?->metode_pembayaran ?? 'BCA Virtual Account' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 3px 0;">Kode Referensi</td>
                        <td style="text-align: right; font-weight: 700; font-family: monospace; color: #0f172a;">{{ $pesanan->pembayaran?->nomor_referensi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; padding: 3px 0;">Status Transaksi</td>
                        <td style="text-align: right; font-weight: 800; color: #059669;">Lunas (Tervalidasi)</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tabel Rincian Jam Tangan -->
        <div style="margin-top: 24px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                <thead>
                    <tr style="background: #0f172a; color: #ffffff;">
                        <th style="padding: 10px 12px; text-align: center; border-radius: 8px 0 0 0; width: 40px; font-weight: 700;">No</th>
                        <th style="padding: 10px 12px; text-align: left; font-weight: 700;">Model Jam Tangan</th>
                        <th style="padding: 10px 12px; text-align: left; font-weight: 700;">Varian & SKU</th>
                        <th style="padding: 10px 12px; text-align: center; width: 50px; font-weight: 700;">Qty</th>
                        <th style="padding: 10px 12px; text-align: right; width: 130px; font-weight: 700;">Harga Satuan</th>
                        <th style="padding: 10px 12px; text-align: right; border-radius: 0 8px 0 0; width: 130px; font-weight: 700;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanan->detail as $index => $item)
                        <tr style="border-bottom: 1px solid #e2e8f0; background: {{ $index % 2 === 0 ? '#ffffff' : '#f8fafc' }};">
                            <td style="padding: 12px; text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                            <td style="padding: 12px; font-weight: 700; color: #0f172a;">{{ $item->nama_produk }}</td>
                            <td style="padding: 12px; color: #475569;">
                                <div>{{ $item->nama_varian }}</div>
                                <div style="font-size: 10px; color: #94a3b8; font-family: monospace;">SKU: {{ $item->kode_sku }}</div>
                            </td>
                            <td style="padding: 12px; text-align: center; font-weight: 600; color: #0f172a;">{{ $item->jumlah }}</td>
                            <td style="padding: 12px; text-align: right; color: #475569;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td style="padding: 12px; text-align: right; font-weight: 700; color: #0f172a;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Perhitungan Biaya (Kanan Bawah) -->
        <div style="display: flex; justify-content: flex-end; margin-top: 18px;">
            <div style="width: 340px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px;">
                <div style="display: flex; justify-content: space-between; font-size: 12px; color: #64748b; margin-bottom: 8px;">
                    <span>Subtotal Produk</span>
                    <span style="font-weight: 600; color: #0f172a;">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 12px; color: #64748b; margin-bottom: 8px;">
                    <span>Ongkos Kirim (Asuransi Penuh)</span>
                    <span style="font-weight: 600; color: #0f172a;">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 12px; color: #64748b; margin-bottom: 12px;">
                    <span>Biaya Layanan & VA</span>
                    <span style="font-weight: 700; color: #10b981;">GRATIS</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 2px solid #0f172a; padding-top: 10px;">
                    <div>
                        <div style="font-size: 13px; font-weight: 800; color: #0f172a; text-transform: uppercase;">Total Pembayaran</div>
                        <div style="font-size: 10px; color: #10b981; font-weight: 700;">STATUS: LUNAS (PAID)</div>
                    </div>
                    <div style="font-size: 18px; font-weight: 800; color: #059669; letter-spacing: -0.5px;">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Garansi Resmi & Sertifikat Keaslian -->
        <div style="margin-top: 24px; padding: 14px 18px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 11px; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 0.5px;">
                    JAMINAN KEASLIAN 100% & GARANSI RESMI 2 TAHUN
                </div>
                <div style="font-size: 11px; color: #15803d; margin-top: 2px;">
                    Dilindungi sertifikat keaslian digital A1ORA COA & garansi mesin internasional resmi.
                </div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 10px; color: #166534; font-weight: 600;">Nomor Seri Digital COA:</div>
                <div style="font-size: 12px; font-weight: 800; font-family: monospace; color: #0f172a;">{{ $nomorCoa }}</div>
            </div>
        </div>

        <!-- Catatan Penutup & Stempel Digital Resmi -->
        <div style="margin-top: 26px; padding-top: 18px; border-top: 1px dashed #cbd5e1; display: flex; justify-content: space-between; align-items: flex-end;">
            <div style="font-size: 10px; color: #94a3b8; line-height: 1.5; max-width: 520px;">
                * Kuitansi elektronik ini merupakan bukti transaksi yang sah dan diterbitkan otomatis oleh sistem A1ORA Watch tanpa memerlukan tanda tangan basah.<br>
                * Simpan bukti ini untuk keperluan klaim garansi, servis resmi butik, atau penukaran unit sesuai ketentuan berlaku.<br>
                * Waktu Cetak Dokumen: {{ now()->translatedFormat('d F Y, H:i:s') }} WIB
            </div>
            <div style="text-align: center; border: 1.5px solid #0f172a; padding: 6px 14px; border-radius: 8px; background: #ffffff;">
                <div style="font-size: 9px; font-weight: 800; letter-spacing: 1px; color: #0f172a; text-transform: uppercase;">A1ORA WATCH</div>
                <div style="font-size: 8px; font-weight: 700; color: #10b981;">OFFICIAL RECEIPT</div>
                <div style="font-size: 8px; color: #64748b; font-family: monospace;">VERIFIED SECURE</div>
            </div>
        </div>

    </div>

    <!-- Otomatis buka dialog cetak jika parameter print=1 diberikan -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (new URLSearchParams(window.location.search).get('print') === '1') {
                setTimeout(function () {
                    window.print();
                }, 300);
            }
        });
    </script>
</body>
</html>

