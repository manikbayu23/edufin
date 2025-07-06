@extends('layouts.main')
@section('title', content: 'Guide')
@section('content')

    <!-- Intro -->
    <div class="container text-center my-5">
        <h2>Edu Guide</h2>
        <p class="mt-3">Panduan lengkap untuk memahami layanan pinjaman pendidikan EduFin secara mudah, bijak, dan
            terstruktur.</p>
        <div class="alert alert-warning alert-center text-center">
            <strong>Bijak Meminjam!</strong><br>
            Pinjaman adalah tanggung jawab pribadi.<br>
            Pahami kebutuhan dan kemampuan finansialmu sebelum mengajukan pinjaman.<br>
            EduFin hadir untuk membantumu, bukan membebanimu.
        </div>
    </div>

    <!-- Syarat Pinjaman -->
    <div class="container my-5">
        <h4 class="fw-bold mb-4">Syarat Peminjaman EduFin</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="card-checklist">
                    <h5>Syarat Wajib</h5>
                    <ol>
                        <li>Minimal usia 21 s/d 60 tahun saat mengajukan hingga pinjaman lunas</li>
                        <li>Memiliki KTP dan WNI</li>
                        <li>Memiliki rekening bank atas nama pribadi untuk pencairan dan pembayaran</li>
                        <li>Anak yang dibiayai sedang aktif bersekolah di institusi pendidikan formal (perguruan tinggi) di
                            Indonesia</li>
                        <li>Melampirkan dokumen bukti tagihan sekolah atau slip SPP terbaru sebagai bukti kebutuhan biaya
                            pendidikan.</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-checklist">
                    <h5>Dokumen Pendukung</h5>
                    <ol>
                        <li>Foto/scan KTP peminjam (orang tua/wali)</li>
                        <li>Foto/scan Kartu Keluarga (KK) yang mencantumkan nama anak</li>
                        <li>Bukti tagihan biaya pendidikan anak (misalnya slip UKT, atau surat keterangan biaya dari
                            institusi pendidikan)</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Cara Bayar -->
        <div id="carabayar" class="section container">
            <h3 class="mb-4">Cara Bayar</h3>
            <ol>
                <li>Login ke akun EduFin</li>
                <li>Pilih Menu → Tagihan</li>
                <li>Pilih tagihan dengan status Cicilan</li>
                <li>Pilih satu atau lebih tagihan yang akan dibayar</li>
                <li>Klik "Bayar" dan pilih metode pembayaran</li>
                <li>Salin nomor virtual account dan lakukan pembayaran</li>
                <li>Klik "Cek Status Pembayaran" untuk memastikan</li>
            </ol>
            <div class="mt-4">
                <h5>Pilihan Bank</h5>
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <img src="{{ asset('assets/images/bni.jpg') }}" alt="BNI" style="width: 120px;">
                    <img src="{{ asset('assets/images/bri.jpg') }}" alt="BRI" style="width: 100px;">
                    <img src="{{ asset('assets/images/mandiri.jpg') }}" alt="Mandiri" style="width: 120px;">
                    <img src="{{ asset('assets/images/bpd.jpg') }}" alt="BPD" style="width: 120px;">
                    <img src="{{ asset('assets/images/bca.jpg') }}" alt="BCA" style="width: 120px;">
                </div>
            </div>
        </div>

        <!-- Tombol Menuju Form Pinjaman -->
        <div class="text-center mt-4">
            <a href="{{ route('user.loan.form') }}" class="btn btn-edufin">
                <i class="fas fa-arrow-right me-1"></i> Pinjaman
            </a>
        </div>
    </div>

@endsection
