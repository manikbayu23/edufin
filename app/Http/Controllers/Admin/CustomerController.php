<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $data = Loan::where('status', '!=', 'draft')->paginate(25);
        // dd($data);
        return view('pages.admin.customers', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $loan = Loan::with('repayments')->findOrFail($id);

        DB::transaction(function () use ($request, $loan) {
            // Update status loan
            if ($request->input('is_approved') == '1') {
                $loan->status = 'approved';
                $loan->start_date = Carbon::parse($request->input('start_date'));

                // Hapus cicilan lama jika ada
                if ($loan->repayments->isNotEmpty()) {
                    $loan->repayments()->delete();
                }

                // Buat cicilan baru berdasarkan start_date
                $repayments = [];
                $dueDate = $loan->start_date->addMonth(); // Mulai bulan setelah start_date

                for ($i = 1; $i <= $loan->tenor; $i++) {
                    $currentDueDate = $dueDate->copy()->addMonths($i - 1);

                    $repayments[] = [
                        'loan_id' => $loan->id,
                        'installment_number' => $i,
                        'due_date' => $currentDueDate,
                        'amount' => $loan->monthly_payment,
                        'status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    if ($i == $loan->tenor) {
                        $loan->end_date = $currentDueDate;
                    }
                }

                $loan->end_date = $dueDate;


                Repayment::insert($repayments);
            } else {
                $loan->status = 'rejected';
            }

            $loan->save();
        });

        return redirect()->back()->with('success', 'Status Peminjaman berhasil dupdate.');
    }
}
