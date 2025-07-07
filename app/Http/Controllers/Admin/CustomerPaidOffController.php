<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerPaidOffController extends Controller
{
    public function index(Request $request)
    {
        $today = now()->format('Y-m-d');

        $data = Loan::with([
            'repayments'
        ])
            ->whereIn('status', ['approved', 'paid'])
            ->paginate(25);
        // dd($data);
        return view('pages.admin.customer-paid-off', compact('data'));
    }

}
