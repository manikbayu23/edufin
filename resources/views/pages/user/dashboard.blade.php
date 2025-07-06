@extends('layouts.main')
@section('title', content: 'Dashboard')
@section('content')

    <!-- Greeting -->
    <div class="container text-center my-5">
        <h2>Halo, <span>{{ Auth::user()->name }}</span>!</h2>
        <p>Selamat datang di EduFin. Pilih fitur yang ingin kamu gunakan:</p>
    </div>

    <!-- Features -->
    <div class="container mb-5">
        <div class="row g-4">
            <div class="col-md-4 d-flex">
                <div class="feature-card w-100">
                    <div>
                        <i class="fas fa-book"></i>
                        <h4 class="mt-3">Edu Guide</h4>
                        <p>Bimbingan pintar untuk edukasi finansialmu.</p>
                    </div>
                    <a href="{{ route('user.guide') }}" class="btn btn-light">Explore</a>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="feature-card w-100">
                    <div>
                        <i class="fas fa-exchange-alt"></i>
                        <h4 class="mt-3">Transaction</h4>
                        <p>Lacak dan kelola transaksi keuangan dengan mudah.</p>
                    </div>
                    <a href="{{ route('user.transaction') }}" class="btn btn-light">View</a>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="feature-card w-100">
                    <div>
                        <i class="fas fa-credit-card"></i>
                        <h4 class="mt-3">Payment</h4>
                        <p>Bayar tagihan atau lakukan pembayaran langsung.</p>
                    </div>
                    <a href="{{ route('user.transaction.payment', $loanId) }}" class="btn btn-light">Pay Now</a>
                </div>
            </div>
        </div>
    </div>

@endsection
