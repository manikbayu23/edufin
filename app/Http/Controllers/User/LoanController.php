<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Support\Str;
use App\Models\LoanDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LoanController extends Controller
{
    public function form()
    {
        $loan = Loan::where('user_id', Auth::user()->id)
            ->where('status', 'draft')
            ->orderBy('id', 'desc')
            ->first();

        // if ($loan) {
        //     return redirect()->route('user.loan.submission', $loan->id);
        // }

        return view('pages.user.loan-form');
    }

    public function fileScan($id)
    {
        $form = Session::get('form_' . $id);
        if (!$form) {
            return redirect()->back();
        }
        return view('pages.user.file-scan', compact('id'));
    }

    public function saveForm(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
            'education' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'tenor' => 'required',
            'address' => 'required|string',
            'amount' => 'required|numeric',
            'account_number' => 'required|max:100',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'institution_name.required' => 'Nama institusi wajib diisi.',
            'education.required' => 'Pendidikan wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.max' => 'Nomor telepon maksimal 15 karakter.',
            'tenor.required' => 'Tenor wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'amount.required' => 'Jumlah pinjaman wajib diisi.',
            'amount.numeric' => 'Jumlah pinjaman harus berupa angka.',
            'account_number.required' => 'Nomor rekening wajib diisi.'
        ]);
        $random = Str::random(5);
        Session::put('form_' . $random, $validate);

        return redirect()->route('user.loan.file-scan', $random);
    }

    public function store(Request $request, $id)
    {
        $form = Session::get('form_' . $id);
        if (!$form) {
            return redirect()->back()->withErrors('Form tidak ditemukan, mohon isi ulang form');
        }

        $validate = $request->validate(
            [
                'identity_card' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'family_card' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'proof_bill' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bank_account' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ],
            [
                'identity_card.required' => 'KTP harus diunggah.',
                'identity_card.mimes' => 'KTP harus berupa file PDF atau gambar (jpg, jpeg, png).',
                'identity_card.max' => 'Ukuran file KTP maksimal 2MB.',

                'family_card.required' => 'Kartu Keluarga harus diunggah.',
                'family_card.mimes' => 'Kartu Keluarga harus berupa file PDF atau gambar (jpg, jpeg, png).',
                'family_card.max' => 'Ukuran file Kartu Keluarga maksimal 2MB.',

                'proof_bill.required' => 'Bukti tagihan harus diunggah.',
                'proof_bill.mimes' => 'Bukti tagihan harus berupa file PDF atau gambar (jpg, jpeg, png).',
                'proof_bill.max' => 'Ukuran file bukti tagihan maksimal 2MB.',

                'bank_account.required' => 'Dokumen rekening bank harus diunggah.',
                'bank_account.mimes' => 'Rekening bank harus berupa file PDF atau gambar (jpg, jpeg, png).',
                'bank_account.max' => 'Ukuran file rekening bank maksimal 2MB.',
            ]
        );

        $amount = (int) $form['amount'];
        $tanggunganMandiri = $amount * 0.1;
        $pinjamanEdufin = $amount - $tanggunganMandiri;
        $adminProvisi = 0.05 * $pinjamanEdufin;
        $totalFee = $tanggunganMandiri + $adminProvisi;

        $P = $pinjamanEdufin;
        $r = 0.0029;
        $n = (int) $form['tenor'];

        $numerator = $r * pow(1 + $r, $n);
        $denominator = pow(1 + $r, $n) - 1;
        $totalInstallment = $P * ($numerator / $denominator);

        try {
            DB::beginTransaction();
            $loan = Loan::create([
                ...$form,
                'user_id' => Auth::user()->id,
                'amount' => $amount,
                'monthly_payment' => $totalInstallment,
                'annual_interest_rate' => $r * 12 * 100,
                'independent_responsibility' => (int) $tanggunganMandiri,
                'admin_fee' => $adminProvisi,
                'total_amount' => $pinjamanEdufin,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $documents = [];
            if ($request->has('identity_card')) {
                $file = $validate['identity_card'];
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Nama file tanpa ekstensi
                $extension = $file->getClientOriginalExtension(); // Ekstensi file
                $filename = $originalName . '-' . uniqid() . '.' . $extension; // Gabungkan dengan ID unik

                $file->storeAs('documents', $filename);

                $documents[] = [
                    'loan_id' => $loan->id,
                    'type' => 'identity_card',
                    'path' => $filename,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            if ($request->has('family_card')) {
                $file = $validate['family_card'];
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Nama file tanpa ekstensi
                $extension = $file->getClientOriginalExtension(); // Ekstensi file
                $filename = $originalName . '-' . uniqid() . '.' . $extension; // Gabungkan dengan ID unik

                $file->storeAs('documents', $filename);

                $documents[] = [
                    'loan_id' => $loan->id,
                    'type' => 'family_card',
                    'path' => $filename,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            if ($request->has('proof_bill')) {
                $file = $validate['proof_bill'];
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Nama file tanpa ekstensi
                $extension = $file->getClientOriginalExtension(); // Ekstensi file
                $filename = $originalName . '-' . uniqid() . '.' . $extension; // Gabungkan dengan ID unik

                $file->storeAs('documents', $filename);

                $documents[] = [
                    'loan_id' => $loan->id,
                    'type' => 'proof_bill',
                    'path' => $filename,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            if ($request->has('bank_account')) {
                $file = $validate['bank_account'];
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Nama file tanpa ekstensi
                $extension = $file->getClientOriginalExtension(); // Ekstensi file
                $filename = $originalName . '-' . uniqid() . '.' . $extension; // Gabungkan dengan ID unik

                $file->storeAs('documents', $filename);

                $documents[] = [
                    'loan_id' => $loan->id,
                    'type' => 'bank_account',
                    'path' => $filename,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }

            LoanDocument::insert($documents);

            $this->generateRepayments($loan);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->route('user.loan.submission', $loan->id);
    }

    protected function generateRepayments($loan)
    {
        $repayments = [];
        $dueDate = now()->addMonth(); // Mulai bulan depan

        for ($i = 1; $i <= $loan->tenor; $i++) {
            $repayments[] = [
                'loan_id' => $loan->id,
                'installment_number' => $i,
                'due_date' => $dueDate->copy()->addMonths($i - 1),
                'amount' => $loan->monthly_payment,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        Repayment::insert($repayments);
    }

    public function submission(string $id)
    {
        $loan = Loan::where('status', 'draft')->findOrFail($id);
        return view('pages.user.submission', compact('loan'));
    }
    public function submissionStore(Request $request, $id)
    {
        $loan = Loan::find($id);
        $loan->status = 'pending';
        $loan->updated_at = Carbon::now();
        $loan->save();

        return redirect()->route('user.loan.submission.success', $id);
    }

    public function submissionSuccess($id)
    {
        $loan = Loan::findOrFail($id);
        return view('pages.user.submission-success');
    }

    public function cancel($id)
    {
        DB::transaction(function () use ($id) {
            $loan = Loan::with(['loan_documents', 'repayments'])->findOrFail($id);
            $documents = $loan->loan_documents;

            // Hapus data dari database terlebih dahulu
            $loan->repayments()->delete();
            $loan->loan_documents()->delete();
            $loan->delete();

            // Hapus file SETELAH transaksi commit
            DB::afterCommit(function () use ($documents) {
                foreach ($documents as $document) {
                    Storage::delete('documents/' . $document->path);
                }
            });

        });
        return redirect()->route('user.loan.form')->with('success', 'Peminjaman berhsil dibatalakan.');
    }
}
