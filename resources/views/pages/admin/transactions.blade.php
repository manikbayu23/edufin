@extends('layouts.admin-main')
@section('title', content: 'Data Transaksi')
@section('content')

    <div class="card rounded-0">
        <div class="card-header">
            <h2 class="h4 mb-0">Data Transaksi</h2>
        </div>
        <div class="card-body">
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Lengkap</th>
                    <th>Metode Pembayaran</th>
                    <th class="text-center">Tanggal Jatuh Tempo</th>
                    <th class="text-end">Nominal</th>
                    <th class="text-center">Bukti Pembayaran</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $status = [
                        '1' => [
                            'color' => 'bg-success',
                            'text' => 'Dikonfirmasi',
                        ],
                        '0' => [
                            'color' => 'bg-warning',
                            'text' => 'Pending',
                        ],
                    ];
                @endphp
                @foreach ($data as $index => $row)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $row->repayment->loan->name }} </td>
                        <td>{{ $row->payment_method->type }} - {{ $row->payment_method->provider }}</td>
                        <td class="text-center">{{ $row->repayment->due_date }}</td>
                        <td class="text-end">Rp {{ number_format($row->amount, 0, ',', '.') }}</td>
                        <td class="text-center"> <a
                                href="{{ url('admin/picture/proof_payment/' . $row->payment_proof_path) }}"
                                class="btn btn-link">Lihat bukti pembayaran</a> </td>
                        <td class="text-center"> <span
                                class="badge {{ $status[$row->status]['color'] }}">{{ $status[$row->status]['text'] }}
                            </span> </td>

                        <td>
                            <div class="d-flex justify-content-center">
                                @if ($row->status == '0')
                                    <button type="button" class="btn btn-success btn-confirmation"
                                        data-id="{{ $row->id }}"><i class="fas fa-check"></i>
                                    </button>
                                @else
                                    <span class="text-success">
                                        <div class="fas fa-check"></div>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $data->links() }}
        </div>
    </div>
    <form id="confirmationForm" method="POST">
        @csrf
        @method('PUT')
    </form>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous">
    </script>
    <script>
        $('.btn-confirmation').on('click', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi Pembayaran Cicilan?',
                text: 'Klik OK untuk konfirmasi',
                icon: 'info',
                showCancelButton: true
            }).then((results) => {
                if (results.isConfirmed) {
                    const url = "{{ route('admin.transaction.update', ':id') }}".replace(':id', id);
                    $('#confirmationForm').attr('action', url)
                    $('#confirmationForm').submit();
                }
            })

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
