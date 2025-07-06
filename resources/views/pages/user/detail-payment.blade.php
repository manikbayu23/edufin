@extends('layouts.main')
@section('title', content: 'Form Peminjaman')
@push('css')
    <style>
        .main-content {
            flex: 1;
        }

        .container {
            max-width: 700px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .payment-info {
            margin-top: 20px;
            display: none;
        }
    </style>
@endpush
@section('content')

    <div class="container mt-5">
        <div class="card p-4">
            <h4 class="mb-3 text-center">Detail Pembayaran</h4>

            <form action="{{ route('user.transaction.pay', $loan->next_repayment->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Total -->
                <div class="mb-4">
                    <p class="mb-1 fw-semibold">Total yang harus dibayar:</p>
                    <h3 class="text-success">Rp {{ number_format($loan->next_repayment->amount, 0, ',', '.') }}</h3>
                    <input type="hidden" value="{{ $loan->next_repayment->amount }}" name="amount">
                </div>

                <!-- Metode -->
                <div class="mb-3">
                    <p class="fw-semibold">Pilih Metode Pembayaran:</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode" value="transfer" id="transfer"
                            onchange="showPaymentInfo('transfer')" checked>
                        <label class="form-check-label" for="transfer">Transfer Bank</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode" value="qris" id="qris"
                            onchange="showPaymentInfo('qris')">
                        <label class="form-check-label" for="qris">QRIS</label>
                    </div>
                </div>

                <!-- Info Transfer -->
                <div id="info-transfer" class="payment-info">
                    <p class="mb-2 fw-semibold">Pilih Bank:</p>
                    <select class="form-select mb-3" name="bank" id="bankSelect" onchange="updateBankInfo()">
                        @foreach ($paymentMethods as $method)
                            @if ($method->type == 'Transfer Bank')
                                <option value="{{ $method->id }}">{{ $method->provider }}</option>
                            @endif
                        @endforeach
                    </select>
                    <div id="bankInfo">
                        <!-- Akan diisi oleh JavaScript -->
                    </div>
                </div>

                <!-- Info QRIS -->
                <div id="info-qris" class="payment-info text-center">
                    <p class="fw-semibold mb-2">Scan QR Code:</p>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($paymentMethods as $method)
                        @if ($method->type == 'Qris')
                            <input type="hidden" name="qris_{{ $no++ }}" value="{{ $method->id }}">
                            <option value="{{ $method->id }}">{{ $method->provider }}</option>
                            <img src="{{ asset('assets/images/qris.jpg') }}" alt="QRIS" style="width: 200px;">
                            <p class="text-center">{{ $method->name }}</p>
                        @endif
                    @endforeach
                    <p class="mt-2">Gunakan aplikasi pembayaran favoritmu</p>
                </div>
                <hr>
                <div>
                    <label for="pay" class="form-label">Bukti Pembayaran : </label>
                    <input type="file" class="form-control" name="proof" id="proof">
                    @if ($errors->has('proof'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('proof') }}
                        </div>
                    @endif
                </div>

                <!-- Tombol -->
                <div class="mt-4">
                    <button class="btn btn-success w-100">Selesai</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        const bankDetails = @json($paymentMethods);

        function showPaymentInfo(metode) {
            document.querySelectorAll('.payment-info').forEach(div => div.style.display = 'none');
            document.getElementById(`info-${metode}`).style.display = 'block';
            if (metode === 'transfer') updateBankInfo();
        }

        function updateBankInfo() {
            const selectedBank = document.getElementById('bankSelect').value;
            const info = bankDetails.find(item => item.id == selectedBank);

            document.getElementById('bankInfo').innerHTML = `
      <p class="mb-0"><strong>${info.provider}</strong></p>
      <p>No. Rekening: <strong>${info.account_number}</strong></p>
      <p>Atas Nama: <strong>${info.name}</strong></p>
    `;
        }

        window.onload = () => {
            showPaymentInfo('transfer');
        };
    </script>
@endpush
