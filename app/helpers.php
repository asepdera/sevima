<?php
date_default_timezone_set('Asia/Jakarta');
function hariIndo($N) {
    /* -------------------------------------------------------------------------- */
    /*                       AMBIL HARI BERBAHASA INDONESIA                       */
    /* -------------------------------------------------------------------------- */
    // SECTION AMBIL HARI BERBAHASA INDONESIA
    // SECTION array hari
    $hari   = [
        '1'       => 'Senin', 
        'Selasa', 'Rabu', 'Kamis', 
        'Jumat', 'Sabtu', 'Minggu'
    ];
    // !SECTION array hari
    // NOTE kembalian
    return $hari[$N];
    // !SECTION AMBIL HARI BERBAHASA INDONESIA
}
function tanggalIndoFull($date) {
    /* -------------------------------------------------------------------------- */
    /*                           TANGGAL INDONESIA PENUH                          */
    /* -------------------------------------------------------------------------- */
    // NOTE TANGGAL INDONESIA PENUH
    return hariIndo(date('N', strtotime($date))).', '.tanggalIndo(date('Y-m-d', strtotime($date))).' '.date('H:i', strtotime($date));
}

function tanggalIndo($date) { 
    /* -------------------------------------------------------------------------- */
    /*                              TANGGAL INDONESIA                             */
    /* -------------------------------------------------------------------------- */
    // SECTION TANGGAL INDONESIA
    // SECTION bulan
    $bulan = [
        1 =>   'Januari',
        'Februari', 'Maret','April',
        'Mei', 'Juni', 'Juli',
        'Agustus', 'September', 'Oktober',
        'November', 'Desember'
    ];
    // !SECTION bulan
    // NOTE split
	$split = explode('-', $date);
    // NOTE kembalian
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    // !SECTION TANGGAL INDONESIA
}