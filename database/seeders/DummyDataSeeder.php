<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori Produk Jam Tangan (Sesuai Mockup & Dokumen)
        $kategoriList = [
            ['nama_kategori' => 'Chronograph Master', 'deskripsi' => 'Presisi tinggi dengan fungsi stopwatch terintegrasi & tachymeter.'],
            ['nama_kategori' => 'Automatic Calibre', 'deskripsi' => 'Gerakan mekanik self-winding bertenaga rotor kinetik Swiss/Jepang.'],
            ['nama_kategori' => 'Diver & Marine Instrument', 'deskripsi' => 'Ketahanan air 200M+ dengan bezel berputar satu arah & jarum fosfor.'],
            ['nama_kategori' => 'Dress & Haute Horlogerie', 'deskripsi' => 'Desain ramping ultra-tipis, strap kulit buaya, dan dial minimalis mewah.'],
            ['nama_kategori' => 'Smart Connected Series', 'deskripsi' => 'Modul hibrida mewah dengan sensor biometrik & konektivitas pintar.'],
        ];

        foreach ($kategoriList as $kat) {
            DB::table('kategori')->updateOrInsert(
                ['nama_kategori' => $kat['nama_kategori']],
                ['deskripsi' => $kat['deskripsi']]
            );
        }

        $idChronograph = DB::table('kategori')->where('nama_kategori', 'Chronograph Master')->value('kategori_id');
        $idAutomatic   = DB::table('kategori')->where('nama_kategori', 'Automatic Calibre')->value('kategori_id');
        $idDiver       = DB::table('kategori')->where('nama_kategori', 'Diver & Marine Instrument')->value('kategori_id');
        $idDress       = DB::table('kategori')->where('nama_kategori', 'Dress & Haute Horlogerie')->value('kategori_id');

        $idRolex = DB::table('merek')->where('nama_merek', 'Rolex')->value('merek_id') ?? 2;
        $idOmega = DB::table('merek')->where('nama_merek', 'Omega')->value('merek_id') ?? 3;
        $idSeiko = DB::table('merek')->where('nama_merek', 'Seiko')->value('merek_id') ?? 6;

        // 2. Produk Jam Tangan
        $produkData = [
            [
                'kategori_id' => $idChronograph,
                'merek_id' => $idOmega,
                'nama_produk' => 'Kronos Chrono Master Pro 42mm',
                'kode_produk' => 'KW-CHRONO-42',
                'deskripsi' => 'Timepiece chronograph mewah dengan kaliber otomatis 7750, bezel keramik tahan gores, dan dial sunray elegan.',
                'spesifikasi' => 'Diameter: 42mm, Case: Stainless Steel 316L, Kaca: Safir Anti-Reflektif, Power Reserve: 48 Jam.',
                'status_produk' => 'aktif',
            ],
            [
                'kategori_id' => $idDiver,
                'merek_id' => $idRolex,
                'nama_produk' => 'Kronos Oceanic Heritage Diver 300M',
                'kode_produk' => 'KW-DIVER-300',
                'deskripsi' => 'Arloji selam profesional dengan sertifikasi ISO 6425, helium escape valve, dan luminova jarum berdaya tahan tinggi.',
                'spesifikasi' => 'Water Resistant: 300M, Bezel: Keramik Unidirectional 120 Klik, Tali: Oyster Steel & Karet NBR.',
                'status_produk' => 'aktif',
            ],
            [
                'kategori_id' => $idDress,
                'merek_id' => $idOmega,
                'nama_produk' => 'Kronos Grand Classic Moonphase 40mm',
                'kode_produk' => 'KW-MOON-40',
                'deskripsi' => 'Keanggunan horologi klasik menampilkan komplikasi fase bulan astronomis dan strap kulit buaya premium Italia.',
                'spesifikasi' => 'Ketebalan: 9.8mm, Dial: Enamel Putih Salju, Caseback: Pameran Kristal Safir Transparan.',
                'status_produk' => 'aktif',
            ],
            [
                'kategori_id' => $idAutomatic,
                'merek_id' => $idSeiko,
                'nama_produk' => 'Seiko 5 Sports Stealth Mechanical',
                'kode_produk' => 'KW-SEIKO-5S',
                'deskripsi' => 'Jam tangan mekanikal modern tangguh untuk gaya kasual dan petualangan harian dengan kaliber 4R36.',
                'spesifikasi' => 'Kaliber: 4R36 24 Jewels, Tahan Guncang: Diashock, Tali: Nylon NATO Hitam & Gelang Baja.',
                'status_produk' => 'aktif',
            ],
        ];

        foreach ($produkData as $p) {
            DB::table('produk')->updateOrInsert(
                ['kode_produk' => $p['kode_produk']],
                array_merge($p, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // 3. Varian Produk
        $p1 = DB::table('produk')->where('kode_produk', 'KW-CHRONO-42')->value('produk_id');
        $p2 = DB::table('produk')->where('kode_produk', 'KW-DIVER-300')->value('produk_id');
        $p3 = DB::table('produk')->where('kode_produk', 'KW-MOON-40')->value('produk_id');
        $p4 = DB::table('produk')->where('kode_produk', 'KW-SEIKO-5S')->value('produk_id');

        $varianList = [
            // Varian P1 (Chrono Master Pro)
            [
                'produk_id' => $p1,
                'nama_varian' => 'Steel Bracelet - Midnight Black',
                'kode_sku' => 'SKU-CHR-01',
                'warna' => 'Hitam Pekat',
                'bahan_tali' => 'Oyster Steel 316L',
                'harga_varian' => 28500000.00,
                'stok' => 12,
                'status_varian' => 'aktif',
            ],
            [
                'produk_id' => $p1,
                'nama_varian' => 'Alligator Leather - Navy Blue',
                'kode_sku' => 'SKU-CHR-02',
                'warna' => 'Navy Sunray',
                'bahan_tali' => 'Kulit Aligator Asli',
                'harga_varian' => 29200000.00,
                'stok' => 8,
                'status_varian' => 'aktif',
            ],

            // Varian P2 (Diver 300M)
            [
                'produk_id' => $p2,
                'nama_varian' => 'Ceramic Bezel - Deep Ocean Blue',
                'kode_sku' => 'SKU-DIV-01',
                'warna' => 'Biru Laut Dalam',
                'bahan_tali' => 'Stainless Steel',
                'harga_varian' => 24120000.00,
                'stok' => 5,
                'status_varian' => 'aktif',
            ],
            [
                'produk_id' => $p2,
                'nama_varian' => 'Rubber Tropic - Emerald Green',
                'kode_sku' => 'SKU-DIV-02',
                'warna' => 'Hijau Zamrud',
                'bahan_tali' => 'Karet NBR Tahan Garam',
                'harga_varian' => 22800000.00,
                'stok' => 6,
                'status_varian' => 'aktif',
            ],

            // Varian P3 (Moonphase)
            [
                'produk_id' => $p3,
                'nama_varian' => 'Rose Gold Case - Cognac Leather',
                'kode_sku' => 'SKU-MOON-01',
                'warna' => 'Putih Gading & Emas',
                'bahan_tali' => 'Kulit Cokelat Premium',
                'harga_varian' => 44500000.00,
                'stok' => 4,
                'status_varian' => 'aktif',
            ],

            // Varian P4 (Seiko 5)
            [
                'produk_id' => $p4,
                'nama_varian' => 'Stealth Edition - NATO Strap',
                'kode_sku' => 'SKU-SEI-01',
                'warna' => 'Matte Black',
                'bahan_tali' => 'Nylon NATO Balistik',
                'harga_varian' => 3850000.00,
                'stok' => 20,
                'status_varian' => 'aktif',
            ],
        ];

        foreach ($varianList as $v) {
            DB::table('varian_produk')->updateOrInsert(
                ['kode_sku' => $v['kode_sku']],
                $v
            );
        }

        // Ambil User Pelanggan ID
        $userPelanggan = DB::table('users')->where('username', 'firaas')->first();
        $userIrul = DB::table('users')->where('username', 'irul')->first();

        $userIdFiraas = $userPelanggan ? $userPelanggan->user_id : 2;
        $userIdIrul   = $userIrul ? $userIrul->user_id : 3;

        // Ambil ID Varian untuk Detail Pesanan
        $vChrono1 = DB::table('varian_produk')->where('kode_sku', 'SKU-CHR-01')->first();
        $vDiver1  = DB::table('varian_produk')->where('kode_sku', 'SKU-DIV-01')->first();
        $vMoon1   = DB::table('varian_produk')->where('kode_sku', 'SKU-MOON-01')->first();
        $vSeiko1  = DB::table('varian_produk')->where('kode_sku', 'SKU-SEI-01')->first();

        // Bersihkan data pesanan lama dummy jika ada agar rapi
        DB::table('pesanan')->where('nomor_pesanan', 'like', 'KW-TEST-%')->delete();

        // 4. PESANAN DUMMY LENGKAP DENGAN BERBAGAI SIKLUS STATUS

        // =========================================================================
        // Pesanan 1: STATUS 'dikirim' (Firaas)
        // Tujuan: Admin melihat "Resi Terkunci", Pelanggan melihat tombol "Pesanan Diterima"
        // =========================================================================
        $noPesanan1 = 'KW-TEST-KIRIM';
        $subtotal1 = (float) $vChrono1->harga_varian;
        $ongkir1 = 25000.00;
        $total1 = $subtotal1 + $ongkir1;

        $pId1 = DB::table('pesanan')->insertGetId([
            'nomor_pesanan' => $noPesanan1,
            'user_id' => $userIdFiraas,
            'tanggal_pesanan' => Carbon::now()->subDays(2),
            'nama_penerima' => 'Firaas Javier Andika',
            'telepon_penerima' => '089876543210',
            'alamat_pengiriman' => 'Jl. Slamet Riyadi No. 120, Laweyan',
            'kota' => 'Surakarta',
            'kode_pos' => '57141',
            'subtotal' => $subtotal1,
            'ongkir' => $ongkir1,
            'total_harga' => $total1,
            'status_pesanan' => 'dikirim',
            'catatan' => 'Bungkus kotak kayu eksklusif berstempel Kronos Care.',
        ]);

        DB::table('detail_pesanan')->insert([
            'pesanan_id' => $pId1,
            'varian_id' => $vChrono1->varian_id,
            'nama_produk' => 'Kronos Chrono Master Pro 42mm',
            'nama_varian' => $vChrono1->nama_varian,
            'kode_sku' => $vChrono1->kode_sku,
            'harga_satuan' => $vChrono1->harga_varian,
            'jumlah' => 1,
            'subtotal' => $subtotal1,
        ]);

        DB::table('pembayaran')->insert([
            'pesanan_id' => $pId1,
            'metode_pembayaran' => 'BCA Virtual Account',
            'nomor_referensi' => 'KW-BAYAR-BCA991',
            'jumlah_bayar' => $total1,
            'waktu_pembayaran' => Carbon::now()->subDays(2)->addHour(),
            'batas_pembayaran' => Carbon::now()->subDays(2)->addHours(3),
            'status_pembayaran' => 'berhasil',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        DB::table('pengiriman')->insert([
            'pesanan_id' => $pId1,
            'nama_kurir' => 'JNE Express (YES)',
            'layanan_pengiriman' => 'Yakin Esok Sampai',
            'nomor_resi' => 'JNE88291049281',
            'tanggal_dikirim' => Carbon::now()->subDay(),
            'tanggal_diterima' => null, // Belum diterima pembeli!
            'updated_at' => Carbon::now()->subDay(),
        ]);


        // =========================================================================
        // Pesanan 2: STATUS 'diproses' (Firaas)
        // Tujuan: Admin bisa mencoba Input Resi, edit resi, dan tandai dikirim
        // =========================================================================
        $noPesanan2 = 'KW-TEST-PROSES';
        $subtotal2 = (float) $vDiver1->harga_varian;
        $ongkir2 = 25000.00;
        $total2 = $subtotal2 + $ongkir2;

        $pId2 = DB::table('pesanan')->insertGetId([
            'nomor_pesanan' => $noPesanan2,
            'user_id' => $userIdFiraas,
            'tanggal_pesanan' => Carbon::now()->subHours(6),
            'nama_penerima' => 'Firaas Javier Andika',
            'telepon_penerima' => '089876543210',
            'alamat_pengiriman' => 'Kawasan Butik Solo Baru Sektor 1A',
            'kota' => 'Sukoharjo',
            'kode_pos' => '57552',
            'subtotal' => $subtotal2,
            'ongkir' => $ongkir2,
            'total_harga' => $total2,
            'status_pesanan' => 'diproses',
            'catatan' => 'QC kartu garansi internasional dan sertifikat COA.',
        ]);

        DB::table('detail_pesanan')->insert([
            'pesanan_id' => $pId2,
            'varian_id' => $vDiver1->varian_id,
            'nama_produk' => 'Kronos Oceanic Heritage Diver 300M',
            'nama_varian' => $vDiver1->nama_varian,
            'kode_sku' => $vDiver1->kode_sku,
            'harga_satuan' => $vDiver1->harga_varian,
            'jumlah' => 1,
            'subtotal' => $subtotal2,
        ]);

        DB::table('pembayaran')->insert([
            'pesanan_id' => $pId2,
            'metode_pembayaran' => 'Mandiri Virtual Account',
            'nomor_referensi' => 'KW-BAYAR-MDR882',
            'jumlah_bayar' => $total2,
            'waktu_pembayaran' => Carbon::now()->subHours(5),
            'batas_pembayaran' => Carbon::now()->subHours(3),
            'status_pembayaran' => 'berhasil',
            'created_at' => Carbon::now()->subHours(6),
        ]);


        // =========================================================================
        // Pesanan 3: STATUS 'selesai' (Firaas)
        // Tujuan: Pembeli bisa mencoba fitur "Beri Ulasan", Admin melihat rekap omzet
        // =========================================================================
        $noPesanan3 = 'KW-TEST-SELESAI';
        $subtotal3 = (float) $vSeiko1->harga_varian;
        $ongkir3 = 25000.00;
        $total3 = $subtotal3 + $ongkir3;

        $pId3 = DB::table('pesanan')->insertGetId([
            'nomor_pesanan' => $noPesanan3,
            'user_id' => $userIdFiraas,
            'tanggal_pesanan' => Carbon::now()->subDays(5),
            'nama_penerima' => 'Firaas Javier Andika',
            'telepon_penerima' => '089876543210',
            'alamat_pengiriman' => 'Jl. Slamet Riyadi No. 120, Laweyan',
            'kota' => 'Surakarta',
            'kode_pos' => '57141',
            'subtotal' => $subtotal3,
            'ongkir' => $ongkir3,
            'total_harga' => $total3,
            'status_pesanan' => 'selesai',
            'catatan' => 'Selesai diantar oleh kurir SiCepat dan telah dikonfirmasi penerima.',
        ]);

        $detailId3 = DB::table('detail_pesanan')->insertGetId([
            'pesanan_id' => $pId3,
            'varian_id' => $vSeiko1->varian_id,
            'nama_produk' => 'Seiko 5 Sports Stealth Mechanical',
            'nama_varian' => $vSeiko1->nama_varian,
            'kode_sku' => $vSeiko1->kode_sku,
            'harga_satuan' => $vSeiko1->harga_varian,
            'jumlah' => 1,
            'subtotal' => $subtotal3,
        ]);

        DB::table('pembayaran')->insert([
            'pesanan_id' => $pId3,
            'metode_pembayaran' => 'QRIS Simulasi',
            'nomor_referensi' => 'KW-BAYAR-QRS301',
            'jumlah_bayar' => $total3,
            'waktu_pembayaran' => Carbon::now()->subDays(5)->addMinutes(30),
            'batas_pembayaran' => Carbon::now()->subDays(5)->addHours(2),
            'status_pembayaran' => 'berhasil',
            'created_at' => Carbon::now()->subDays(5),
        ]);

        DB::table('pengiriman')->insert([
            'pesanan_id' => $pId3,
            'nama_kurir' => 'SiCepat Reguler',
            'layanan_pengiriman' => 'Reguler 2-3 Hari',
            'nomor_resi' => 'SIC9988219001',
            'tanggal_dikirim' => Carbon::now()->subDays(4),
            'tanggal_diterima' => Carbon::now()->subDay(), // Selesai diterima
            'updated_at' => Carbon::now()->subDay(),
        ]);


        // =========================================================================
        // Pesanan 4: STATUS 'dibayar' (Irul)
        // Tujuan: Pesanan baru yang sudah lunas verifikasi, siap dimasukkan ke antrean QC
        // =========================================================================
        $noPesanan4 = 'KW-TEST-DIBAYAR';
        $subtotal4 = (float) $vMoon1->harga_varian;
        $ongkir4 = 25000.00;
        $total4 = $subtotal4 + $ongkir4;

        $pId4 = DB::table('pesanan')->insertGetId([
            'nomor_pesanan' => $noPesanan4,
            'user_id' => $userIdIrul,
            'tanggal_pesanan' => Carbon::now()->subHours(1),
            'nama_penerima' => 'Khoiruddin Subhi (Irul)',
            'telepon_penerima' => '081299887766',
            'alamat_pengiriman' => 'Jl. Veteran No. 45, Serengan',
            'kota' => 'Surakarta',
            'kode_pos' => '57155',
            'subtotal' => $subtotal4,
            'ongkir' => $ongkir4,
            'total_harga' => $total4,
            'status_pesanan' => 'dibayar',
            'catatan' => 'Pesanan kolektor butik lunas via BCA VA.',
        ]);

        DB::table('detail_pesanan')->insert([
            'pesanan_id' => $pId4,
            'varian_id' => $vMoon1->varian_id,
            'nama_produk' => 'Kronos Grand Classic Moonphase 40mm',
            'nama_varian' => $vMoon1->nama_varian,
            'kode_sku' => $vMoon1->kode_sku,
            'harga_satuan' => $vMoon1->harga_varian,
            'jumlah' => 1,
            'subtotal' => $subtotal4,
        ]);

        DB::table('pembayaran')->insert([
            'pesanan_id' => $pId4,
            'metode_pembayaran' => 'BCA Virtual Account',
            'nomor_referensi' => 'KW-BAYAR-BCA774',
            'jumlah_bayar' => $total4,
            'waktu_pembayaran' => Carbon::now()->subMinutes(45),
            'batas_pembayaran' => Carbon::now()->addHours(2),
            'status_pembayaran' => 'berhasil',
            'created_at' => Carbon::now()->subHours(1),
        ]);


        // =========================================================================
        // Pesanan 5: STATUS 'menunggu_pembayaran' (Firaas)
        // Tujuan: Menguji formulir pembayaran simulasi kode dan countdown
        // =========================================================================
        $noPesanan5 = 'KW-TEST-MENUNGGU';
        $subtotal5 = (float) $vChrono1->harga_varian;
        $ongkir5 = 25000.00;
        $total5 = $subtotal5 + $ongkir5;

        $pId5 = DB::table('pesanan')->insertGetId([
            'nomor_pesanan' => $noPesanan5,
            'user_id' => $userIdFiraas,
            'tanggal_pesanan' => Carbon::now()->subMinutes(15),
            'nama_penerima' => 'Firaas Javier Andika',
            'telepon_penerima' => '089876543210',
            'alamat_pengiriman' => 'Jl. Slamet Riyadi No. 120, Laweyan',
            'kota' => 'Surakarta',
            'kode_pos' => '57141',
            'subtotal' => $subtotal5,
            'ongkir' => $ongkir5,
            'total_harga' => $total5,
            'status_pesanan' => 'menunggu_pembayaran',
            'catatan' => 'Menunggu verifikasi pembayaran kode acak.',
        ]);

        DB::table('detail_pesanan')->insert([
            'pesanan_id' => $pId5,
            'varian_id' => $vChrono1->varian_id,
            'nama_produk' => 'Kronos Chrono Master Pro 42mm',
            'nama_varian' => $vChrono1->nama_varian,
            'kode_sku' => $vChrono1->kode_sku,
            'harga_satuan' => $vChrono1->harga_varian,
            'jumlah' => 1,
            'subtotal' => $subtotal5,
        ]);

        DB::table('pembayaran')->insert([
            'pesanan_id' => $pId5,
            'metode_pembayaran' => 'Simulasi Transfer Virtual',
            'nomor_referensi' => 'KW-BAYAR-TEST99',
            'jumlah_bayar' => $total5,
            'waktu_pembayaran' => null,
            'batas_pembayaran' => Carbon::now()->addHours(2),
            'status_pembayaran' => 'menunggu',
            'created_at' => Carbon::now()->subMinutes(15),
        ]);

        echo ">>> SEEDING DUMMY DATA BERHASIL DILAKUKAN! <<<\n";
    }
}
