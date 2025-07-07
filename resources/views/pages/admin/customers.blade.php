@extends('layouts.admin-main')
@section('title', content: 'Data Peminjam')
@section('content')

    <div class="card rounded-0">
        <div class="card-header">
            <h2 class="h4 mb-0">Data Peminjaman</h2>
        </div>
        <div class="card-body">
            {{-- <div class="row">
                <div class="col-3">
                    <input type="text" class="form-control">
                </div>
            </div> --}}
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Lengkap</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat Lengkap</th>
                    <th>Nomor Rekening</th>
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
                        <td>{{ $row->address }}</td>
                        <td>{{ $row->account_number }}</td>
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
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idRoomItem">
                        <fieldset class="mb-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Nama Peminjam :</label>
                                    <input type="text" class="form-control" id="name" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Nama Institusi :</label>
                                    <input type="text" class="form-control" id="institution_name" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">No Telepon :</label>
                                    <input type="text" class="form-control" id="phone" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Alamat :</label>
                                    <input type="text" class="form-control" id="address" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">No Rekening :</label>
                                    <input type="text" class="form-control" id="account_number" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Jenjang Pendidikan :</label>
                                    <input type="text" class="form-control" id="education" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Tenor :</label>
                                    <input type="text" class="form-control" id="tenor" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Nominal Peminjaman :</label>
                                    <input type="text" class="form-control" id="amount" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Bunga Bulanan :</label>
                                    <input type="text" class="form-control" id="annual_interest_rate" disabled>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Cicilan Per Bulan :</label>
                                    <input type="text" class="form-control" id="monthly_payment" disabled>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-bold">Tanggal Pencairan :</label>
                                    <input type="hidden" id="is_approved" name="is_approved">
                                    <input type="date" class="form-control" name="start_date" id="start_date" required>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light">
                                Tutup
                            </button>
                        </div>
                        <div id="actions-button">
                            <button type="button" class="btn btn-danger btn-rejected" style="display: none"><i
                                    class="fas fa-times"></i>
                                Tolak</button>
                            <button type="button" class="btn btn-success btn-approved" style="display: none"><i
                                    class="fas fa-check"></i>
                                Setujui</button>
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
            if (item.status == 'pending') {
                $('.btn-rejected').show();
                $('.btn-approved').show();
            }
            $('#name').val(item.name);
            $('#institution_name').val(item.institution_name);
            $('#phone').val(item.phone);
            $('#address').val(item.address);
            $('#account_number').val(item.account_number);
            $('#education').val(item.education);
            $('#tenor').val(item.tenor + ' bulan');
            $('#amount').val(formatRupiah(item.amount));
            $('#annual_interest_rate').val(item.annual_interest_rate);
            $('#monthly_payment').val(formatRupiah(item.monthly_payment));

            $('#start_date').prop('disabled', false);

            if (item.status !== 'pending') {
                $('#start_date').val(item.start_date).prop('disabled', true);
            }

            const url = "{{ route('admin.customer.update', ':id') }}".replace(':id', id);
            $('#detailForm').attr('action', url)
            $('#customerModal').modal('show');
        })
        const formatRupiah = (num) => {
            return "Rp " + parseFloat(num).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        };

        $('.btn-approved').on('click', function() {
            $('#is_approved').val('1');
            if ($('#start_date').val().trim() == '') {
                Swal.fire({
                    title: 'Perhatian!',
                    text: 'Tambahkan tangal pencairan sebelum disetujui!',
                    icon: 'info'
                });
                return;
            }
            $('#detailForm').submit();
        })
        $('.btn-rejected').on('click', function() {
            $('#is_approved').val('0');
            $('#detailForm').submit();
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
