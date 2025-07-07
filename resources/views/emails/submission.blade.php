<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Permintaan Peminjaman</title>
</head>

<body
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f1f1; margin: 0; padding: 0; color: #333;">
    <div
        style="max-width: 650px; margin: 30px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);">

        <!-- Header -->
        <div style="text-align: center; padding: 20px; border-bottom: 2px solid #f1f1f1;">
            <img src="https://drive.google.com/uc?export=view&id=1BDCcJO0kMfIR35TUBXl2BppY0BVFNnok" alt="Logo Perusahaan"
                style="max-width: 100px; margin-bottom: 10px;">

            <h2 style="margin: 0; font-size: 22px; color: #000;">Permintaan Peminjaman</h2>
        </div>

        {{-- @dd('sdfsdf') --}}
        <!-- Content -->
        <div style="padding: 25px 30px;">
            <p style="margin-bottom: 20px; font-size: 15px; color: #000;">Halo, berikut adalah detail permintaan
                peminjaman yang perlu
                ditinjau:</p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 15px; border-collapse: collapse;">
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555; width: 40%;">Nama </td>
                    <td style="padding: 10px 8px;">{{ $data->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Nama Institusi</td>
                    <td style="padding: 10px 8px;">{{ $data->instritution_name }}</td>
                </tr>
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">No Telepon</td>
                    <td style="padding: 10px 8px;">{{ $data->phone }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Alamat</td>
                    <td style="padding: 10px 8px;">{{ $data->address }}</td>
                </tr>
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">No Rekening</td>
                    <td style="padding: 10px 8px;">{{ $data->account_number }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Jenjang Pendidikan</td>
                    <td style="padding: 10px 8px;">{{ $data->education }}</td>
                </tr>
                <tr style="background-color: #f7f9fc;">
                    <td style="padding: 10px 8px; font-weight: bold; color: #555;">Nominal Peminjaman</td>
                    <td style="padding: 10px 8px;">Rp {{ number_format($data->amount, 0, ',', '.') }}</td>
                </tr>
            </table>

            <!-- Button -->
            <div style="text-align: center; margin-top: 20px;">
                Silahkan menyetujui dan menolak di dalam sistem.
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #f1f1f1; color: #777; text-align: center; font-size: 13px; padding: 15px;">
            Email ini dikirim otomatis oleh sistem.<br>
            © {{ date('Y') }} EduFin
        </div>
    </div>
    {{-- @dd(1) --}}
</body>

</html>
