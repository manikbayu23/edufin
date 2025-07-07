@extends('layouts.admin-main')
@section('title', content: 'Data Peminjam')
@section('content')

    <div class="card rounded-0">
        <div class="card-header">
            <h2 class="h4 mb-0">Data Agunan</h2>
        </div>
        <div class="card-body">
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Lengkap</th>
                    <th>Nomor Telepon</th>
                    <th>Nomor Rekening</th>
                    <th class="text-center">Tenor</th>
                    <th class="text-end">Nominal Pinjaman</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $status = [
                        'approved' => [
                            'color' => 'bg-success',
                            'text' => 'Disetujui',
                        ],
                        'pending' => [
                            'color' => 'bg-warning',
                            'text' => 'Pending',
                        ],
                        'rejected' => [
                            'color' => 'bg-danger',
                            'text' => 'Ditolak',
                        ],
                        'paid' => [
                            'color' => 'bg-info',
                            'text' => 'Lunas',
                        ],
                    ];
                @endphp
                @foreach ($data as $index => $row)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->phone }}</td>
                        <td>{{ $row->account_number }}</td>
                        <td class="text-center">{{ $row->tenor }} Bulan</td>
                        <td class="text-end">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>

                        <td class="text-center"> <span
                                class="badge {{ $status[$row->status]['color'] }}">{{ $status[$row->status]['text'] }}
                            </span> </td>

                        <td class="d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm btn-detail" data-id="{{ $row->id }}"><i
                                    class="fas fa-eye"></i> Detail</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $data->links() }}
        </div>
    </div>

    <div class="modal fade" id="customerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                        <legend class="fs-base fw-bold"> Data
                            Peminjaman
                        </legend>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="detailForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idRoomItem">
                        <fieldset class="mb-3">
                            <div class="row g-3" id="row-content">

                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light">
                                Tutup
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous">
    </script>
    <script>
        $('.btn-detail').click(function() {
            const id = $(this).data('id');
            const data = @json($data);
            const item = data.data.find(d => d.id == id);

            console.log(item);

            if (item.loan_documents.length > 0) {
                let html = '';
                item.loan_documents.forEach((row, index) => {
                    let title = '';
                    if (row.type == 'identity_card') {
                        title = 'KTP';
                    } else if (row.type == 'family_card') {
                        title = 'Kartu Keluarga';
                    } else if (row.type == 'proof_bill') {
                        title = 'Bukti Pembayaran';
                    } else if (row.type == 'bank_account') {
                        title = 'Nomor Rekening';
                    }
                    html += `<div class="col-12 col-md-3">
                                    <label class="form-label fw-bold">${title} :</label>
                                    <div>
                                        <a target="_blank" href="picture/documents/${row.path}" class="btn btn-primary">Buka File </a>
                                    </div>
                                </div>`;
                });

                $('#row-content').html(html)
            }
            $('#customerModal').modal('show');
        })

        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success'
                })
            @endif
        })
    </script>
@endpush
