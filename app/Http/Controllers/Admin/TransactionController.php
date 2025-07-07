<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Repayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $data = Transaction::with(['repayment', 'payment_method', 'repayment.loan'])->paginate(25);
        return view('pages.admin.transactions', compact('data'));
    }

    public function update($id, Request $request)
    {
        $transaction = Transaction::with('repayment')->find($id);
        try {
            DB::transaction(function () use ($request, $transaction) {
                // Pastikan repayment exists
                if (!$transaction->repayment) {
                    throw new \Exception('Repayment not found');
                }

                $paidDate = Carbon::parse($transaction->paid_date);
                $dueDate = Carbon::parse($transaction->repayment->due_date);

                $status = $paidDate->gt($dueDate) ? 'late' : 'paid';

                // Lock row untuk prevent race condition
                $repayment = Repayment::lockForUpdate()->find($transaction->repayment->id);

                $repayment->update([
                    'status' => $status,
                    'paid_date' => $paidDate->format('Y-m-d')
                ]);

                $transaction->update([
                    'status' => 1,
                    'updated_at' => now()
                ]);
            });

            return redirect()->back()->with('success', 'Berhasil konfirmasi pembayaran.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal konfirmasi: ' . $e->getMessage());
        }

    }
}
