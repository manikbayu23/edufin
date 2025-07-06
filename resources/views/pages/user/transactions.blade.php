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
                        'pending' => [
                            'text' => 'Sedang Diproses',
                            'color' => 'diproses',
                        ],
                        'approved' => [
                            'text' => 'Disetujui',
                            'color' => 'disetujui',
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
                <div class="card p-3 mb-3">
                    <p><strong>Nama Institusi:</strong> STMIK YZ</p>
                    <p><strong>Jumlah Pinjaman:</strong> Rp5.000.000</p>
                    <p><strong>Tenor:</strong> 6 Bulan</p>
                    <p><strong>Jatuh Tempo:</strong> 30 September 2025</p>
                    <span class="status-badge badge-disetujui">Disetujui</span>
                </div>
            </div>

            <!-- Jatuh Tempo Tab -->
            <div class="tab-pane fade" id="due" role="tabpanel">
                <div class="card p-3 mb-3">
                    <p><strong>Nama Institusi:</strong> Universitas ABC</p>
                    <p><strong>Jumlah Pinjaman:</strong> Rp3.000.000</p>
                    <p><strong>Tenor:</strong> 6 Bulan</p>
                    <p><strong>Jatuh Tempo:</strong> 20 Juni 2025</p>
                    <span class="status-badge badge-menunggu">Menunggu Pembayaran</span>
                </div>
            </div>

            <!-- Status Tab -->
            <div class="tab-pane fade" id="status" role="tabpanel">
                <div class="card p-3 mb-3">
                    <p><strong>Nama Institusi:</strong> Politeknik DEF</p>
                    <p><strong>Jumlah Pinjaman:</strong> Rp8.000.000</p>
                    <p><strong>Tenor:</strong> 12 Bulan</p>
                    <p><strong>Jatuh Tempo:</strong> 10 Januari 2025</p>
                    <span class="status-badge badge-lunas">Lunas</span>
                </div>
                <div class="card p-3 mb-3">
                    <p><strong>Nama Institusi:</strong> Akademi QWERTY</p>
                    <p><strong>Jumlah Pinjaman:</strong> Rp4.500.000</p>
                    <p><strong>Tenor:</strong> 3 Bulan</p>
                    <p><strong>Jatuh Tempo:</strong> 15 Juni 2025</p>
                    <span class="status-badge badge-belum">Belum Bayar</span>
                </div>
                <div class="card p-3 mb-3">
                    <p><strong>Nama Institusi:</strong> STT CDEF</p>
                    <p><strong>Jumlah Pinjaman:</strong> Rp6.000.000</p>
                    <p><strong>Tenor:</strong> 9 Bulan</p>
                    <p><strong>Jatuh Tempo:</strong> 5 Juli 2025</p>
                    <span class="status-badge badge-dibatalkan">Dibatalkan</span>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons: Only for Jatuh Tempo tab -->
        <div id="paymentButtons" class="d-flex justify-content-center gap-3 mt-5" style="display: none;">
            <a href="home.html" class="btn btn-outline-secondary">Kembali ke Home</a>
            <a href="payment.html" class="btn btn-success">Lanjut ke Pembayaran</a>
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
