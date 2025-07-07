<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $loans = Loan::where('user_id', Auth::user()->id)
            ->with('next_repayment')
            ->whereNot('status', 'draft')
            ->get();

        return view('pages.user.transactions', compact('loans'));
    }
    public function payment($id)
    {
        $loan = Loan::where('user_id', Auth::user()->id)
            ->with(['repayments', 'next_repayment'])
            ->find($id);

        return view('pages.user.payment', compact('loan'));
    }
    public function detailPayment($id)
    {
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $loan = Loan::where('user_id', Auth::user()->id)
            ->with('repayments')
            ->find($id);

        return view('pages.user.detail-payment', compact(['loan', 'paymentMethods']));
    }

    public function pay(Request $request, $id)
    {
        $validate = $request->validate(
            [
                'proof' => 'required',
            ],
            [
                'proof.required' => 'Bukti pembayaran harus diunggah.',
            ]
        );

        if ($request->has('proof')) {
            $file = $validate['proof'];
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Nama file tanpa ekstensi
            $extension = $file->getClientOriginalExtension(); // Ekstensi file
            $filename = $originalName . '-' . uniqid() . '.' . $extension; // Gabungkan dengan ID unik

            $file->storeAs('proof_payment', $filename);

            if ($request->input('metode') == 'transfer') {
                $method_id = $request->input('bank');
            } else {
                $method_id = $request->input('qris_1');
            }

            Transaction::insert([
                'repayment_id' => $id,
                'payment_method_id' => $method_id,
                'amount' => $request->input('amount'),
                'payment_proof_path' => $filename,
                'paid_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil melakukan pembayaran, mohon tunggu admin melakunan verfikasi pembayaran.');
    }
}
