@extends('layouts.main')
@section('title', content: 'Dashboard')

@push('css')
    <style>
        .status-badge {
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: bold;
            color: white;
        }

        .badge-diproses {
            background-color: orange;
        }

        .badge-disetujui {
            background-color: green;
        }

        .badge-menunggu {
            background-color: darkorange;
        }

        .badge-lunas {
            background-color: teal;
        }

        .badge-belum {
            background-color: red;
        }

        .badge-dibatalkan {
            background-color: grey;
        }

        footer {
            margin-top: auto;
            text-align: center;
            padding: 30px 0 20px;
            color: #999;
        }
    </style>
@endpush
@section('content')
    {{-- @dd($loans); --}}
    <div class="container my-5">
        <h2 class="text-center mb-4">Transaction</h2>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="transactionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button"
                    role="tab">All</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="latest-tab" data-bs-toggle="tab" data-bs-target="#latest" type="button"
                    role="tab">Pinjaman Terkini</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="due-tab" data-bs-toggle="tab" data-bs-target="#due" type="button"
                    role="tab">Jatuh Tempo</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="status-tab" data-bs-toggle="tab" data-bs-target="#status" type="button"
                    role="tab">Status</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="transactionTabsContent">
            <!-- All Tab -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                @php
                    $status = [
                        'approved' => [
                            'color' => 'disetujui',
                            'text' => 'Disetujui',
                        ],
                        'pending' => [
                            'color' => 'diproses',
                            'text' => 'Pending',
                        ],
                        'rejected' => [
                            'color' => 'belum',
                            'text' => 'Ditolak',
                        ],
                        'paid' => [
                            'color' => 'lunas',
                            'text' => 'Lunas',
                        ],
                    ];
                @endphp
                @foreach ($loans as $loan)
                    <div class="card p-3 mb-3">
                        <p><strong>Nama Institusi:</strong> {{ $loan->institution_name }}</p>
                        <p><strong>Jumlah Pinjaman: </strong> Rp {{ number_format($loan->amount, 0, ',', '.') }}</p>
                        <p><strong>Tenor:</strong> {{ $loan->tenor }} Bulan</p>
                        <p><strong>Jatuh Tempo:</strong>
                            {{ \Carbon\Carbon::parse($loan->next_repayment->due_date)->translatedFormat('j F Y') }}</p>

                        <span
                            class="mb-3 status-badge badge-{{ $status[$loan->status]['color'] }}">{{ $status[$loan->status]['text'] }}
                        </span>
                        <div>
                            @if ($loan->status == 'approved')
                                <a href="{{ route('user.transaction.payment', $loan->id) }}"
                                    class="btn btn-outline-success">Lanjut ke
                                    Pembayaran</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pinjaman Terkini Tab -->
            <div class="tab-pane fade" id="latest" role="tabpanel">
                @foreach ($loans as $loan)
                    @if ($loan->status == 'approved')
                        <div class="card p-3 mb-3">
                            <p><strong>Nama Institusi:</strong> {{ $loan->institution_name }}</p>
                            <p><strong>Jumlah Pinjaman: </strong> Rp {{ number_format($loan->amount, 0, ',', '.') }}</p>
                            <p><strong>Tenor:</strong> {{ $loan->tenor }} Bulan</p>
                            <p><strong>Jatuh Tempo:</strong>
                                {{ \Carbon\Carbon::parse($loan->next_repayment->due_date)->translatedFormat('j F Y') }}</p>

                            <span
                                class="mb-3 status-badge badge-{{ $status[$loan->status]['color'] }}">{{ $status[$loan->status]['text'] }}
                            </span>
                            <div>
                                @if ($loan->status == 'approved')
                                    <a href="{{ route('user.transaction.payment', $loan->id) }}"
                                        class="btn btn-outline-success">Lanjut ke
                                        Pembayaran</a>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Jatuh Tempo Tab -->
            <div class="tab-pane fade" id="due" role="tabpanel">
                @foreach ($loans as $loan)
                    @if ($loan->status == 'approved' && \Carbon\Carbon::parse($loan->next_repayment->due_date) <= \Carbon\Carbon::now())
                        <div class="card p-3 mb-3">
                            <p><strong>Nama Institusi:</strong> {{ $loan->institution_name }}</p>
                            <p><strong>Jumlah Pinjaman: </strong> Rp {{ number_format($loan->amount, 0, ',', '.') }}</p>
                            <p><strong>Tenor:</strong> {{ $loan->tenor }} Bulan</p>
                            <p><strong>Jatuh Tempo:</strong>
                                {{ \Carbon\Carbon::parse($loan->next_repayment->due_date)->translatedFormat('j F Y') }}</p>

                            <span class="mb-3 status-badge badge-menunggu">Menunggu Pembayaran
                            </span>
                            <div>
                                @if ($loan->status == 'approved')
                                    <a href="{{ route('user.transaction.payment', $loan->id) }}"
                                        class="btn btn-outline-success">Lanjut ke
                                        Pembayaran</a>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Status Tab -->
            <div class="tab-pane fade" id="status" role="tabpanel">
                @foreach ($loans as $loan)
                    <div class="card p-3 mb-3">
                        <p><strong>Nama Institusi:</strong> {{ $loan->institution_name }}</p>
                        <p><strong>Jumlah Pinjaman: </strong> Rp {{ number_format($loan->amount, 0, ',', '.') }}</p>
                        <p><strong>Tenor:</strong> {{ $loan->tenor }} Bulan</p>
                        <p><strong>Jatuh Tempo:</strong>
                            {{ \Carbon\Carbon::parse($loan->next_repayment->due_date)->translatedFormat('j F Y') }}</p>

                        <span
                            class="mb-3 status-badge badge-{{ $status[$loan->status]['color'] }}">{{ $status[$loan->status]['text'] }}
                        </span>
                        <div>
                            @if ($loan->status == 'approved')
                                <a href="{{ route('user.transaction.payment', $loan->id) }}"
                                    class="btn btn-outline-success">Lanjut ke
                                    Pembayaran</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Navigation Buttons: Only for Jatuh Tempo tab -->
        <div id="paymentButtons" class="d-flex justify-content-center gap-3 mt-5" style="display: none;">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">Kembali ke Home</a>
            {{-- <a href="payment.html" class="btn btn-success">Lanjut ke Pembayaran</a> --}}
        </div>
    </div>


@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
        const paymentSection = document.getElementById('paymentButtons');

        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(event) {
                const target = event.target.getAttribute('data-bs-target');
                if (target === '#due') {
                    paymentSection.style.display = 'flex';
                } else {
                    paymentSection.style.display = 'none';
                }
            });
        });

        // On page load
        window.addEventListener('DOMContentLoaded', () => {
            const activeTab = document.querySelector('.tab-pane.active')?.getAttribute('id');
            if (activeTab === 'due') {
                paymentSection.style.display = 'flex';
            }
        });
    </script>
@endpush
