@extends('layouts.main')
@section('title', content: 'Form Peminjaman')
@push('css')
    <style>
        .main-content {
            flex: 1;
        }

        .payment-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #999;
        }

        .bank-option button {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px 20px;
            transition: 0.2s;
            font-weight: 500;
        }

        .bank-option button:hover,
        .bank-option button.active {
            border-color: #2c4a42;
            background-color: #e0f3eb;
        }
    </style>
@endpush
@section('content')

    <div class="container my-5 main-content">
        <h2 class="text-center mb-4">Payment</h2>

        <div class="row g-4">
            <!-- Riwayat Pembayaran -->
            <div class="col-md-6">
                <div class="payment">
                    <h5>Riwayat Pembayaran</h5>
                    <ul class="list-group list-group-flush">
                        @php
                            $sisaPayment = 0;
                        @endphp
                        @forelse ($loan->repayments as $payment)
                            @if ($payment->status !== 'pending')
                                <li class="list-group-item">Pembayaran {{ $payment->installment_number }} -
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    ({{ \Carbon\Carbon::parse($payment->due_date)->translatedFormat('j F Y') }})
                                    </p>
                                </li>
                            @else
                                @php
                                    $sisaPayment = $sisaPayment + (float) $payment->amount;
                                @endphp
                            @endif
                        @empty
                            <li class="list-group-item">Belum ada riwayat pembayaran.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Rincian Payment -->
            <div class="col-md-6">
                <div class="payment-card">
                    <h5>Rincian Pembayaran</h5>
                    <p><strong>Institusi:</strong> {{ $loan->institution_name }}</p>
                    <p><strong>Total Pinjaman:</strong> Rp {{ number_format($loan->amount, 0, ',', '.') }}</p>
                    <p><strong>Tenor:</strong> {{ $loan->tenor }} Bulan</p>
                    <p><strong>Sisa Payment : </strong>Rp {{ number_format($sisaPayment, 0, ',', '.') }}</p>
                    <p><strong>Jatuh Tempo Berikutnya:</strong>
                        {{ \Carbon\Carbon::parse($loan->next_repayment->due_date)->translatedFormat('j F Y') }}</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="{{ route('user.transaction.detail-payment', $loan->id) }}"
                            class="btn btn-success w-50">Bayar</a>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-danger w-50">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
