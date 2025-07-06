@extends('layouts.main')
@section('title', content: 'Form Peminjaman')
@push('css')
    <style>
        body {
            background-color: #f4f4f4 !important;
        }

        header img {
            height: 30px;
            margin-right: 10px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 70px);
        }

        .card {
            background: white;
            text-align: center;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            margin-top: 10px;
            font-size: 20px;
        }

        .card p {
            margin-top: 5px;
            color: gray;
            font-size: 14px;
        }

        .card img {
            width: 50px;
            height: 50px;
        }

        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #3d5d4f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #314c42;
        }
    </style>
@endpush
@section('content')

    <div class="container">
        <div class="card">
            <div class="text-center mb-3">
                <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" alt="Success Icon">
            </div>
            <h2>Upload Berkas Berhasil</h2>
            <p>pengajuan anda sedang di proses!</p>
            <a href="{{ route('user.transaction') }}" class="btn">Lihat Transaksi</a>
        </div>
    </div>

@endsection
