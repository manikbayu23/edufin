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
    </style>
@endpush
@section('content')

    <div class="container-box">
        <h2>Upload Dokumen</h2>
        <form action="{{ route('user.loan.file-scan.store', $id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Scan/foto e-KTP peminjam</label>
                    <input type="file" name="identity_card" class="form-control" accept="application/pdf,image/*" />
                    @if ($errors->has('identity_card'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('identity_card') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Scan/foto Kartu Keluarga atau Wali</label>
                    <input type="file" name="family_card" class="form-control" accept="application/pdf,image/*" />
                    @if ($errors->has('family_card'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('family_card') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Scan/foto bukti tagihan kampus</label>
                    <input type="file" name="proof_bill" class="form-control" accept="application/pdf,image/*" />
                    @if ($errors->has('proof_bill'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('proof_bill') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Foto/scan rekening bank atas nama peminjam</label>
                    <input type="file" name="bank_account" class="form-control" accept="application/pdf,image/*" />
                    @if ($errors->has('bank_account'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('bank_account') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('user.loan.form') }}" class="btn btn-back px-4"><i class="fas fa-arrow-left"></i> Back</a>
                <button type="submit" class="btn btn-upload px-4">Upload <i class="fas fa-upload"></i></button>
            </div>
        </form>
    </div>

@endsection
