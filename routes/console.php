<?php

use App\Models\Pesanan;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwal otomatisasi pembatalan pesanan yang melewati batas waktu pembayaran
Schedule::call(function () {
    Pesanan::batalkanPesananKedaluwarsa();
})->everyMinute();
