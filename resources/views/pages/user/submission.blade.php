@extends('layouts.main')
@section('title', content: 'Form Peminjaman')
@push('css')
    <style>
        body {
            background-color: #f4f4f4 !important;
        }

        .container-box {
            background-color: white;
            max-width: 1000px;
            margin: 40px auto;
            padding: 40px;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #365c49;
            margin-bottom: 40px;
        }

        .form-label {
            font-weight: bold;
            font-size: 14px;
        }

        .btn-back {
            background-color: #facc15;
            color: black;
            font-weight: bold;
        }

        .btn-upload {
            background-color: #365c49;
            color: white;
            font-weight: bold;
        }


        .btns {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .btn-edufins {
            background-color: #365c49;
            color: white;
            font-weight: bold;
            padding: 10px 40px;
        }

        .btn-cancel {
            border: 1px solid #ccc;
            padding: 10px 40px;
        }

        hr {
            border: 1px solid #ccc;
            margin: 10px 0 15px;
        }
    </style>
@endpush
@section('content')

    <div class="container-box">
        <h2>Pinjaman EduFin</h2>

        <!-- Ringkasan Simulasi -->
        <div class="summary-box" id="summaryBox">
            <p><strong>Memuat data simulasi...</strong></p>
        </div>
        <form id="simulationForm" action="{{ route('user.loan.submission.store', $loan->id) }}" method="POST">
            @csrf
        </form>
        <div class="btns">
            <button type="button" id="btn-submission" class="btn btn-edufins text-decoration-none">Ajukan</button>
            <a href="{{ route('user.loan.cancel', $loan->id) }}"
                class="btn btn-cancel text-dark text-decoration-none">Batal</a>
        </div>
    </div>

@endsection

@push('js')
    <script>
        const simulation = () => {

            const nominal = @json($loan->amount);
            const tanggunganMandiri = @json($loan->independent_responsibility);
            const pinjamanEdufin = @json($loan->total_amount);
            const adminProvisi = @json($loan->admin_fee);
            const totalTanggungan = parseFloat(tanggunganMandiri) + parseFloat(adminProvisi);
            const tenor = @json($loan->tenor);
            const bunga = 0.0029;
            const cicilanPerBulan = @json($loan->monthly_payment);

            $('#summaryBox').html(`
                <p><strong>Nominal Tagihan:</strong> ${formatRupiah(nominal)}</p>
                <p><strong>Tanggungan Mandiri (10%):</strong> ${formatRupiah(tanggunganMandiri)}</p>
                <p><strong>Admin & Provisi (5%):</strong> ${formatRupiah(adminProvisi)}</p>
                <p><strong>Total Tanggungan Mandiri:</strong> ${formatRupiah(totalTanggungan)}</p>
                <hr />
                <p><strong>Nominal Pinjaman EduFin:</strong> ${formatRupiah(pinjamanEdufin)}</p>
                <p><strong>Suku Bunga (per Bulan):</strong> 0,29%</p>
                <p><strong>Tenor:</strong> ${tenor} Bulan</p>
                <p><strong>Cicilan per Bulan:</strong> ${formatRupiah(cicilanPerBulan)}</p>
                `);
        }

        // Format angka
        const formatRupiah = (num) => {
            return "Rp" + parseFloat(num).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        };

        // Tampilkan hasil

        $('#btn-submission').click(function() {
            Swal.fire({
                title: 'Ajukan sekarang',
                text: 'Klik OK untuk mengajuan',
                icon: 'info',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#simulationForm').submit();
                }
            })
        })

        $(document).ready(function() {
            simulation();
        })
    </script>
@endpush
