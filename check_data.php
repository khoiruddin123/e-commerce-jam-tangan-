<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

function printCols($table) {
    echo "=== $table ===\n";
    $cols = DB::select("DESCRIBE $table");
    foreach ($cols as $c) {
        echo "{$c->Field} ({$c->Type}) " . ($c->Null == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
    }
}

printCols('kategori');
printCols('produk');
printCols('varian_produk');
printCols('galeri_produk');
printCols('pesanan');
printCols('detail_pesanan');
printCols('pengiriman');
printCols('pembayaran');
