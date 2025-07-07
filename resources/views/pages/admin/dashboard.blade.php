@extends('layouts.main')
@section('title', content: 'Dashboard')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
            padding: 0 20px 50px;
            min-heigt: 100vh !important;
        }

        .card {
            background-color: #365c4c;
            color: white;
            width: 220px;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .card-icon {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .btn-view {
            display: inline-block;
            background-color: white;
            color: #365c4c;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            width: 100%;
            text-align: center;
        }

        .btn-view:hover {
            background-color: #eee;
        }
    </style>
@endpush
@section('content')

    <!-- Greeting -->
    <div class="container text-center my-5">
        <h2>Hallo, Admin</h2>
    </div>

    <div class="card-container">
        <div class="card">
            <div class="card-icon"><i class="bi bi-folder2-open"></i></div>
            <div class="card-title">Data Peminjam</div>
            <a href="{{ route('admin.customer') }}" class="btn-view">View</a>
        </div>
        <div class="card">
            <div class="card-icon"><i class="bi bi-wallet-fill"></i></div>
            <div class="card-title">Data Transaksi</div>
            <a href="{{ route('admin.transaction') }}" class="btn-view">View</a>
        </div>
        <div class="card">
            <div class="card-icon"><i class="bi bi-people-fill"></i></div>
            <div class="card-title">Nasabah Menunggak</div>
            <a href="{{ route('admin.customer-arrears') }}" class="btn-view">View</a>
        </div>
        <div class="card">
            <div class="card-icon"><i class="bi bi-cash-coin"></i></div>
            <div class="card-title">Nasabah Lunas</div>
            <a href="{{ route('admin.customer-paid-off') }}" class="btn-view">View</a>
        </div>
        <div class="card">
            <div class="card-icon"><i class="bi bi-file-earmark-lock2"></i></div>
            <div class="card-title">Tanda Terima Agunan</div>
            <a href="{{ route('admin.customer-collateral') }}" class="btn-view">View</a>
        </div>
    </div>
@endsection
