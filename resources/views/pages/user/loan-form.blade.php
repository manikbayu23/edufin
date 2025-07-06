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
        <h2>Pinjaman EduFin</h2>
        <form action="{{ route('user.loan.form.store') }}" method="POST">
            @csrf
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Masukan nama institusi" />
                    @if ($errors->has('name'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Institusi</label>
                    <input type="text" name="institution_name" class="form-control" value="{{ old('institution_name') }}"
                        placeholder="Masukan nama lengkap" />
                    @if ($errors->has('institution_name'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('institution_name') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenjang Pendidikan Anak</label>
                    <input type="text" name="education" class="form-control" value="{{ old('education') }}"
                        placeholder="Masukan jenjang pendidikan anak" />
                    @if ($errors->has('education'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('education') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}"
                        placeholder="Masukan no telepon" />
                    @if ($errors->has('phone'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tenor</label>
                    <select name="tenor" class="form-select">
                        <option selected disabled value="">Pilih Tenor</option>
                        <option value="6">6 bulan</option>
                        <option value="12">12 bulan</option>
                        <option value="18">18 bulan</option>
                    </select>
                    @if ($errors->has('tenor'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('tenor') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Alamat Lengkap</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                        placeholder="Masukan alamat lengkap" />
                    @if ($errors->has('address'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nominal Pinjaman</label>
                    <input type="number" name="amount" class="form-control" value="{{ old('amount') }}"
                        placeholder="Masukan nominal pinjaman" />
                    @if ($errors->has('amount'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('amount') }}
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Rekening</label>
                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}"
                        placeholder="Masukan nomor rekening" />
                    @if ($errors->has('account_number'))
                        <div class="error-text text-danger text-start mb-1 w-100"><i class="fas fa-times me-1"></i>
                            {{ $errors->first('account_number') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('user.guide') }}" class="btn btn-back px-4"><i class="fas fa-arrow-left"></i> Back</a>
                <button type="submit" class="btn btn-upload px-4"> Next <i class="fas fa-arrow-right"></i> </button>
            </div>
        </form>
    </div>
@endsection
